<?php

namespace Module\Sales\Controllers;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Module\Access\Models\User;
use Module\Inventory\Models\Stock;

use Module\Sales\Models\Order;
use Module\Sales\Models\Collection;
use Module\Sales\Models\OrderInvoice;

class OrderInvoiceController extends Controller
{
    public function invoices(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Order', 'url' => null],
            ['title' => 'Invoices', 'url' => null]
        ];

        $today = Carbon::today();
        $query = OrderInvoice::query();

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        if ($request->filled('username')) {
            $user_id = User::where('username', $request->username)->value('id');
            $query->where('user_id', $user_id);
        }

        // if ($request->filled('code_number')) {
        //     $code_number = $request->code_number;
        //     $query->whereHas('salePoint', function ($subQuery) use ($code_number) {
        //         $subQuery->where('code_number', $code_number);
        //     });
        // }

        if ($fromDate && $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
        } else {
            $query->whereDate('created_at', $today);
        }

        $query->where('status', 'Requested');

        $total_query = $query->get();
        $data['orderInvoices'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['invoice'] = $total_query->count();
        $data['order_value'] = $total_query->sum('total_amount');

        return view('Sales::order.invoices', $data);
    }

    public function create(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Order', 'url' => null],
            ['title' => 'Create Invoice', 'url' => null]
        ];

        $data['users'] = User::whereHas('employee.designation', function ($query) {
            $query->where('slug', 'marketing-officer');
        })
        ->get();
        $data['stocks'] = Stock::all();

        return view('Sales::order.create_invoice', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'sale_point_id' => 'required|exists:sale_points,id',
            'territory_id' => 'required|exists:territories,id',
            'total_amount' => 'required|numeric',
            'orders' => 'required|array',
            'orders.*.stock_id' => 'required|exists:stocks,id',
            'orders.*.product_name' => 'required',
            'orders.*.sku' => 'required',
            'orders.*.quantity' => 'required|numeric|min:1',
            'orders.*.unit_price' => 'required|numeric',
            'orders.*.order_total_amount' => 'required|numeric'
        ]);

        $auth_user = Auth::user();

        $orderInvoice = OrderInvoice::create([
            'user_id' => $data['user_id'],
            'submitted_by_user_id' => $auth_user->id,
            'sale_point_id' => $data['sale_point_id'],
            'territory_id' => $data['territory_id'],
            'invoice_number' => $this->generate_unique_invoice_number(),
            'total_amount' => $data['total_amount']
        ]);

        foreach ($data['orders'] as $order) {
            $order = Order::create([
                'stock_id' => $order['stock_id'],
                'order_number' => $this->generate_unique_order_number(),
                'product_name' => $order['product_name'],
                'sku' => $order['sku'],
                'quantity' => $order['quantity'],
                'unit_price' => $order['unit_price'],
                'total_amount' => $order['order_total_amount']
            ]);

            $orderInvoice->orders()->attach($order);
        }

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'The order has been submited successfully',
        ], 200);
    }

    public function invoice(Request $request, $id)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Order', 'url' => null],
            ['title' => 'Invoice', 'url' => null]
        ];

        $orderInvoice = OrderInvoice::findOrFail($id);
        $data['orderInvoice'] = $orderInvoice;

        // Convert Grand Total to Words using NumberFormatter
        $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        $grandTotalInWords = ucwords($formatter->format($orderInvoice->total_amount)) . ' Taka Only';

        $data['grand_total_in_words'] = $grandTotalInWords;

        return view('Sales::order.invoice', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $orderInvoice = OrderInvoice::findOrFail($id);

            foreach ($orderInvoice->orders as $order) {
                $stock = $order->stock;

                if (!$stock) {
                    DB::rollBack();
                    return response()->json(['error' => 'Stock not found.'], 404);
                }
    
                $previous_quantity = $stock->quantity;
                $new_quantity = $previous_quantity - $order->quantity;

                if ($new_quantity < 0) {
                    DB::rollBack();
                    return response()->json(['error' => 'Insufficient stock for SKU: ' . $order->sku], 400);
                }

                $stock->update([
                    'quantity' => $new_quantity
                ]);

                // $curr_all_de_stock = DepotStockProduct::where('sku', $order->sku)->get();
                // $total_stock = $curr_all_de_stock->sum('quantity') + $ware_house_stock->quantity;
    
                // Transection::create([
                //     'depot_id' => $order->depot_stock_product->depot_id,
                //     'stock_out_depot_name' => $order->depot_stock_product->depot->name,
                //     'product_name' => $order->product_name,
                //     'sku' => $order->sku,
                //     'invoice_number' => $order_invoice->invoice_number,
                //     'order_number' => $order->order_number,
                //     'tran_type' => 'Depot to Sales Point',
                //     'status' => 'Stock Out',
                //     'pre_stock' => $previous_stock,
                //     'tran_quant' => $order->quantity,
                //     'curr_stock' => $depot_stock_product->quantity,
                //     'national_stock' => $total_stock,
                //     'sales_value' => $order->total_amount
                // ]);
            }

            Collection::create([
                'order_invoice_id' => $orderInvoice->id,
                'collection_amount' => $orderInvoice->total_amount,
                'due' => $orderInvoice->total_amount
            ]);

            $orderInvoice->update([
                'updated_by_user_id' => auth()->user()->id,
                'status' => 'Accepted',
                'invoice_date' => Carbon::now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order Invoice approved Successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function cancel($id)
    {
        $orderInvoice = OrderInvoice::findOrFail($id);
        $orderInvoice->update([
            'status' => 'Cancel'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Invoice cancel successfully',
        ]);
    }

    public function update_order(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'quantity' => 'required|numeric'
            ]);

            DB::beginTransaction();
    
            $order = Order::findOrFail($id);
            $orderInvoice = $order->orderInvoices->firstOrFail();

            $total_order_amount = $data['quantity'] * $order->unit_price;
            $order->update([
                'quantity' => $data['quantity'],
                'total_amount' => $total_order_amount
            ]);

             // Recalculate invoice total
            $invoiceTotal = $orderInvoice->orders->sum(function ($order) {
                return $order->unit_price * $order->quantity;
            });

            $orderInvoice->update([
                'total_amount' => $invoiceTotal,
            ]);

            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => 'Order and Order Invoice updated Successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Order or Order Invoice not found.'
            ], 404);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function accepted_invoices(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Order', 'url' => null],
            ['title' => 'Accepted Invoices', 'url' => null]
        ];

        $today = Carbon::today();
        $query = OrderInvoice::query();

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        if ($request->filled('invoice_number')) {
            $invoice_number = $request->invoice_number;
            $query->where('invoice_number', $invoice_number);
        }

        if ($request->filled('username')) {
            $user_id = User::where('username', $request->username)->value('id');
            $query->where('user_id', $user_id);
        }

        // if ($request->filled('code_number')) {
        //     $code_number = $request->code_number;
        //     $query->whereHas('sales_point', function ($subQ) use ($code_number) {
        //         $subQ->where('code_number', $code_number);
        //     });
        // }

        if ($fromDate && $toDate) {
                $query->whereBetween('updated_at', [$fromDate, $toDate]);
        } else {
            $query->whereDate('updated_at', $today);
        }

        $query->whereNotIn('status', ['Requested', 'Cancel']);

        $total_query = $query->get();
        $data['orderInvoices'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['invoice'] = $total_query->count();
        $data['order_value'] = $total_query->sum('total_amount');

        return view('Sales::order.accepted_invoices', $data);
    }

    // helper
    private function generate_unique_invoice_number()
    {
        $invoice_number = $this->invoice_number();

        $existing_check = OrderInvoice::where('invoice_number', $invoice_number)->first();

        if ($existing_check) {
            return $this->generate_unique_invoice_number();
        }

        return $invoice_number;
    }

    private function invoice_number()
    {
        $date = now();
        $year = substr($date->year, -2);
        $month = str_pad($date->month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($date->day, 2, '0', STR_PAD_LEFT);

        return 'INV' . $year . $month . $day . mt_rand(1000, 9999);
    }

    private function generate_unique_order_number()
    {
        $order_number = $this->order_number();

        $existing_check = Order::where('order_number', $order_number)->first();

        if ($existing_check) {
            return $this->generate_unique_order_number();
        }

        return $order_number;
    }

    private function order_number()
    {
        $date = now();
        $year = substr($date->year, -2);
        $month = str_pad($date->month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($date->day, 2, '0', STR_PAD_LEFT);

        return 'O' . $year . $month . $day . mt_rand(1000, 9999);
    }
}
