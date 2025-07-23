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
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header mt-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <form class="d-flex align-items-center position-relative my-1" action="{{ route('order.accepted_invoices') }}" method="GET">
                                <!--begin::Search-->
                                <div class="w-110 mw-120px me-2">
                                    <input name="invoice_number" value="{{ request('invoice_number') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid" placeholder="Invoice Number" />
                                </div>
                                <!--end::Search-->

                                <!--begin::Search-->
                                <div class="w-110 mw-120px me-2">
                                    <input name="username" value="{{ request('username') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid" placeholder="Employee ID" />
                                </div>
                                <!--end::Search-->

                                <!--begin::Search-->
                                <div class="w-110 mw-120px me-2">
                                    <input name="code_number" value="{{ request('code_number') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid" placeholder="Sale Point Number" />
                                </div>
                                <!--end::Search-->

                                <!--begin::Depot-->
                                <div class="w-110 mw-120px me-2">
                                    <!--begin::Select2-->
                                    <select id="depot_id" name="depot_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Depot" data-kt-ecommerce-product-filter="status">
                                        <option></option>
                                        {{-- @foreach ($depots as $depot)
                                            <option value="{{ $depot->id }}" {{ request('depot_id') == $depot->id ? 'selected' : '' }}>{{ $depot->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <!--end::Depot-->

                                <div class="w-110 mw-120px me-2">
                                    <input name="from_date" type="date" value="{{ request('from_date') ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control form-control-solid" />
                                </div>

                                <div class="w-110 mw-120px me-2">
                                    <input name="to_date" type="date" value="{{ request('to_date') ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control form-control-solid" />
                                </div>
        
                                <button type="submit" class="btn btn-light-primary">Search</button>
                            </form>
                        </div>
                        <!--begin::Card title-->
                        
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"></div>
                            <!--end::Toolbar-->

                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                                <div class="fw-bolder me-5">
                                    <label class="fs-6 fw-bolder text-gray-700 form-label">
                                        <span class="me-2" data-kt-user-table-select="selected_count"></span>
                                        Selected
                                    </label>

                                    <select data-order_invoice_id="" class="form-select form-select-solid status_select" data-control="select2">
                                        <option>Select a Delivery Man</option>
                                        {{-- @foreach($delivery_men as $delivery_man)
                                            <option value="{{ $delivery_man->id }}">
                                                @if ($delivery_man->employee)
                                                    {{ $delivery_man->employee->name }} - {{ $delivery_man->depot->name }}
                                                @endif
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <!--end::Group actions-->

                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmation_modal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirm Update</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to update the delivery man for the selected invoice?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" id="confirm_update_button">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_upload">
                                <!--begin::Svg Icon | path: icons/duotune/files/fil018.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                        <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="currentColor" />
                                        <path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->

                                Bulk Upload
                            </button> --}}
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-700 fw-bolder fs-7 gs-0">
                                    <th class="min-w-70px">
                                        <div class="badge badge-light-info" style="font-size: 14px;">Invoice => {{ $invoice }}</div>
                                    </th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                        </table>

                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-10px">S.N</th>
                                    <th class="min-w-80px">Invoice No</th>
                                    <th class="min-w-80px">Order By</th>
                                    <th class="min-w-80px">Sale Point Name</th>
                                    <th class="min-w-50px">Territory</th>
                                    <th class="min-w-80px">Order Date</th>
                                    <th class="min-w-80px">Invoice Date</th>
                                    <th class="min-w-60px">Payable Amount</th>
                                    <th class="min-w-60px text-end">status</th>
                                    
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-black-600">
                                <!--begin::Table row-->
                                @foreach ($orderInvoices as $key => $orderInvoice)
                                    <tr class="hover-row">
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input row-checkbox" type="checkbox" value="1" data-order_invoice_id="{{ $orderInvoice->id }}" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->

                                        <!--begin::S.N=-->
                                        <td>{{ $key + 1 }}</td>
                                        <!--end::S.N=-->

                                        <!--begin::Invoice No=-->
                                        <td class="pe-0">
                                            {{-- <a href="{{ route('order_management.order_invoice', $order_invoice->id) }}" class="text-gray-700 text-hover-primary fs-5 fw-bolder">{{ $order_invoice->invoice_number }}</a> --}}
                                            <a href="{{ route('order.invoice', $orderInvoice->id) }}">{{ $orderInvoice->invoice_number }}</a>
                                        </td>
                                        <!--end::Invoice No=-->

                                        <!--begin::Order By=-->
                                        <td>
                                            {{ $orderInvoice->user->name }} <br>
                                            ({{ $orderInvoice->user->username }})
                                        </td>
                                        <!--end::Order By=-->

                                        <!--begin::Sales Point Name=-->
                                        <td>
                                            {{ $orderInvoice->salePoint->name }} <br>
                                            ({{ $orderInvoice->salePoint->code_number }})
                                        </td>
                                        <!--end::Sales Point Name=-->

                                        <!--begin::Territory=-->
                                        <td>{{ $orderInvoice->territory->name }}</td>
                                        <!--end::Territory=-->

                                        <!--begin::Order Date=-->
                                        <td>
                                            {{-- {{ $order_invoice->created_at->setTimezone('Asia/Dhaka')->format('d M, Y / h:i A') }} --}}

                                            {{ $orderInvoice->created_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}
                                            {{-- <br> --}}
                                            {{-- {{ $order_invoice->created_at->setTimezone('Asia/Dhaka')->format('h:i A') }} --}}
                                        </td>
                                        <!--end::Order Date=-->

                                        <!--begin::Invoice Date=-->
                                        <td>
                                            {{-- {{ $order_invoice->updated_at->setTimezone('Asia/Dhaka')->format('d M, Y / h:i A') }} --}}

                                            {{ $orderInvoice->updated_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}
                                            {{-- <br> --}}
                                            {{-- {{ $order_invoice->updated_at->setTimezone('Asia/Dhaka')->format('h:i A') }} --}}
                                        </td>
                                        <!--end::Invoice Date=-->

                                        <!--begin::Delivery Man=-->
                                        {{-- <td>
                                            @if ($order_invoice->delivery_man_id === null)
                                                <div class="badge badge-light-danger">Not Assigned</div>
                                            @else
                                                @if ($order_invoice->delivery_man->employee)
                                                    {{ $order_invoice->delivery_man->employee->name }} <br>
                                                    ({{ $order_invoice->delivery_man->depot->name }})
                                                @endif
                                            @endif
                                        </td> --}}
                                        <!--end::Delivery Man=-->
                                        
                                        <!--begin::Payable Amount=-->
                                        <td>{{ $orderInvoice->total_amount }} Tk</td>
                                        <!--end::Payable Amount=-->

                                        <!--begin::Status=-->
                                        <td class="text-end">
                                            <div class="badge badge-light-warning">{{ $orderInvoice->status }}</div>
                                        </td>
                                        <!--end::Status=-->
                                    </tr>
                                @endforeach
                                <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->

                            <tfoot>
                                <tr>
                                    <td colspan="8" class="text-end fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">Total:</div>
                                    </td>
                                    <td class="fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($order_value, 2) }} Tk</div>
                                    </td>
                                    {{-- <td class="fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($discount_value, 2) }} Tk</div>
                                    </td>
                                    <td class="fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($payable_value, 2) }} Tk</div>
                                    </td> --}}
                                </tr>
                            </tfoot>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post--> 
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let selected_delivery_man_id = null;

            // Show the confirmation modal on select change
            $('.status_select').on('change', function() {
                selected_delivery_man_id = $(this).val();
                if (selected_delivery_man_id) {
                    $('#confirmation_modal').modal('show');
                }
            });

            // Handle the confirmation button click
            $('#confirm_update_button').on('click', function() {
                // Collect all selected order invoice IDs
                let selected_order_invoice_ids = [];
                $('.row-checkbox:checked').each(function() {
                    selected_order_invoice_ids.push($(this).data('order_invoice_id'));
                });

                // Send AJAX requests to update each selected item
                selected_order_invoice_ids.forEach(function(order_invoice_id) {
                    let action = url.replace(':order_invoice_id', order_invoice_id);

                    $.ajax({
                        url: action,
                        type: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            delivery_man_id: selected_delivery_man_id
                        },
                        success: function(response) {
                            console.log('Order invoice updated successfully');
                        },
                        error: function(xhr) {
                            console.error('Failed to update order invoice', xhr);
                        }
                    });
                });

                // Optionally, reload the page after updates
                location.reload();

                // Hide the modal
                $('#confirmation_modal').modal('hide');
            });
        });
    </script>
@endpush

