@extends('Access::layouts.app')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    @include('Access::layouts.breadcrumb')
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header mt-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <form class="d-flex align-items-center position-relative my-1" action="{{ route('report.sales') }}" method="GET">
                            <!--begin::Search-->
                            <div class="w-110 mw-120px me-2">
                                <input name="invoice_number" value="{{ request('invoice_number') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid" placeholder="Invoice Number"/>
                            </div>
                            <!--end::Search-->

                            <!--begin::Search-->
                            <div class="w-110 mw-120px me-2">
                                <input name="username" value="{{ request('username') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid" placeholder="Employee ID" />
                            </div>
                            <!--end::Search-->

                            <!--begin::Search-->
                            <div class="w-110 mw-120px me-2">
                                <select name="code_number" class="form-select form-select-solid" data-control="select2" data-placeholder="Select Sales Point">
                                    <option></option>
                                    @foreach ($sale_points as $sale_point)
                                        <option value="{{ $sale_point->code_number }}" {{ request('code_number') == $sale_point->code_number ? 'selected' : '' }}>{{ $sale_point->name }}</option>
                                    @endforeach
                                </select>                                
                            </div>
                            <!--end::Search-->

                            <!--begin::Depot-->
                            <div class="w-110 mw-120px me-2">
                                <!--begin::Select2-->
                                <select name="depot_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Depot" data-kt-ecommerce-product-filter="status">
                                    <option></option>
                                    {{-- @foreach ($depots as $depot)
                                        <option value="{{ $depot->id }}" {{ request('depot_id') == $depot->id ? 'selected' : '' }}>{{ $depot->name }}</option>
                                    @endforeach --}}
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Depot-->

                            <!--begin::Payment Type-->
                            <div class="w-110 mw-120px me-2">
                                <!--begin::Select2-->
                                <select name="payment_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Payment Type" data-kt-ecommerce-product-filter="status" data-hide-search="true">
                                    <option></option>
                                    <option value="Cash" {{ request('payment_type') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Credit" {{ request('payment_type') == 'Credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="Partial Credit" {{ request('payment_type') == 'Partial Credit' ? 'selected' : '' }}>Partial Credit</option>
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Payment Type-->

                            <div class="w-110 mw-120px me-2">
                                <input name="from_date" type="date" value="{{ request('from_date') ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control form-control-solid" />
                            </div>

                            <div class="w-110 mw-120px me-2">
                                <input name="to_date" type="date" value="{{ request('to_date') ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control form-control-solid" />
                            </div>

                            <!--begin::Status-->
                            {{-- <div class="w-200 mw-250px me-2">
                                <!--begin::Select2-->
                                <select name="status" class="form-select form-select-solid" data-control="select2" data-placeholder="Search by Status" data-kt-ecommerce-product-filter="status" data-hide-search="true">
                                    <option></option>
                                    <option value="accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                                <!--end::Select2-->
                            </div> --}}
                            <!--end::Status-->

                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-700 fw-bolder fs-7 gs-0">
                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Invoice => {{ $invoice }}</div>
                                </th>

                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Order => {{ number_format($order_value, 2) }} Tk</div>
                                </th>

                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Discount => {{ number_format($discount_value, 2) }} Tk</div>
                                </th>

                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Return => {{ number_format($return_value, 2) }} Tk</div>
                                </th>

                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Payable => {{ number_format($payable_value, 2) }} Tk</div>
                                </th>

                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Paid => {{ number_format($total_previous_payment, 2) }} Tk</div>
                                </th>

                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Add. Dis => {{ number_format($addi_dis_value, 2) }} Tk</div>
                                </th>

                                <th>
                                    <div class="badge badge-light-info" style="font-size: 14px;">Due => {{ number_format($due, 2) }} Tk</div>
                                </th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                    </table>

                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <!--begin::Table head-->
                        

                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-10px">S.N</th>
                                <th class="min-w-80px">Invoice No</th>
                                <th class="min-w-80px">Order By</th>
                                <th class="min-w-80px">Sales Point Name</th>
                                {{-- <th class="min-w-50px">Depot</th> --}}
                                {{-- <th class="min-w-70px">Territory</th> --}}
                                <th class="min-w-80px">Order Date/Time</th>
                                <th class="min-w-80px">Invoice Date/Time</th>
                                {{-- <th class="min-w-50px">Payment Type</th> --}}
                                <th class="min-w-60px">Order Value</th>
                                <th class="min-w-60px">Discount</th>
                                <th class="min-w-60px">Return</th>
                                <th class="min-w-60px">Payable Amount</th>
                                <th class="min-w-60px">Paid</th>
                                <th class="min-w-60px">Addi. Dis.</th>
                                <th class="min-w-60px text-end">Due</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-black-600">
                            @foreach ($order_invoices as $key => $order_invoice)
                                <tr class="hover-row">
                                    <!--begin::S.N=-->
                                    <td>{{ $order_invoices->firstItem() + $key }}</td>
                                    <!--end::S.N=-->

                                    <!--begin::Invoice number=-->
                                    <td class="pe-0">
                                        {{-- <a href="{{ route('order_management.order_invoice', $order_invoice->id) }}" class="text-gray-700 text-hover-primary fs-5 fw-bolder"> --}}
                                        {{-- <a href="{{ route('order_management.order_invoice', $order_invoice->id) }}"> --}}
                                        <a href="javascript:void(0)">
                                            {{ $order_invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <!--end::Invoice number=-->

                                    <!--begin::Order By=-->
                                    <td>
                                        {{ $order_invoice->user->name }}<br>
                                        ({{ $order_invoice->user->username }})
                                    </td>
                                    <!--end::Order By=-->

                                    <!--begin::Sales Point Name=-->
                                    <td>
                                        {{ $order_invoice->salePoint->name }}<br>
                                        ({{ $order_invoice->salePoint->code_number }})
                                    </td>
                                    <!--end::Sales Point Name=-->

                                    <!--begin::Depot=-->
                                    {{-- <td>{{ $order_invoice->sales_point->depot->name }}</td> --}}
                                    <!--end::Depot=-->

                                    <!--begin::Territory=-->
                                    {{-- <td>{{ $order_invoice->sales_point->territory->name }}</td> --}}
                                    <!--end::Territory=-->

                                    <!--begin::Invoice Created Date/Time=-->
                                    <td class="pe-0">
                                        {{-- {{ $order_invoice->created_at->setTimezone('Asia/Dhaka')->format('d M, Y / h:i A') }} --}}

                                        {{ $order_invoice->created_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}<br>
                                        {{ $order_invoice->created_at->setTimezone('Asia/Dhaka')->format('h:i A') }}
                                    </td>
                                    <!--end::Invoice Created Date/Time=-->

                                    <!--begin::Invoice Updated Date/Time=-->
                                    <td class="pe-0">
                                        {{-- {{ $order_invoice->updated_at->setTimezone('Asia/Dhaka')->format('d M, Y / h:i A') }} --}}

                                        {{ $order_invoice->updated_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}<br>
                                        {{ $order_invoice->updated_at->setTimezone('Asia/Dhaka')->format('h:i A') }}
                                    </td>
                                    <!--end::Invoice Updated Date/Time=-->

                                    <!--begin::Payment Type=-->
                                    {{-- <td>{{ $order_invoice->sales_point->payment_type }}</td> --}}
                                    <!--end::Payment Type=-->

                                    <!--begin::Order Value=-->
                                    <td>{{ $order_invoice->total_amount }} Tk</td>
                                    <!--end::Order Value=-->

                                    <!--begin::Sale Point Dis.=-->
                                    <td>
                                        @if ($order_invoice->sell_discount_amount)
                                            {{ $order_invoice->sell_discount_amount }} Tk
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <!--end::Sale Point Dis.=-->

                                    <!--begin::Return Value=-->
                                    <td>
                                        @if ($order_invoice->return_amount)
                                            {{ $order_invoice->return_amount }} Tk
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <!--end::Return Value=-->

                                    <!--begin::Payable Amount=-->
                                    @php
                                        $payable = $order_invoice->total_amount - $order_invoice->sell_discount_amount - $order_invoice->return_amount;
                                    @endphp
                                    <td>{{ number_format($payable, 2) }} Tk</td>
                                    <!--end::Payable Amount=-->

                                    <!--begin::Paid=-->
                                    <td>
                                        @if ($order_invoice->previous_payment)
                                            {{ number_format($order_invoice->previous_payment, 2) }} Tk
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <!--end::Paid=-->

                                    <!--begin::Addi. Dis.=-->
                                    <td>
                                        @if ($order_invoice->previous_addi_dis_amount)
                                            {{ $order_invoice->previous_addi_dis_amount }} Tk
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <!--end::Addi. Dis.=-->

                                    

                                    <!--begin::Payable Amount=-->
                                    {{-- <td>{{ number_format($order_invoice->due, 2) }} Tk</td> --}}
                                    {{-- <td>{{ $order_invoice->due }} Tk</td> --}}
                                    {{-- <td>{{ $order_invoice->due + $order_invoice->previous_payment }} Tk</td> --}}
                                    <!--end::Payable Amount=-->

                                    

                                    <!--begin::Due=-->
                                    <td class="text-end">
                                        @if ($order_invoice->due)
                                            {{ $order_invoice->due }} Tk
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <!--end::Due=-->
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->

                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-end fw-bold">
                                    <div class="badge badge-light-info" style="font-size: 14px;">Total:</div>
                                </td>
                                <td class="fw-bold">
                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($order_value, 2) }} Tk</div>
                                </td>
                                <td class="fw-bold">
                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($discount_value, 2) }} Tk</div>
                                </td>
                                <td class="fw-bold">
                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($return_value, 2) }} Tk</div>
                                </td>
                                <td class="fw-bold text-end">
                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($payable_value, 2) }} Tk</div>
                                </td>
                                <td class="fw-bold">
                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($total_previous_payment, 2) }} Tk</div>
                                </td>
                                <td class="fw-bold">
                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($addi_dis_value, 2) }} Tk</div>
                                </td>
                                <td class="fw-bold">
                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($due, 2) }} Tk</div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <!--end::Table-->

                    <div class="pagination-container mt-10">
                        <nav>
                            {{ $order_invoices->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <!--begin::Modals-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>  
@endsection