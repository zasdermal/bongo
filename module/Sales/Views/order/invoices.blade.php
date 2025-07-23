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
                            <form class="d-flex align-items-center position-relative my-1" action="{{ route('order.invoices') }}" method="GET">
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

                                <div class="w-110 mw-120px me-2">
                                    <input name="from_date" type="date" value="{{ request('from_date') ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control form-control-solid" />
                                </div>

                                <div class="w-110 mw-120px me-2">
                                    <input name="to_date" type="date" value="{{ request('to_date') ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control form-control-solid" />
                                </div>

                                <button type="submit" class="btn btn-light-primary">Search</button>
                            </form>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Button-->
                                <a href="{{ route('order.create_invoice') }}" type="button" class="btn btn-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    Create Invoice
                                </a>
                            <!--end::Button-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-black-700 fw-bolder fs-7 gs-0">
                                    <th class="min-w-70px">
                                        <div class="badge badge-light-info" style="font-size: 14px;">Invoice => {{ $invoice }}</div>
                                    </th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                        </table>

                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-10px">S.N</th>
                                    {{-- <th class="min-w-120px">Invoice No</th> --}}
                                    <th class="min-w-80px">Order By</th>
                                    <th class="min-w-80px">Sale Point Name</th>
                                    <th class="min-w-50px">Territory</th>
                                    <th class="min-w-80px">Order Date</th>
                                    <th class="min-w-60px">Order Value</th>
                                    <th class="min-w-60px">status</th>
                                    <th class="text-end min-w-60px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody class="text-black-600">
                                @foreach ($orderInvoices as $key => $orderInvoice)
                                    <tr class="hover-row">
                                        <!--begin::S.N=-->
                                        <td>{{ $orderInvoices->firstItem() + $key }}</td>
                                        <!--end::S.N=-->

                                        <!--begin::Invoice No=-->
                                        {{-- <td class="pe-0">
                                            <a href="{{ route('order_management.order_invoice', $order_invoice->id) }}" class="text-gray-700 text-hover-primary fs-5 fw-bolder">{{ $order_invoice->invoice_number }}</a>
                                        </td> --}}
                                        <!--end::Invoice No=-->

                                        <!--begin::Order By=-->
                                        <td>{{ $orderInvoice->user->name }} ({{ $orderInvoice->user->username }})</td>
                                        <!--end::Order By=-->

                                        <!--begin::Sales Point Name=-->
                                        <td>{{ $orderInvoice->salePoint->name }} ({{ $orderInvoice->salePoint->code_number }})</td>
                                        <!--end::Sales Point Name=-->

                                        <!--begin::Territory=-->
                                        <td>{{ $orderInvoice->territory->name }}</td>
                                        <!--end::Territory=-->

                                        <!--begin::Order Date=-->
                                        <td>
                                            {{-- {{ $order_invoice->created_at->setTimezone('Asia/Dhaka')->format('d M, Y / h:i A') }} --}}

                                            {{ $orderInvoice->created_at->setTimezone('Asia/Dhaka')->format('d M, Y') }}<br>
                                            {{ $orderInvoice->created_at->setTimezone('Asia/Dhaka')->format('h:i A') }}
                                        </td>
                                        <!--end::Order Date=-->

                                        <!--begin::Order Value=-->
                                        <td>{{ $orderInvoice->total_amount }} Tk</td>
                                        <!--end::Order Value=-->

                                        <!--begin::Status=-->
                                        <td>
                                            <div class="badge badge-light-warning">{{ $orderInvoice->status }}</div>
                                        </td>
                                        <!--end::Status=-->

                                        <!--begin::Action=-->
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                Actions

                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>

                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('order.invoice', $orderInvoice->id) }}" class="menu-link px-3">
                                                        View
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="javascript:void(0);" onclick="update_invoice('{{ route('order.update_invoice', $orderInvoice->id) }}')" class="menu-link px-3">
                                                        Accept
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="javascript:void(0);" onclick="destroy({{ $orderInvoice->id }}, '{{ route('order.cancel_invoice', ['id' => ':id']) }}')" class="menu-link px-3">
                                                        Cancel
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                        <!--end::Action=-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->

                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">Total:</div>
                                    </td>
                                    <td class="fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($order_value, 2) }} Tk</div>
                                    </td>
                                    {{-- <td class="fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($discount_value, 2) }} Tk</div>
                                    </td> --}}
                                    {{-- <td class="fw-bold">
                                        <div class="badge badge-light-info" style="font-size: 14px;">{{ number_format($payable_value, 2) }} Tk</div>
                                    </td> --}}
                                </tr>
                            </tfoot>
                        </table>
                        <!--end::Table-->

                        <div class="pagination-container mt-10">
                            <nav>
                                {{ $orderInvoices->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

                <!--begin::Modals-->
                <div class="modal fade" id="inv_accept_confirmation" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Invoice Create Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to Accept this order invoice?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success inv_accepted">Create</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Modal -->
                <div class="modal fade" id="stockErrorModal" tabindex="-1" aria-labelledby="stockErrorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="stockErrorModalLabel">Stock Error</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body text-danger" id="stockErrorMessage">
                                <!-- Error message will be inserted here -->
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!--begin::modal - Destroy-->
                @include('Access::layouts.destroy')
                <!--end::modal - Destroy-->
                <!--end::Modals-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>  
@endsection

@push('scripts')
    <script>
        function update_invoice(action) {
            $('#inv_accept_confirmation').modal('show');

            $('.inv_accepted').on('click', function () {
                $.ajax({
                    url: action,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#inv_accept_confirmation').modal('hide');

                        toastr.success('Invoice created successfully');

                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#inv_accept_confirmation').modal('hide');

                        // console.error('Failed to create order invoice', xhr);

                        // Check for validation or custom error
                        if (xhr.status === 400 || xhr.status === 404) {
                            const errorMessage = xhr.responseJSON?.error || 'An unknown error occurred';

                            // Set and show the stock error modal
                            $('#stockErrorMessage').text(errorMessage);
                            $('#stockErrorModal').modal('show');
                        } else {
                            console.error('Unexpected error:', xhr);
                        }
                    }
                });
            });
        }
    </script>
@endpush