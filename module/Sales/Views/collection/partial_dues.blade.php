@extends('layouts.app')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    @include('pages.breadcrumb')
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-permissions-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Order Invoice" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                    <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                    <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Create Order
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Invoice No</th>
                                <th class="min-w-80px">Order By</th>
                                <th class="min-w-125px">Sale Point Name</th>
                                <th class="min-w-70px">Depot</th>
                                <th class="min-w-80px">Collected Date</th>
                                <th class="min-w-100px">Order Value</th>
                                <th class="min-w-70px">Sale Point Dis.</th>
                                <th class="min-w-70px">Addi. Dis.</th>
                                <th class="min-w-70px">Collection Amount</th>
                                <th class="min-w-70px">Collected Amount</th>
                                <th class="min-w-70px">Due</th>
                                <th class="min-w-50px">status</th>
                                <th class="text-end min-w-80px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @foreach ($partial_payment as $partial)
                                <tr>
                                    <!--begin::Invoice number=-->
                                    <td class="pe-0">
                                        <a href="{{ route('order_management.order_invoice', $partial->order_invoice->id) }}" class="text-gray-700 text-hover-primary fs-5 fw-bolder">#{{ $partial->order_invoice->invoice_number }}</a>
                                    </td>
                                    <!--end::Invoice number=-->

                                    <!--begin::Order by=-->
                                    <td>{{ $partial->order_invoice->user->employee->name }}</td>
                                    <!--end::Order by=-->

                                    <!--begin::Sale point name=-->
                                    <td>{{ $partial->order_invoice->sales_point->name }}</td>
                                    <!--end::Sale point name=-->

                                    <!--begin::Depot name=-->
                                    <td>{{ $partial->order_invoice->sales_point->depot->name }}</td>
                                    <!--end::Depot name=-->

                                    <!--begin::Collected date=-->
                                    <td>{{ $partial->updated_at }}</td>
                                    <!--end::Collected date=-->

                                    <!--begin::Order value=-->
                                    <td>{{ $partial->order_invoice->total_amount }} Tk</td>
                                    <!--end::Order value=-->

                                    <!--begin::Sale point dis=-->
                                    @if ($partial->order_invoice->sell_discount_amount !== null)
                                        <td>{{ $partial->order_invoice->sell_discount_amount }} Tk</td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                    <!--end::Sale point dis=-->

                                    <!--begin::Additional discount amount=-->
                                    @if ($partial->order_invoice->additional_discount_amount > 0)
                                        <td>{{ $partial->order_invoice->additional_discount_amount }} Tk</td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                    <!--end::Additional discount amount=-->

                                    <!--begin::Collection amount=-->
                                    <td>{{ $partial->collection_amount }} Tk</td>
                                    <!--end::Collection amount=-->
                                    
                                    <!--begin::Collected amount=-->
                                    <td>{{ $partial->collected_amount }} Tk</td>
                                    <!--end::Collected amount=-->

                                    <!--begin::Due=-->
                                    <td>{{ $partial->due }} Tk</td>
                                    <!--end::Due=-->

                                    <!--begin::Status=-->
                                    <td>
                                        <div class="badge badge-light-warning">{{ $partial->status }}</div>
                                    </td>
                                    <!--end::Status=-->
                                    
                                    <!--begin::Action=-->
                                    <td class="text-end">
                                        <!--begin::Update-->
                                        <button onclick="collection({{ $partial->id }})" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
                                                    <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--end::Update-->
                                        <!--begin::Delete-->
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--end::Delete-->
                                    </td>
                                    <!--end::Action=-->
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <!--begin::Modal - Update permissions-->
            @include('collection.modals.partial_due')
            <!--end::Modal - Update permissions-->

            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this item?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger btn-confirm-delete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>  
@endsection