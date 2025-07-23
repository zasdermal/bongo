<?php

namespace Module\Report\Controllers;

use App\Http\Controllers\Controller;


use App\Models\Employee;
use App\Models\MoneyReceiptInvoice;
use App\Models\Order;

use App\Models\Supplier;
use App\Models\Transection;

use App\Models\WarehouseStock;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Module\Access\Models\User;
use Module\Market\Models\SalePoint;
use Module\Sales\Models\Collection;
use Module\Sales\Models\OrderInvoice;


class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null]
        ];

        $data['sale_points'] = SalePoint::where('is_active', 'Active')->orderBy('id', 'desc')->get();

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

        if ($request->filled('code_number')) {
            $code_number = $request->code_number;
            $query->whereHas('salePoint', function ($subQ) use ($code_number) {
                $subQ->where('code_number', $code_number);
            });
        }

        if ($request->filled('depot_id')) {
            $depot_id = $request->depot_id;
            $query->where('depot_id', $depot_id);
        }

        if ($request->filled('payment_type')) {
            $payment_type = $request->payment_type;
            $query->whereHas('salePoint', function ($subQ) use ($payment_type) {
                $subQ->where('payment_type', $payment_type);
            });
        }

        if ($fromDate && $toDate) {
                $query->whereBetween('updated_at', [$fromDate, $toDate]);
        } else {
            $query->whereDate('updated_at', $today);
        }

        $query->whereNotIn('status', ['Requested']);

        $total_query = $query->get();
        $order_invoices = $query->orderBy('id', 'desc')->paginate(30);

        foreach ($order_invoices as $order_invoice) {
            $total_addi_dis_amount = Collection::where('order_invoice_id', $order_invoice->id)
                ->whereIn('status', ['Paid', 'Partial | Paid'])
                ->sum('addi_dis_amount');

            $total_partial_paid = Collection::where('order_invoice_id', $order_invoice->id)
                ->where('status', 'Partial | Paid')
                ->sum('partial_paid');

            $total_full_paid = Collection::where('order_invoice_id', $order_invoice->id)
                ->where('status', 'Paid')
                ->sum('full_paid');
            
            $collection = Collection::where('order_invoice_id', $order_invoice->id)->get()->last();

            $order_invoice->previous_payment = $total_partial_paid + $total_full_paid;
            $order_invoice->previous_addi_dis_amount = $total_addi_dis_amount;
            $order_invoice->due = $collection ? $collection->due : $order_invoice->total_amount - $order_invoice->sell_discount_amount - $order_invoice->return_amount;
        }

        $data['order_invoices'] = $order_invoices;
        
        $data['invoice'] = $total_query->count();
        $data['order_value'] = $total_query->sum('total_amount');
        $data['discount_value'] = $total_query->sum('sell_discount_amount');
        $data['return_value'] = $total_query->sum('return_amount');
        $data['payable_value'] = $data['order_value'] - $data['discount_value'] - $data['return_value'];

        $total_partial_paid = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->where('status', 'Partial | Paid')
            ->sum('partial_paid');

        $total_full_paid = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->where('status', 'Paid')
            ->sum('full_paid');

        $data['total_previous_payment'] = $total_partial_paid + $total_full_paid;

        $data['addi_dis_value'] = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->whereIn('status', ['Paid', 'Partial | Paid'])
            ->sum('addi_dis_amount');

        $collection = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->whereIn('status', ['Due', 'Partial Payment'])
            ->get();

        $data['due'] = $collection ? $collection->sum('due') : $data['order_value'] - $data['discount_value'] - $data['return_value'];

        return view('Report::sales', $data);
    }







    public function delivery_top_sheet(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Delivery Top Sheet', 'url' => null]
        ];

        $data['get_all_delivary_men'] = DeliveryMan::all();
        $query = DeliveryMan::query();
        $today = Carbon::today();

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        // Filter by delivery man ID if provided
        if ($request->filled('delivery_man_id')) {
            $query->where('id', $request->input('delivery_man_id'));
        }

        // Filter by date range or today's date
        $query->whereHas('orderInvoices', function ($subQuery) use ($fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                $subQuery->whereBetween('updated_at', [$fromDate, $toDate]);
            } else {
                $subQuery->whereDate('updated_at', $today);
            }
        });
        // ->with(['orderInvoices' => function ($invoiceQuery) use ($fromDate, $toDate, $today) {
        //     $invoiceQuery->with(['orders' => function ($orderQuery) use ($fromDate, $toDate, $today) {
        //         if ($fromDate && $toDate) {
        //             $orderQuery->whereBetween('orders.created_at', [$fromDate, $toDate]);
        //         } else {
        //             $orderQuery->whereDate('orders.created_at', $today);
        //         }
        //     }])
        //     ->withSum('orders', 'quantity')
        //     ->withSum('orders', 'return_qty');
        // }]);

        $query->with(['orderInvoices' => function ($invoiceQuery) use ($fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                $invoiceQuery->whereBetween('updated_at', [$fromDate, $toDate]);
            } else {
                $invoiceQuery->whereDate('updated_at', $today);
            }
            $invoiceQuery->with('orders');
        }]);

        $data['delivery_men'] = $query->get();

        return view('report.sales.delivery_top_sheet', $data);
    }

    public function delivery_top_sheet_products(Request $request, $id)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Delivery Top Sheet Products', 'url' => null]
        ];

        $data['delivery_man'] = DeliveryMan::where('id', $id)->first();
        $query = Order::query();
        $today = Carbon::today();
        $data['today'] = $today;

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        $orders = $query->whereHas('orderInvoices', function ($subQuery) use ($id, $fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                $subQuery->where('delivery_man_id', $id)
                    ->whereBetween('order_invoices.updated_at', [$fromDate, $toDate]);
            } else {
                $subQuery->where('delivery_man_id', $id)
                    ->whereDate('order_invoices.updated_at', $today);
            }
        })->get();

        $groupedOrders = [];

        foreach ($orders as $order) {
            $sku = $order->sku; // Assuming SKU is the column name

            if (!isset($groupedOrders[$sku])) {
                $groupedOrders[$sku] = [
                    'products'      => $order->product_name, // Assuming product_name is a column
                    'sku'           => $sku,
                    'qty'           => 0,
                    'r_qty'         => 0,
                    'order_value'   => 0,
                ];
            }

            // Accumulate QTY and Order Value
            $groupedOrders[$sku]['qty'] += $order->quantity;
            $groupedOrders[$sku]['r_qty'] += $order->return_qty;
            $groupedOrders[$sku]['order_value'] += $order->total_amount; // Replace with the actual column
        }

        // Convert the grouped array to an indexed array (if needed)
        $groupedOrders = array_values($groupedOrders);

        $data['orders'] = $groupedOrders;
        $data['total_qty'] = collect($data['orders'])->sum('qty') + collect($data['orders'])->sum('r_qty');
        $data['total_return_qty'] = collect($data['orders'])->sum('r_qty');
        $data['total_order_value'] = collect($data['orders'])->sum('order_value');

        return view('report.sales.delivery_top_sheet_products', $data);
    }

    public function delivery_top_sheet_pharmacy(Request $request, $id)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Delivery Top Sheet Pharmacy', 'url' => null],
        ];

        $data['delivery_man'] = DeliveryMan::where('id', $id)->first();
        $query = Order::query();
        $today = Carbon::today();
        $data['today'] = $today;

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        // Retrieve orders and include order_invoices with selected sales_point_id
        $orders = $query->whereHas('orderInvoices', function ($subQuery) use ($id, $fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                $subQuery->where('delivery_man_id', $id)
                    ->whereBetween('order_invoices.updated_at', [$fromDate, $toDate]);
            } else {
                $subQuery->where('delivery_man_id', $id)
                    ->whereDate('order_invoices.updated_at', $today);
            }
        })
        ->with(['orderInvoices' => function ($query) {
            $query->select('sales_point_id'); // Only select necessary fields
        }])
        ->get();

        // Group the orders by SKU and sales point ID (chemist or sales point)
        $groupedOrders = [];

        foreach ($orders as $order) {
            $sku = $order->sku;
            $salesPointId = $order->orderInvoices->first()->sales_point_id ?? 'Unknown'; // Access sales point ID from the orderInvoice
            
            // If no group exists for this sales point, create one
            if (!isset($groupedOrders[$salesPointId])) {
                // Fetch the Sales Point name based on the sales_point_id
                $salesPointName = SalesPoint::find($salesPointId)->name ?? 'Unknown Sales Point';

                $groupedOrders[$salesPointId] = [
                    'sales_point_name' => $salesPointName, // Store sales point name
                    'orders' => [],
                ];
            }

            // If no SKU group exists for this sales point, create one
            if (!isset($groupedOrders[$salesPointId]['orders'][$sku])) {
                $groupedOrders[$salesPointId]['orders'][$sku] = [
                    'products' => $order->product_name, // Assuming product_name is a column
                    'sku' => $sku,
                    'qty' => 0,
                    'r_qty' => 0
                ];
            }

            // Accumulate QTY and Order Value
            $groupedOrders[$salesPointId]['orders'][$sku]['qty'] += $order->quantity;
            $groupedOrders[$salesPointId]['orders'][$sku]['r_qty'] += $order->return_qty;
        }

        // Pass the flattened orders and totals to the view
        $data['orders'] = $groupedOrders;
        $data['total_qty'] = collect($groupedOrders)->reduce(function ($carry, $group) {
            return $carry + collect($group['orders'])->sum(function ($order) {
                return $order['qty'] ?? 0;
            });
        }, 0);
        $data['total_return_qty'] = collect($groupedOrders)->reduce(function ($carry, $group) {
            return $carry + collect($group['orders'])->sum(function ($order) {
                return $order['r_qty'] ?? 0;
            });
        }, 0);

        // Return the view
        return view('report.sales.delivery_top_sheet_pharmacy', $data);
    }

    public function brand_wise_sales(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Brand Wise Sales', 'url' => null]
        ];

        $data['suppliers'] = Supplier::all();
        $data['depots'] = Depot::whereNotIn('slug', ['ware-house'])->get();

        $today = Carbon::today();
        $query = OrderInvoice::query();

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        if ($fromDate && $toDate) {
                $query->whereBetween('updated_at', [$fromDate, $toDate]);
        } else {
            $query->whereDate('updated_at', $today);
        }

        $supplierFiltered = $request->filled('suppliers');
        $suppliers = $request->suppliers ?? [];

        if ($supplierFiltered) {
            
            $query->whereHas('orders', function ($subQuery) use ($suppliers) {
                $subQuery->whereIn('manufacturer', $suppliers);
            });
        }

        $query->whereNotIn('status', ['Requested', 'Cancel']);


        $order_invoices = $query->get();

        $filteredTotals = [];
        $suppliersPerInvoice = [];
        foreach ($order_invoices as $order_invoice) {
            $filteredAmount = 0;
            $suppliersList = [];

            foreach ($order_invoice->orders as $order) {
                if (!$supplierFiltered || in_array($order->manufacturer, $suppliers)) {
                    $filteredAmount += $order->total_amount;
                    $suppliersList[] = $order->manufacturer;
                }
            }

            $filteredTotals[$order_invoice->id] = $filteredAmount;
            $suppliersPerInvoice[$order_invoice->id] = implode(', ', array_unique($suppliersList));

            $total_partial_paid = Collection::where('order_invoice_id', $order_invoice->id)
                ->where('status', 'Partial | Paid')
                ->sum('partial_paid');

            $total_full_paid = Collection::where('order_invoice_id', $order_invoice->id)
                ->where('status', 'Paid')
                ->sum('full_paid');

            $order_invoice->previous_payment = $total_partial_paid + $total_full_paid;
        }

        $data['order_invoices'] = $order_invoices;
        $data['filteredTotals'] = $filteredTotals;
        $data['suppliersPerInvoice'] = $suppliersPerInvoice;

        return view('report.sales.brand_wise_sales', $data);
    }

    public function dues(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Dues', 'url' => null]
        ];

        $data['depots'] = Depot::whereNotIn('slug', ['ware-house'])->get();
        $query = Collection::query();
        $today = Carbon::today();

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        if ($request->filled('invoice_number')) {
            $invoice_number = $request->invoice_number;
            $query->whereHas('order_invoice', function ($subQ) use ($invoice_number) {
                $subQ->where('invoice_number', $invoice_number);
            });
        }

        if ($request->filled('username')) {
            $user_id = User::where('username', $request->username)->value('id');
            $query->whereHas('order_invoice', function ($subQ) use ($user_id) {
                $subQ->where('user_id', $user_id);
            });
        }

        if ($request->filled('code_number')) {
            $code_number = $request->code_number;
            $query->whereHas('order_invoice.sales_point', function ($subQ) use ($code_number) {
                $subQ->where('code_number', $code_number);
            });
        }

        if ($request->filled('depot_id')) {
            $depot_id = $request->depot_id;
            $query->whereHas('order_invoice.sales_point', function ($subQ) use ($depot_id) {
                $subQ->where('depot_id', $depot_id);
            });
        }

        if ($request->filled('payment_type')) {
            $payment_type = $request->payment_type;
            $query->whereHas('order_invoice.sales_point', function ($subQ) use ($payment_type) {
                $subQ->where('payment_type', $payment_type);
            });
        }

        $query->whereHas('order_invoice', function ($subQuery) use ($fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                    $subQuery->whereBetween('order_invoices.created_at', [$fromDate, $toDate]);
            } else {
                $subQuery->whereDate('order_invoices.created_at', $today);
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

            $total_return_amount = Collection::where('order_invoice_id', $collection->order_invoice_id)
                // ->where('status', 'Partial | Paid')
                ->sum('return_amount');

            $collection->previous_payment = $total_partial_paid;
            $collection->previous_addi_dis_amount = $total_addi_dis_amount;
            $collection->previous_return_amount = $total_return_amount;
        }

        $data['collections'] = $collections;

        $data['invoice'] = $data['collections']->count();

        $order_invoice_ids = $data['collections']->pluck('order_invoice_id');
        $data['order_value'] = OrderInvoice::whereIn('id', $order_invoice_ids)->sum('total_amount');
        $data['discount_value'] = OrderInvoice::whereIn('id', $order_invoice_ids)->sum('sell_discount_amount');
        $data['addi_dis_value'] = $data['collections']->sum('previous_addi_dis_amount');
        $data['return_value'] = $data['collections']->sum('previous_return_amount');
        $data['previous_payment'] = $data['collections']->sum('previous_payment');
        $data['due'] = $data['collections']->sum('due');

        return view('report.sales.dues', $data);
    }

    public function collections(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Collections', 'url' => null]
        ];

        $data['depots'] = Depot::whereNotIn('slug', ['ware-house'])->get();

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

        if ($request->filled('code_number')) {
            $code_number = $request->code_number;
            $query->whereHas('sales_point', function ($subQ) use ($code_number) {
                $subQ->where('code_number', $code_number);
            });
        }

        if ($request->filled('depot_id')) {
            $depot_id = $request->depot_id;
            $query->where('depot_id', $depot_id);
        }

        if ($request->filled('payment_type')) {
            $payment_type = $request->payment_type;
            $query->whereHas('sales_point', function ($subQ) use ($payment_type) {
                $subQ->where('payment_type', $payment_type);
            });
        }

        $query->whereNotIn('status', ['Requested']);

        // $query->whereHas('collections', function ($subQuery) use ($fromDate, $toDate, $today) {
        //     if ($fromDate && $toDate) {
        //         $subQuery->whereBetween('collections.updated_at', [$fromDate, $toDate])
        //             ->whereIn('collections.status', ['Paid', 'Partial | Paid']);
        //     } else {
        //         $subQuery->whereDate('collections.updated_at', $today)
        //             ->whereIn('collections.status', ['Paid', 'Partial | Paid']);
        //     }
        // });

        $query->whereHas('collections', function ($subQuery) use ($fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                $subQuery->whereBetween('collections.updated_at', [$fromDate, $toDate])
                    ->where(function ($q) {
                        $q->where('collections.status', 'Paid') // Fully paid invoices
                          ->orWhere(function ($q) {
                              $q->where('collections.status', 'Partial | Paid')
                                ->whereDoesntHave('order_invoice.collections', function ($innerQuery) {
                                    $innerQuery->where('collections.status', 'Paid'); // Exclude if fully paid exists
                                });
                          });
                    });
            } else {
                $subQuery->whereDate('collections.updated_at', $today)
                    ->where(function ($q) {
                        $q->where('collections.status', 'Paid') // Fully paid invoices
                          ->orWhere(function ($q) {
                              $q->where('collections.status', 'Partial | Paid')
                                ->whereDoesntHave('order_invoice.collections', function ($innerQuery) {
                                    $innerQuery->where('collections.status', 'Paid'); // Exclude if fully paid exists
                                });
                          });
                    });
            }
        });
        
        $total_query = $query->get();
        $order_invoices = $query->with(['collections' => function ($query) {
                $query->orderBy('updated_at', 'desc');
        }])->paginate(30);

        foreach ($order_invoices as $order_invoice) {
            $total_addi_dis_amount = Collection::where('order_invoice_id', $order_invoice->id)
                ->whereIn('status', ['Paid', 'Partial | Paid'])
                ->sum('addi_dis_amount');

            $total_partial_paid = Collection::where('order_invoice_id', $order_invoice->id)
                ->where('status', 'Partial | Paid')
                ->sum('partial_paid');

            $full_paid = Collection::where('order_invoice_id', $order_invoice->id)
                ->where('status', 'Paid')
                ->sum('full_paid');
            
            $collection = Collection::where('order_invoice_id', $order_invoice->id)->get()->last();

            $order_invoice->payment = $total_partial_paid + $full_paid;
            $order_invoice->previous_addi_dis_amount = $total_addi_dis_amount;
            $order_invoice->due = $collection->due;
        }

        $data['order_invoices'] = $order_invoices;

        $data['invoice'] = $total_query->count();
        $data['order_value'] = $total_query->sum('total_amount');
        $data['discount_value'] = $total_query->sum('sell_discount_amount');
        $data['return_value'] = $total_query->sum('return_amount');
        // $data['payable_value'] = $data['order_value'] - $data['discount_value'] - $data['return_value'];

        $partial_paid = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->where('status', 'Partial | Paid')
            ->sum('partial_paid');

        $full_paid = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->where('status', 'Paid')
            ->sum('full_paid');

        $data['total_payment'] = $partial_paid + $full_paid;

        $data['addi_dis_value'] = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->whereIn('status', ['Paid', 'Partial | Paid'])
            ->sum('addi_dis_amount');

        $collection = Collection::whereIn('order_invoice_id', $total_query->pluck('id'))
            ->whereIn('status', ['Due', 'Partial Payment'])
            ->get();
            
        $data['due'] = $collection->sum('due');

        return view('report.sales.collections', $data);
    }

    public function returns(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Returns', 'url' => null]
        ];

        $data['depots'] = Depot::whereNotIn('slug', ['ware-house'])->get();
        $query = Collection::query();
        $today = Carbon::today();

        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        if ($request->filled('invoice_number')) {
            $invoice_number = $request->invoice_number;
            $query->whereHas('order_invoice', function ($subQ) use ($invoice_number) {
                $subQ->where('invoice_number', $invoice_number);
            });
        }

        if ($request->filled('username')) {
            $user_id = User::where('username', $request->username)->value('id');
            $query->whereHas('order_invoice', function ($subQ) use ($user_id) {
                $subQ->where('user_id', $user_id);
            });
        }

        if ($request->filled('code_number')) {
            $code_number = $request->code_number;
            $query->whereHas('order_invoice.sales_point', function ($subQ) use ($code_number) {
                $subQ->where('code_number', $code_number);
            });
        }

        if ($request->filled('depot_id')) {
            $depot_id = $request->depot_id;
            $query->whereHas('order_invoice.sales_point', function ($subQ) use ($depot_id) {
                $subQ->where('depot_id', $depot_id);
            });
        }

        if ($request->filled('payment_type')) {
            $payment_type = $request->payment_type;
            $query->whereHas('order_invoice.sales_point', function ($subQ) use ($payment_type) {
                $subQ->where('payment_type', $payment_type);
            });
        }

        $query->whereHas('order_invoice', function ($subQuery) use ($fromDate, $toDate, $today) {
            if ($fromDate && $toDate) {
                    $subQuery->whereBetween('order_invoices.created_at', [$fromDate, $toDate]);
            } else {
                $subQuery->whereDate('order_invoices.created_at', $today);
            }
        });

        $query->whereHas('order_invoice', function ($subQ) {
            $subQ->whereIn('status', ['Return', 'Partial Return']);
        });

        $query->whereNotNull('return_amount');

        $collections = $query->orderBy('id', 'desc')->get();
        
        $data['collections'] = $collections;

        $order_invoice_ids = $data['collections']->pluck('order_invoice_id');
        $data['order_value'] = OrderInvoice::whereIn('id', $order_invoice_ids)->sum('total_amount');
        $data['return_amount'] = $data['collections']->sum('return_amount');

        return view('report.sales.returns', $data);
    }

    // public function national_sales(Request $request)
    // {
    //     $data['breadcrumbs'] = [
    //         ['title' => 'Dashboard', 'url' => route('dashboard')],
    //         ['title' => 'Report', 'url' => null],
    //         ['title' => 'Sales', 'url' => null],
    //         ['title' => 'National Sales', 'url' => null]
    //     ];

    //     $warehouse_products = WarehouseStock::all();
    //     $data['depots'] = Depot::whereNotIn('slug', ['ware-house'])->get();
    //     $today = Carbon::today();

    //     // Parse date filters
    //     $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
    //         ? Carbon::parse($request->from_date)->startOfDay()
    //         : null;

    //     $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
    //         ? Carbon::parse($request->to_date)->endOfDay()
    //         : null;

    //     $queryFilters = function ($query) use ($request, $fromDate, $toDate, $today) {
    //         if ($request->filled('depot_id')) {
    //             $query->where('depot_id', $request->depot_id);
    //         }
    //         if ($fromDate && $toDate) {
    //             $query->whereBetween('created_at', [$fromDate, $toDate]);
    //         } else {
    //             $query->whereDate('created_at', $today);
    //         }
    //     };

    //     $national_sales = [];

    //     foreach ($warehouse_products as $warehouse_product) {
    //         // Get the total quantity of tran_quant where SKU matches and tran_type is 'Depot to Sales Point'
    //         $total_tran_quant = Transection::where('tran_type', 'Depot to Sales Point')
    //             ->where('sku', $warehouse_product->sku)
    //             ->where($queryFilters)
    //             ->sum('tran_quant');

    //         $total_sales_value = Transection::where('tran_type', 'Depot to Sales Point')
    //             ->where('sku', $warehouse_product->sku)
    //             ->where($queryFilters)
    //             ->sum('sales_value');

    //         $total_return_quant = Transection::where('tran_type', 'Sales Point to Depot')
    //             ->where('sku', $warehouse_product->sku)
    //             ->where($queryFilters)
    //             ->sum('tran_quant');

    //         $total_return_value = Transection::where('tran_type', 'Sales Point to Depot')
    //             ->where('sku', $warehouse_product->sku)
    //             ->where($queryFilters)
    //             ->sum('sales_value');

    //         // If there are matching transactions, add to the results
    //         // if ($total_tran_quant > 0) {
    //             $national_sales[] = [
    //                 'warehouse_product' => $warehouse_product, // Warehouse product object
    //                 'total_tran_quant' => $total_tran_quant,  // Ttotal tran_quant for the product
    //                 'total_return_quant' => $total_return_quant,
    //                 'total_sales_value' => $total_sales_value,
    //                 'total_return_value' => $total_return_value
    //             ];
    //         // }
    //     }

    //     // Store the results in the data array
    //     $data['national_sales'] = $national_sales;
    //     $data['total_sales_qty'] = collect($data['national_sales'])->sum('total_tran_quant');
    //     $data['total_sales_amount'] = collect($data['national_sales'])->sum('total_sales_value');
    //     $data['total_return_qty'] = collect($data['national_sales'])->sum('total_return_quant');
    //     $data['total_return_amount'] = collect($data['national_sales'])->sum('total_return_value');

    //     return view('report.sales.national_sales', $data);
    // }

    public function pre_returns(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'Previous Returns', 'url' => null]
        ];

        $query = Order::query();
        $today = Carbon::today();
        // $data['depots'] = Depot::whereNotIn('slug', ['ware-house'])->get();
        
        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        $query->whereHas('orderInvoices', function ($invoiceQuery) use ($fromDate, $toDate, $today) {
            $invoiceQuery->whereNotIn('status', ['Requested', 'Cancel']);
        
            if ($fromDate && $toDate) {
                $invoiceQuery->whereBetween('order_invoices.updated_at', [$fromDate, $toDate]);
            } else {
                $invoiceQuery->whereDate('order_invoices.updated_at', $today);
            }
        });

        // Run the query
        $orders = $query->get();
        // $orders = $query->paginate(10);

        // Group manually using loop
        $grouped = [];
        $invoiceIds = [];

        foreach ($orders as $order) {
            if ($order->return_qty !== null) {
                $sku = $order->sku;

                if (!isset($grouped[$sku])) {
                    $grouped[$sku] = [
                        'sku' => $order->sku,
                        'product_name' => $order->product_name,
                        // 'total_qty' => 0,
                        'total_return_qty' => 0,
                        'total_return_value' => 0,
                    ];
                }

                // $grouped[$sku]['total_qty'] += $order->quantity;
                $grouped[$sku]['total_return_qty'] += $order->return_qty;
                $grouped[$sku]['total_return_value'] += $order->return_qty * $order->sell_unit_price;
            }
            
            foreach ($order->orderInvoices as $invoice) {
                $invoiceIds[] = $invoice->id;
            }
        }

        // $totalQty = 0;
        $totalReturnQty = 0;
        $totalReturnValue = 0;

        foreach ($grouped as $item) {
            // $totalQty += $item['total_qty'];
            $totalReturnQty += $item['total_return_qty'];
            $totalReturnValue += $item['total_return_value'];
        }

        $invoiceIds = array_values(array_unique($invoiceIds));

        $totalAdditionalDiscount = Collection::whereIn('order_invoice_id', $invoiceIds)
            ->whereIn('status', ['Paid', 'Partial | Paid'])
            ->sum('addi_dis_amount');

        $data['pre_returns'] = array_values($grouped);
        // $data['totalQty'] = $totalQty;
        $data['totalReturnQty'] = $totalReturnQty;
        $data['totalReturnValue'] = $totalReturnValue;
        // $data['totalAdditionalDiscount'] = $totalAdditionalDiscount;

        return view('report.sales.pre_returns', $data);
    }

    public function national_sales(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Sales', 'url' => null],
            ['title' => 'National Sales', 'url' => null]
        ];

        $query = Order::query();
        $today = Carbon::today();
        $data['depots'] = Depot::whereNotIn('slug', ['ware-house'])->get();
        
        // Parse date filters
        $fromDate = $request->filled('from_date') && Carbon::hasFormat($request->from_date, 'Y-m-d')
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->filled('to_date') && Carbon::hasFormat($request->to_date, 'Y-m-d')
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        $query->whereHas('orderInvoices', function ($invoiceQuery) use ($fromDate, $toDate, $today) {
            $invoiceQuery->whereNotIn('status', ['Requested', 'Cancel']);
        
            if ($fromDate && $toDate) {
                $invoiceQuery->whereBetween('order_invoices.updated_at', [$fromDate, $toDate]);
            } else {
                $invoiceQuery->whereDate('order_invoices.updated_at', $today);
            }
        });

        // Run the query
        $orders = $query->get();
        // $orders = $query->paginate(10);

        // Group manually using loop
        $grouped = [];
        $invoiceIds = [];

        foreach ($orders as $order) {
            if ($order->quantity !== 0) {
                $sku = $order->sku;

                if (!isset($grouped[$sku])) {
                    $grouped[$sku] = [
                        'sku' => $order->sku,
                        'product_name' => $order->product_name,
                        'total_qty' => 0,
                        'total_return_qty' => 0,
                        'total_value' => 0,
                    ];
                }

                $grouped[$sku]['total_qty'] += $order->quantity;
                $grouped[$sku]['total_return_qty'] += $order->return_qty;
                $grouped[$sku]['total_value'] += $order->total_amount;
            }
            
            foreach ($order->orderInvoices as $invoice) {
                $invoiceIds[] = $invoice->id;
            }
        }

        $totalQty = 0;
        $totalReturnQty = 0;
        $totalValue = 0;

        foreach ($grouped as $item) {
            $totalQty += $item['total_qty'];
            $totalReturnQty += $item['total_return_qty'];
            $totalValue += $item['total_value'];
        }

        $invoiceIds = array_values(array_unique($invoiceIds));

        $totalAdditionalDiscount = Collection::whereIn('order_invoice_id', $invoiceIds)
            ->whereIn('status', ['Paid', 'Partial | Paid'])
            ->sum('addi_dis_amount');

        $data['national_sales'] = array_values($grouped);
        $data['totalQty'] = $totalQty;
        $data['totalReturnQty'] = $totalReturnQty;
        $data['totalValue'] = $totalValue;
        $data['totalAdditionalDiscount'] = $totalAdditionalDiscount;

        return view('report.sales.national_sales', $data);
    }

    public function money_receipts(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Report', 'url' => null],
            ['title' => 'Money Receipt', 'url' => null]
        ];

        $data['collections'] = Collection::whereIn('status', ['Paid', 'Partial | Paid'])
            ->whereNull('money_receipt_status')
            ->where(function ($query) {
                $query->where('partial_paid', '>', 0)
                    ->orWhere('full_paid', '>', 0);
            })
            ->get();

        $paid = 0;
        foreach ($data['collections'] as $collection) {
            if ($collection->status === 'Paid') {
                $paid = $collection->full_paid;
            } else {
                $paid = $collection->partial_paid;
            }

            $collection->paid_amount = $paid;
        }

        $data['money_receipt_invoices'] = MoneyReceiptInvoice::all();

        foreach ($data['money_receipt_invoices'] as $invoice) {
            $total = 0;
        
            foreach ($invoice->money_receipts as $receipt) {
                if ($receipt->collection->status === 'Paid') {
                    $total += $receipt->collection->full_paid;
                } else {
                    $total += $receipt->collection->partial_paid;
                }
            }
        
            $invoice->total_amount = $total;
        }

        return view('report.money_receipts', $data);
    }

    public function receipt(Request $request, $id)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Purchase Product', 'url' => null],
            ['title' => 'Receipt', 'url' => null]
        ];

        $moneyReceipt = MoneyReceiptInvoice::find($id);

        $grandTotal = $moneyReceipt->money_receipts->sum(function ($receipt) {
            return $receipt->collection->partial_paid ?? $receipt->collection->full_paid ?? 0;
        });

        // Convert Grand Total to Words using NumberFormatter
        $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        $grandTotalInWords = ucwords($formatter->format($grandTotal)) . ' Taka Only';

        $data['money_receipt'] = $moneyReceipt;
        $data['grand_total'] = $grandTotal;
        $data['grand_total_in_words'] = $grandTotalInWords;

        return view('report.receipt', $data);
    }
}
