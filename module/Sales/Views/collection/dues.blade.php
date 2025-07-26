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
                        <form class="d-flex align-items-center position-relative my-1" action="{{ route('collection.dues') }}" method="GET">
                            <!--begin::Search-->
                            <div class="w-110 mw-120px me-2">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                {{-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span> --}}
                                <!--end::Svg Icon-->
                                
                                <input name="invoice_number" value="{{ request('invoice_number') }}" type="text" data-kt-permissions-table-filter="search" class="form-control form-control-solid" placeholder="Invoice Number" />
                            </div>
                            <!--end::Search-->

                            <!--begin::Search-->
                            <div class="w-110 mw-120px me-2">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                {{-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span> --}}
                                <!--end::Svg Icon-->

                                <input name="username" value="{{ request('username') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid" placeholder="Employee ID" />
                            </div>
                            <!--end::Search-->

                            <!--begin::Search-->
                            <div class="w-110 mw-120px me-2">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                {{-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                    </svg>
                                </span> --}}
                                <!--end::Svg Icon-->

                                <input name="code_number" value="{{ request('code_number') }}" type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid" placeholder="Sale Point Number" />
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

                            <!--begin::Depot-->
                            <div class="w-110 mw-120px me-2">
                                <!--begin::Select2-->
                                <select name="payment_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Payment Type" data-kt-ecommerce-product-filter="status">
                                    <option></option>
                                    <option value="Cash" {{ request('payment_type') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Credit" {{ request('payment_type') == 'Credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="Partial Credit" {{ request('payment_type') == 'Partial Credit' ? 'selected' : '' }}>Partial Credit</option>
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
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-10px">S.N</th>
                                <th class="min-w-80px">Invoice No</th>
                                <th class="min-w-80px">Order By</th>
                                <th class="min-w-80px">Sale Point Name</th>
                                <th class="min-w-50px">Territory</th>
                                <th class="min-w-80px">Invoice Date/Time</th>
                                <th class="min-w-80px">Collection Date/Time</th>
                                <th class="min-w-60px">Order Value</th>
                                <th class="min-w-60px">Addi. Dis.</th>
                                <th class="min-w-60px">Return</th>
                                <th class="min-w-60px">Payable Amount</th>
                                <th class="min-w-60px">Paid</th>
                                <th class="min-w-60px">Due</th>
                                <th class="text-end min-w-60px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-black-600">
                            @foreach ($collections as $key => $collection)
                                <tr>
                                    <!--begin::S.N=-->
                                    <td>{{ $key + 1 }}</td>
                                    <!--end::S.N=-->

                                    <!--begin::Invoice number=-->
                                    <td class="pe-0">
                                        {{-- <a href="{{ route('order_management.order_invoice', $collection->order_invoice->id) }}">
                                            {{ $collection->order_invoice->invoice_number }}
                                        </a> --}}
                                        <a href="javascript:void(0)">{{ $collection->orderInvoice->invoice_number }}</a>
                                    </td>
                                    <!--end::Invoice number=-->

                                    <!--begin::Order by=-->
                                    <td>{{ $collection->orderInvoice->user->name }}</td>
                                    <!--end::Order by=-->

                                    <!--begin::Sale point name=-->
                                    <td>
                                        {{ $collection->orderInvoice->salePoint->name }}
                                        {{-- ({{ $collection->order_invoice->sales_point->code_number }}) --}}
                                    </td>
                                    <!--end::Sale point name=-->

                                    <!--begin::Depot name=-->
                                    <td>{{ $collection->orderInvoice->territory->name }}</td>
                                    <!--end::Depot name=-->

                                    <!--begin::Invoice Date/Time=-->
                                    {{-- work left for data --}}
                                    <td> 
                                        {{ $collection->orderInvoice->created_at->setTimezone('Asia/Dhaka')->format('d M, Y') }} <br>
                                        {{ $collection->orderInvoice->created_at->setTimezone('Asia/Dhaka')->format('h:i A') }}
                                    </td>
                                    <!--end::Invoice Date/Time=-->

                                    <!--begin::Invoice Date/Time=-->
                                    {{-- work left for data --}}
                                    <td>
                                        {{ $collection->orderInvoice->updated_at->setTimezone('Asia/Dhaka')->format('d M, Y') }} <br>
                                        {{ $collection->orderInvoice->updated_at->setTimezone('Asia/Dhaka')->format('h:i A') }}
                                    </td>
                                    <!--end::Invoice Date/Time=-->

                                    <!--begin::Order value=-->
                                    <td>{{ $collection->orderInvoice->total_amount }} Tk</td>
                                    <!--end::Order value=-->

                                    <!--begin::Addi dis=-->
                                    @if ($collection->previous_addi_dis_amount)
                                        <td>{{ $collection->previous_addi_dis_amount }} Tk</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <!--end::Addi dis=-->

                                    <!--begin::Return Amount=-->
                                    @if ($collection->orderInvoice->return_amount)
                                        <td>{{ $collection->orderInvoice->return_amount }} Tk</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <!--end::Return Amount=-->

                                    <!--begin::Payable Amount=-->
                                    <td>{{ $collection->orderInvoice->total_amount - $collection->orderInvoice->return_amount }} Tk</td>
                                    <!--end::Payable Amount=-->

                                    

                                    

                                    <!--begin::Previous Payment=-->
                                    @if ($collection->previous_payment)
                                        <td>{{ $collection->previous_payment }} Tk</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <!--end::Previous Payment=-->

                                    

                                    <!--begin::Payable Amount=-->
                                    <td>{{ $collection->due }} Tk</td>
                                    <!--end::Payable Amount=-->

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
                                            {{-- <div class="menu-item px-3">
                                                <a href="{{ route('order_management.order_invoice', $collection->order_invoice->id) }}" class="menu-link px-3">View</a>
                                            </div> --}}
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" onclick="collection({{ $collection->id }})" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                    Collection
                                                </a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="" class="menu-link px-3">Partial Return</a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            @if ($collection->status === 'Due')
                                                <div class="menu-item px-3">
                                                    <a data-collection_id="{{ $collection->id }}"
                                                        id="full_return_collection_{{ $collection->id }}"  
                                                        href="javascript:void(0);" 
                                                        class="menu-link px-3" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#full_return_confirmation">
                                                        Full Return
                                                    </a>
                                                </div>
                                            @endif
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                    <!--end::Action=-->
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->

                        <tfoot></tfoot>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <!--begin::Modals-->
            @include('Sales::collection.modals.due')

            <div class="modal fade" id="full_return_confirmation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Full Return Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to Fully Return all orders?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="confirmReturn">Return</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>  
@endsection

@push('scripts')
    <script>

        // document.addEventListener('DOMContentLoaded', function () {
            // Attach event listeners to all menu links
            document.querySelectorAll('[id^="full_return_collection_"]').forEach(link => {
                link.addEventListener('click', function () {
                    const collectionId = this.getAttribute('data-collection_id');
                    const confirmButton = document.getElementById('confirmReturn');

                    // Update the click event for the confirm button dynamically
                    ///////
                });
            });
        // });

    </script>
@endpush

{{-- confirmButton.onclick = function () {
                        const url = "{{ route('collection.return_order', ':id') }}".replace(':id', collectionId);
                        window.location.href = url;
                    }; --}}