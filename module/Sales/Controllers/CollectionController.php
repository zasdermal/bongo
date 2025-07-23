<?php

namespace Module\Sales\Controllers;

use App\Http\Controllers\Controller;


use App\Models\Depot;
use App\Models\DepotStockProduct;
use App\Models\Order;
use App\Models\ReturnTrack;
use App\Models\Transection;

use App\Imports\CollectionsImport;

use App\Models\User;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\DailyStockService;
use Illuminate\Support\Carbon;


use Module\Sales\Models\Collection;

class CollectionController extends Controller
{
    public function dues(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Collection', 'url' => null],
            ['title' => 'Dues', 'url' => null]
        ];

        $query = Collection::query();
        $today = Carbon::today();

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        // if ($request->filled('invoice_number')) {
        //     $invoice_number = $request->invoice_number;
        //     $query->whereHas('order_invoice', function ($subQ) use ($invoice_number) {
        //         $subQ->where('invoice_number', $invoice_number);
        //     });
        // }

        // if ($request->filled('username')) {
        //     $user_id = User::where('username', $request->username)->value('id');
        //     $query->whereHas('order_invoice', function ($subQ) use ($user_id) {
        //         $subQ->where('user_id', $user_id);
        //     });
        // }

        // if ($request->filled('code_number')) {
        //     $code_number = $request->code_number;
        //     $query->whereHas('order_invoice.sales_point', function ($subQ) use ($code_number) {
        //         $subQ->where('code_number', $code_number);
        //     });
        // }

        // if ($request->filled('depot_id')) {
        //     $depot_id = $request->depot_id;
        //     $query->whereHas('order_invoice.sales_point', function ($subQ) use ($depot_id) {
        //         $subQ->where('depot_id', $depot_id);
        //     });
        // }

        // if ($request->filled('payment_type')) {
        //     $payment_type = $request->payment_type;
        //     $query->whereHas('order_invoice.sales_point', function ($subQ) use ($payment_type) {
        //         $subQ->where('payment_type', $payment_type);
        //     });
        // }

        $query->whereHas('orderInvoice', function ($subQuery) use ($fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                    $subQuery->whereBetween('order_invoices.updated_at', [$fromDate, $toDate]);
            } else {
                $subQuery->whereDate('order_invoices.updated_at', $today);
            }
        });
        
        $query->whereIn('status', ['Due', 'Partial Payment']);

        $collections = $query->orderBy('id', 'desc')->get();

        foreach ($collections as $collection) {
            $total_partial_paid = Collection::where('order_invoice_id', $collection->order_invoice_id)
                ->where('status', 'Partial | Paid')
                ->sum('partial_paid');

            $total_addi_dis_amount = Collection::where('order_invoice_id', $collection->order_invoice_id)
                ->where('status', 'Partial | Paid')
                ->sum('addi_dis_amount');

            // $total_return_amount = Collection::where('order_invoice_id', $collection->order_invoice_id)
            //     // ->where('status', 'Partial | Paid')
            //     ->sum('return_amount');

            $collection->previous_payment = $total_partial_paid;
            $collection->previous_addi_dis_amount = $total_addi_dis_amount;
            // $collection->previous_return_amount = $total_return_amount;
        }
        
        $data['collections'] = $collections;

        return view('Sales::collection.dues', $data);
    }

    public function partial_dues(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Collections Report', 'url' => null],
            ['title' => 'Partial Dues', 'url' => null]
        ];
        $data['partial_payment'] = Collection::where('status', 'Partial Payment')->get();

        return view('collections_report.partial_dues', $data);
    }

    public function collection($id)
    {
        $collection = Collection::with(
            'order_invoice.orders.depot_stock_product',
            'order_invoice.depot',
            'order_invoice.sales_point',
            'order_invoice.delivery_man.employee',
            'order_invoice.user.employee'
        )->find($id);
        
        $total_partial_paid = Collection::where('order_invoice_id', $collection->order_invoice_id)
            ->where('status', 'Partial | Paid')
            ->sum('partial_paid');

        $total_addi_dis_amount = Collection::where('order_invoice_id', $collection->order_invoice_id)
            ->where('status', 'Partial | Paid')
            ->sum('addi_dis_amount');

        $total_return_amount = Collection::where('order_invoice_id', $collection->order_invoice_id)
            ->sum('return_amount');

        return response()->json([
            'collection' => $collection,
            'total_partial_paid' => $total_partial_paid,
            'total_addi_dis_amount' => $total_addi_dis_amount,
            'total_return_amount' => $total_return_amount,
        ]);
    }

    public function update(Request $request, $id)
    {
        $auth_user = Auth::user()->id;

        $data = $request->validate([
            'ait' => 'nullable|numeric',
            'additional_discount' => 'nullable|numeric',
            'collected_payment' => 'nullable|numeric',
        ]);

        $ait = $data['ait'] ?? null;
        $additional_discount = $data['additional_discount'] ?? null;

        // $total_payment = $data['additional_discount'] + $data['collected_payment'];

        // return response()->json([
        //     'total_payment' => $total_payment
        // ]);

        // dd($total_payment);

        $collection = Collection::findOrFail($id);
        
        if ($ait || $additional_discount) {

            $due_amount = $collection->collection_amount - $collection->return_amount - $ait - $additional_discount;

            $collection->update([
                'ait' => $ait ?? null,
                'addi_dis_amount' => $additional_discount ?? null,
                'due' => $due_amount
            ]);

            if ($collection->status === 'Due') {
                if ($data['collected_payment'] == $collection->due) {
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Paid',
                        'full_paid' => $due_amount,
                        'due' => 0.00
                    ]);
                } else {
                    $rest_amount = $collection->collection_amount - $collection->ait - $collection->addi_dis_amount - $collection->return_amount - $data['collected_payment'];
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Partial | Paid',
                        'partial_paid' => $data['collected_payment'],
                        'due' => $rest_amount
                    ]);
    
                    Collection::create([
                        'order_invoice_id' => $collection->order_invoice_id,
                        'status' => 'Partial Payment',
                        'collection_amount' => $rest_amount,
                        'due' => $rest_amount,
                    ]);
                }
            }

            if ($collection->status === 'Partial Payment') {
                if ($data['collected_payment'] == $collection->due) {
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Paid',
                        'full_paid' => $due_amount,
                        'due' => 0.00
                    ]);
                } else {
                    $rest_amount = $collection->collection_amount - $collection->ait - $collection->addi_dis_amount - $collection->return_amount - $data['collected_payment'];
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Partial | Paid',
                        'partial_paid' => $data['collected_payment'],
                        'due' => $rest_amount
                    ]);
    
                    Collection::create([
                        'order_invoice_id' => $collection->order_invoice_id,
                        'status' => 'Partial Payment',
                        'collection_amount' => $rest_amount,
                        'due' => $rest_amount,
                    ]);
                }
            }
        } else {
            if ($collection->status === 'Due') {
                if ($data['collected_payment'] == $collection->due) {
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Paid',
                        'full_paid' => $data['collected_payment'],
                        'due' => 0.00
                    ]);
                } else {
                    $rest_amount = $collection->collection_amount - $collection->return_amount - $data['collected_payment'];
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Partial | Paid',
                        'partial_paid' => $data['collected_payment'],
                        'due' => $rest_amount
                    ]);
    
                    Collection::create([
                        'order_invoice_id' => $collection->order_invoice_id,
                        'status' => 'Partial Payment',
                        'collection_amount' => $rest_amount,
                        'due' => $rest_amount
                    ]);
                }      
            }
    
            if ($collection->status === 'Partial Payment') {
                if ($data['collected_payment'] == $collection->due) {
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Paid',
                        'full_paid' => $data['collected_payment'],
                        'due' => 0.00
                    ]);
                } else {
                    $rest_amount = $collection->collection_amount - $collection->return_amount - $data['collected_payment'];
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Partial | Paid',
                        'partial_paid' => $data['collected_payment'],
                        'due' => $rest_amount
                    ]);
    
                    Collection::create([
                        'order_invoice_id' => $collection->order_invoice_id,
                        'status' => 'Partial Payment',
                        'collection_amount' => $rest_amount,
                        'due' => $rest_amount,
                    ]);
                }     
            }
        }

        return response()->json([
            'collected_payment' => $data['collected_payment'],
            'additional_discount' => $data['additional_discount']
        ]);
    }

    public function updateCopy2(Request $request, $id) 
    {
        $auth_user = Auth::user()->id;

        $data = $request->validate([
            'collected_payment' => 'required|numeric',
            'additional_discount' => 'nullable|numeric'
        ]);

        $additional_discount = $data['additional_discount'] ?? 0;
        $collected_payment = $data['collected_payment'];

        $collection = Collection::findOrFail($id);

        // Handle both additional_discount and collected_payment
        if ($additional_discount > 0) {
            // Update collection for additional discount first
            $collection_amount = $collection->collection_amount - $additional_discount;

            $collection->update([
                'collection_amount' => $collection_amount,
                'addi_dis_amount' => $additional_discount
            ]);

            if ($collection->status === 'Due') {
                if ($collection_amount === $collection->collection_amount) {
                    $collection->update([
                        'user_id' => $auth_user,
                        'status' => 'Paid',
                        'full_paid' => $collection_amount,
                        'due' => 0.00
                    ]);
                }
            } 
        }

        // Handle collected_payment logic
        if ($collection->status === 'Due') {
            if ($collected_payment === $collection->collection_amount) {
                $collection->update([
                    'user_id' => $auth_user,
                    'status' => 'Paid',
                    'full_paid' => $collected_payment,
                    'due' => 0.00
                ]);
            } else {
                $rest_amount = $collection->collection_amount - $collected_payment;
                $collection->update([
                    'user_id' => $auth_user,
                    'status' => 'Partial | Paid',
                    'partial_paid' => $collected_payment,
                    'due' => $rest_amount
                ]);

                Collection::create([
                    'order_invoice_id' => $collection->order_invoice_id,
                    'status' => 'Partial Payment',
                    'collection_amount' => $collection->due,
                ]);
            }
        } elseif ($collection->status === 'Partial Payment') {
            if ($collected_payment === $collection->collection_amount) {
                $collection->update([
                    'user_id' => $auth_user,
                    'status' => 'Paid',
                    'full_paid' => $collected_payment,
                    'due' => 0.00
                ]);
            } else {
                $rest_amount = $collection->collection_amount - $collected_payment;
                $collection->update([
                    'user_id' => $auth_user,
                    'status' => 'Partial | Paid',
                    'partial_paid' => $collected_payment,
                    'due' => $rest_amount
                ]);

                Collection::create([
                    'order_invoice_id' => $collection->order_invoice_id,
                    'status' => 'Partial Payment',
                    'collection_amount' => $collection->due,
                ]);
            }
        }

        return response()->json([
            'collected_payment' => $collected_payment,
            'additional_discount' => $additional_discount
        ]);
    }


    // not needed for now

    protected function updateCollectionAsPaid(Collection $collection, $auth_user, $payment)
    {
        $collection->update([
            'user_id' => $auth_user,
            'status' => 'Paid',
            'full_paid' => $payment,
            'due' => 0.00,
        ]);
    }

    protected function updateCollectionAsPartial(Collection $collection, $auth_user, $payment)
    {
        $rest_amount = $collection->collection_amount - $payment;

        $collection->update([
            'user_id' => $auth_user,
            'status' => 'Partial | Paid',
            'partial_paid' => $payment,
            'due' => $rest_amount,
        ]);

        Collection::create([
            'order_invoice_id' => $collection->order_invoice_id,
            'status' => 'Partial Payment',
            'collection_amount' => $rest_amount,
        ]);
    }


    public function updateCopy(Request $request, $id)
    {
        $auth_user = Auth::id();

        $data = $request->validate([
            'collected_payment' => 'required|numeric',
            'additional_discount' => 'nullable|numeric|min:0',
        ]);

        $additional_discount = $data['additional_discount'] ?? 0;

        $collection = Collection::findOrFail($id);

        DB::transaction(function () use ($collection, $auth_user, $data, $additional_discount) {
            if ($additional_discount > 0) {
                $collection_amount = $collection->collection_amount - $additional_discount;
                $collection->update([
                    'collection_amount' => $collection_amount,
                    'addi_dis_amount' => $additional_discount,
                ]);
            }

            if (in_array($collection->status, ['Due', 'Partial Payment'])) {
                if ($data['collected_payment'] === $collection->collection_amount) {
                    $this->updateCollectionAsPaid($collection, $auth_user, $data['collected_payment']);
                } else {
                    $this->updateCollectionAsPartial($collection, $auth_user, $data['collected_payment']);
                }
            }
        });

        return response()->json([
            'collected_payment' => $data['collected_payment'],
            'additional_discount' => $data['additional_discount'],
        ]);
    }

    // not needed for now


    public function collected_payment(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Collections Report', 'url' => null],
            ['title' => 'Collected Payment', 'url' => null]
        ];
        $data['collected_payment'] = Collection::whereIn('status', ['Paid', 'Partial Payment', 'Partial | Paid'])->get();

        return view('collections_report.collected_payment', $data);
    }

    public function return_order(Request $request, $id)
    {
        $auth_user = Auth::user()->id;
        $collection = Collection::findOrFail($id);

        foreach ($collection->order_invoice->orders as $order) {
            $order->update([
                'quantity' => 0,
                'return_qty' => $order->quantity,
                'total_amount' => 0.00
            ]);

            $depot_stock_product = $order->depot_stock_product;

            $previous_stock = $depot_stock_product->quantity;
            $depot_stock_product->update([
                'quantity' => $previous_stock + $order->return_qty
            ]);

            $ware_house_stock = WarehouseStock::where('id', $order->depot_stock_product->warehouse_stock_id)->first();
            $curr_all_de_stock = DepotStockProduct::where('sku', $order->sku)->get();
            $total_stock = $curr_all_de_stock->sum('quantity') + $ware_house_stock->quantity;

            // $previous_stock = Transection::where('sku', $order->sku)
            //     ->orderBy('created_at', 'desc') // or use 'id' if your transactions are sequential
            //     ->first();

            // $previous_national_stock = $previous_stock ? $previous_stock->curr_national_stock : 0;

            Transection::create([
                'depot_id' => $order->depot_stock_product->depot_id,
                'product_name' => $order->product_name,
                'sku' => $order->sku,
                'invoice_number' => $collection->order_invoice->invoice_number,
                'order_number' => $order->order_number,
                'tran_type' => 'Sales Point to Depot',
                'status' => 'Return',
                'pre_stock' => $previous_stock,
                'tran_quant' => $order->return_qty,
                'curr_stock' => $depot_stock_product->quantity,
                'national_stock' => $total_stock
            ]);
        }

        $collection->order_invoice->update([
            'status' => 'Return',
            'sell_discount_amount' => 0.00,
            'return_amount' => $collection->order_invoice->total_amount
        ]);

        $collection->update([
            'user_id' => $auth_user,
            'status' => 'Return',
            'collection_amount' => $collection->order_invoice->total_amount,
            'due' => 0.00,
            'return_amount' => $collection->order_invoice->total_amount
        ]);

        $this->daily_stock_service->storeDailyStock();

        return redirect()->route('collections_report.dues');
        // return response()->json(['message' => 'Successfully Return'], 200);
    }

    public function return_order_and_edit_invoice(Request $request, $id)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Order Management', 'url' => null],
            ['title' => 'Return Order and Edit Invoice', 'url' => null]
        ];
        $data['collection'] = Collection::with(
            'order_invoice.orders.depot_stock_product',
            'order_invoice.sales_point.depot', 
            'order_invoice.delivery_man.employee',
            'order_invoice.user.employee'
        )->find($id);

        return view('pages.collections.edit', $data);
    }

    // public function return_order_and_update_invoice(Request $request, $id)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $collection = Collection::findOrFail($id);
    //         $invoice = $collection->order_invoice;
    //         $return_note = $request->return_note;

    //         if (!$invoice) {
    //             DB::rollBack();
    //             return back()->with('error', 'Order invoice not found.');
    //         }

    //         $total_order_amount = 0;
    //         $total_return_value = 0;

    //         foreach ($invoice->orders as $order) {
    //             $order_id = $order->id;

    //             $data = $request->validate([
    //                 'return_qty.' . $order_id => 'nullable|numeric|min:0'
    //             ]);

    //             $return_qty = $data['return_qty'][$order_id] ?? 0;

    //             if ($return_qty > $order->quantity) {
    //                 DB::rollBack();
    //                 return back()->with('error', "Return quantity for order {$order->order_number} exceeds original quantity.");
    //             }

    //             $remain_qty = $order->quantity - $return_qty;
    //             $return_value = $order->unit_price * $return_qty;

    //             $order->update([
    //                 'quantity' => $remain_qty,
    //                 'return_qty' => $order->return_qty + $return_qty,
    //                 'total_amount' => $order->unit_price * $remain_qty,
    //             ]);

    //             $total_order_amount += $order->unit_price * $remain_qty;
    //             $total_return_value += $return_value;

    //             $depot_stock_product = $order->depot_stock_product;
    //             if (!$depot_stock_product) {
    //                 DB::rollBack();
    //                 return back()->with('error', "Depot stock product not found for order {$order->order_number}.");
    //             }

    //             $previous_stock = $depot_stock_product->quantity;
    //             $updated_quantity = $previous_stock + $return_qty;

    //             $depot_stock_product->update([
    //                 'quantity' => $updated_quantity,
    //             ]);

    //             if ($return_qty > 0) {
    //                 $warehouse_stock = WarehouseStock::find($depot_stock_product->warehouse_stock_id);
    //                 if (!$warehouse_stock) {
    //                     DB::rollBack();
    //                     return back()->with('error', 'Warehouse stock not found.');
    //                 }

    //                 $curr_all_de_stock = DepotStockProduct::where('sku', $order->sku)->get();
    //                 $total_stock = $curr_all_de_stock->sum('quantity') + $warehouse_stock->quantity;

    //                 Transection::create([
    //                     'depot_id' => $depot_stock_product->depot_id,
    //                     'product_name' => $order->product_name,
    //                     'sku' => $order->sku,
    //                     'invoice_number' => $invoice->invoice_number,
    //                     'order_number' => $order->order_number,
    //                     'tran_type' => 'Sales Point to Depot',
    //                     'status' => 'Return',
    //                     'pre_stock' => $previous_stock,
    //                     'tran_quant' => $return_qty,
    //                     'curr_stock' => $updated_quantity,
    //                     'national_stock' => $total_stock,
    //                     'sales_value' => $return_value,
    //                 ]);
    //             }
    //         }

    //         // Update invoice
    //         $discount_amount = 0;
    //         if ($invoice->sell_discount > 0) {
    //             $discount_amount = ($invoice->sell_discount / 100) * $total_order_amount;
    //         }

    //         $invoice->update([
    //             'sell_discount_amount' => $discount_amount,
    //             'status' => 'Partial Return',
    //             'return_amount' => $invoice->return_amount + $total_return_value,
    //             'return_note' => $return_note ?? $invoice->return_note
    //         ]);

    //         // Update collection
    //         $collection_amount = $invoice->total_amount - $discount_amount;
    //         $collection->update([
    //             'collection_amount' => $collection_amount,
    //             'return_amount' => $collection->return_amount + $total_return_value,
    //             'due' => $collection->collection_amount - $total_return_value - $collection->return_amount,
    //         ]);

    //         $this->daily_stock_service->storeDailyStock();

    //         DB::commit();

    //         return redirect()->route('collections_report.dues')->with('success', 'Return processed successfully.');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    //     }
    // }

    public function return_order_and_update_invoice(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $collection = Collection::find($id);
            $invoice = $collection->order_invoice;
            $return_note = $request->return_note;

            if (!$invoice) {
                DB::rollBack();
                return back()->with('error', 'Order invoice not found.');
            }

            $total_return_value = 0;

            foreach ($invoice->orders as $order) {
                $order_id = $order->id;
                
                $data = $request->validate([
                    'return_qty.' . $order_id => 'nullable|numeric'
                ]);

                $return_qty = $data['return_qty'][$order_id];

                if ($return_qty > $order->quantity) {
                    DB::rollBack();
                    return back()->with('error', "Return quantity for order {$order->order_number} exceeds original quantity.");
                }

                $remain_qty = $order->quantity - $return_qty;
                $return_value = $order->sell_unit_price * $return_qty;

                $order->update([
                    'quantity' => $remain_qty,
                    'return_qty' => $order->return_qty + $return_qty,
                    'total_amount' => $order->sell_unit_price * $remain_qty
                ]);

                $total_return_value += $return_value;

                $depot_stock_product = $order->depot_stock_product;
                if (!$depot_stock_product) {
                    DB::rollBack();
                    return back()->with('error', "Depot stock product not found for order {$order->order_number}.");
                }

                $previous_stock = $depot_stock_product->quantity;
                $updated_quantity = $previous_stock + $return_qty;

                $depot_stock_product->update([
                    'quantity' => $updated_quantity,
                ]);

                if ($return_qty > 0) {
                    $warehouse_stock = WarehouseStock::find($depot_stock_product->warehouse_stock_id);
                    if (!$warehouse_stock) {
                        DB::rollBack();
                        return back()->with('error', 'Warehouse stock not found.');
                    }

                    $curr_all_de_stock = DepotStockProduct::where('sku', $order->sku)->get();
                    $total_stock = $curr_all_de_stock->sum('quantity') + $warehouse_stock->quantity;

                    ReturnTrack::create([
                        'order_invoice_id' => $collection->order_invoice->id,
                        'order_id' => $order->id,
                        'user_id' => auth()->user()->id,
                        'product_name' => $order->product_name,
                        'sku' => $order->sku,
                        'return_qty' => $return_qty
                    ]);

                    Transection::create([
                        'depot_id' => $order->depot_stock_product->depot_id,
                        'product_name' => $order->product_name,
                        'sku' => $order->sku,
                        'invoice_number' => $collection->order_invoice->invoice_number,
                        'order_number' => $order->order_number,
                        'tran_type' => 'Sales Point to Depot',
                        'status' => 'Return',
                        'pre_stock' => $previous_stock,
                        'tran_quant' => $return_qty,
                        'curr_stock' => $order->depot_stock_product->quantity,
                        'national_stock' => $total_stock,
                        'sales_value' => $return_value
                    ]);
                }
            }

            $collection->order_invoice->update([
                'status' => 'Partial Return',
                'return_amount' => $collection->order_invoice->return_amount + $total_return_value,
                'return_note' => $return_note ?? $collection->order_invoice->return_note
            ]);

            $collection->update([
                'return_amount' => $collection->return_amount + $total_return_value,
                'due' => $collection->collection_amount - ($collection->return_amount + $total_return_value)
            ]);

            $this->daily_stock_service->storeDailyStock();

            DB::commit();

            return redirect()->route('collections_report.dues')->with('success', 'Return processed successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    // public function return_order_and_update_invoice(Request $request, $id) // worked perfectly
    // {
    //     $collection = Collection::find($id);
    //     $return_note = $request->return_note;

    //     if ($collection) {
    //         $total_return_value = 0;

    //         foreach ($collection->order_invoice->orders as $order) {
    //             $order_id = $order->id;
                
    //             $data = $request->validate([
    //                 'return_qty.' . $order_id => 'nullable|numeric'
    //             ]);

    //             $return_qty = $data['return_qty'][$order_id];

    //             // if ($return_qty != 0) {

    //             $order = Order::find($order_id);
    //             $remain_qty = $order->quantity - $return_qty;
    //             $order->update([
    //                 'quantity' => $order->quantity - $return_qty,
    //                 'return_qty' => $order->return_qty + $return_qty,
    //                 'total_amount' => $order->sell_unit_price * $remain_qty
    //             ]);

    //             $previous_stock = $order->depot_stock_product->quantity;
    //             $updated_quantity = $previous_stock + $return_qty;
    //             $order->depot_stock_product->update([
    //                 'quantity' => $updated_quantity,
    //             ]);

    //             if ($return_qty != 0) {
    //                 $ware_house_stock = WarehouseStock::where('id', $order->depot_stock_product->warehouse_stock_id)->first();
    //                 $curr_all_de_stock = DepotStockProduct::where('sku', $order->sku)->get();
    //                 $total_stock = $curr_all_de_stock->sum('quantity') + $ware_house_stock->quantity;

    //                 $return_value = $order->sell_unit_price * $return_qty;
    //                 $total_return_value += $return_value;

    //                 ReturnTrack::create([
    //                     'order_invoice_id' => $collection->order_invoice->id,
    //                     'order_id' => $order->id,
    //                     'user_id' => auth()->user()->id,
    //                     'product_name' => $order->product_name,
    //                     'sku' => $order->sku,
    //                     'return_qty' => $return_qty
    //                 ]);

    //                 Transection::create([
    //                     'depot_id' => $order->depot_stock_product->depot_id,
    //                     'product_name' => $order->product_name,
    //                     'sku' => $order->sku,
    //                     'invoice_number' => $collection->order_invoice->invoice_number,
    //                     'order_number' => $order->order_number,
    //                     'tran_type' => 'Sales Point to Depot',
    //                     'status' => 'Return',
    //                     'pre_stock' => $previous_stock,
    //                     'tran_quant' => $return_qty,
    //                     'curr_stock' => $order->depot_stock_product->quantity,
    //                     'national_stock' => $total_stock,
    //                     'sales_value' => $return_value
    //                 ]);
    //             }
    //         }

    //         $collection->order_invoice->update([
    //             'status' => 'Partial Return',
    //             'return_amount' => $collection->order_invoice->return_amount + $total_return_value,
    //             'return_note' => $return_note ?? $collection->order_invoice->return_note
    //         ]);

    //         $collection->update([
    //             'return_amount' => $collection->return_amount + $total_return_value,
    //             'due' => $collection->collection_amount - ($collection->return_amount + $total_return_value)
    //         ]);
    //     }

    //     $this->daily_stock_service->storeDailyStock();

    //     return redirect()->route('collections_report.dues');
    // }

    // public function return_order_and_update_invoice(Request $request, $id)
    // {
    //     $collection = Collection::find($id);

    //     if ($collection) {
    //         $validated_data = $request->validate([
    //             'invoice_total_amount' => 'required|numeric',
    //         ]);

    //         if ($collection->order_invoice->sell_discount > 0) {
    //             $get_percent_amount = ($collection->order_invoice->sell_discount / 100) * $validated_data['invoice_total_amount'];
                
    //             $collection->order_invoice->update([
    //                 'sell_discount_amount' => $get_percent_amount
    //             ]);
    //         }

    //         foreach ($collection->order_invoice->orders as $order) {
    //             $order_id = $order->id;
                
    //             $validated_order_data = $request->validate([
    //                 'quantity.' . $order_id => 'required|numeric',
    //                 'product_total_amount.' . $order_id => 'required|numeric',
    //                 // Add validation rules for other product fields as needed
    //             ]);

    //             $order = Order::find($order_id);
    //             $return_value = $order->total_amount - $validated_order_data['product_total_amount'][$order_id];
    //             $return_quantity = $order->quantity - $validated_order_data['quantity'][$order_id];
    //             \Log::info('return quantity: ' . $return_quantity);
    //             $order->update([
    //                 'quantity' => $validated_order_data['quantity'][$order_id],
    //                 'return_qty' => $order->return_qty + $return_quantity,
    //                 'total_amount' => $validated_order_data['product_total_amount'][$order_id],
    //             ]);

    //             // $depot_stock = $order->depot_stock;
    //             // \Log::info('data: ', ['depot' => $depot_stock]);

    //             $previous_stock = $order->depot_stock_product->quantity;
    //             $updated_quantity = $previous_stock + $return_quantity;
    //             \Log::info('updated quantity: ' . $updated_quantity);
    //             $order->depot_stock_product->update([
    //                 'quantity' => $updated_quantity,
    //             ]);

    //             if ($return_quantity !== 0) {
    //                 $ware_house_stock = WarehouseStock::where('id', $order->depot_stock_product->warehouse_stock_id)->first();
    //                 $curr_all_de_stock = DepotStockProduct::where('sku', $order->sku)->get();
    //                 $total_stock = $curr_all_de_stock->sum('quantity') + $ware_house_stock->quantity;

    //                 // $previous_stock = Transection::where('sku', $order->sku)
    //                 //     ->orderBy('created_at', 'desc') // or use 'id' if your transactions are sequential
    //                 //     ->first();

    //                 // $previous_national_stock = $previous_stock ? $previous_stock->curr_national_stock : 0;

    //                 Transection::create([
    //                     'depot_id' => $order->depot_stock_product->depot_id,
    //                     'product_name' => $order->product_name,
    //                     'sku' => $order->sku,
    //                     'invoice_number' => $collection->order_invoice->invoice_number,
    //                     'order_number' => $order->order_number,
    //                     'tran_type' => 'Sales Point to Depot',
    //                     'status' => 'Return',
    //                     'pre_stock' => $previous_stock,
    //                     'tran_quant' => $return_quantity,
    //                     'curr_stock' => $order->depot_stock_product->quantity,
    //                     'national_stock' => $total_stock,
    //                     'sales_value' => $return_value
    //                 ]);
    //             }
    //         }

    //         $collection_amount = $collection->order_invoice->total_amount - $collection->order_invoice->sell_discount_amount;
    //         $return_amount = $collection->order_invoice->total_amount - $collection->order_invoice->return_amount - $validated_data['invoice_total_amount'];

    //         $collection->order_invoice->update([
    //             'status' => 'Partial Return',
    //             'return_amount' => $collection->order_invoice->return_amount += $return_amount
    //         ]);

    //         if ($collection->order_invoice->sell_discount > 0) {
    //             $collection->update([
    //                 'collection_amount' => $collection_amount,
    //                 'return_amount' => $return_amount,
    //                 'due' => $collection_amount - $return_amount
    //             ]);
    //         } else {
    //             $collection->update([
    //                 'return_amount' => $return_amount,
    //                 'due' => $collection->collection_amount - $return_amount
    //             ]);
    //         }
            
    //     }

    //     $this->daily_stock_service->storeDailyStock();

    //     return redirect()->route('collections_report.dues');
    // }

    public function bulk_upload_collections(Request $request)
    {
        // dd($request->file('file'));
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new CollectionsImport, $request->file('file'));

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }
}
