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
                        <form class="d-flex align-items-center position-relative my-1" action="{{ route('stocks') }}" method="GET">
                            <!--begin::Search-->
                            <div class="w-110 mw-120px me-2">
                                <input name="code_number" value="{{ request('code_number') }}" type="text" class="form-control form-control-solid" placeholder="Sale Point Number" />
                            </div>
                            <!--end::Search-->

                            <button type="submit" class="btn btn-light-primary">Search</button>
                        </form>
                    </div>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        @if(auth()->user()->hasPermission('stock', 'stocks', 'create'))
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->

                                Add Stoks
                            </button>
                        @endif
                        <!--end::Button-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-10px">S.N</th>
                                <th class="min-w-80px">Stock Kipping Unit (SKU)</th>
                                <th class="min-w-80px">Product Name</th>
                                <th class="min-w-80px">MRP</th>
                                <th class="min-w-80px text-end">Quantity</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-black-200">
                            @foreach ($stocks as $key => $stock)
                                <tr class="hover-row">
                                    <td>{{ $stocks->firstItem() + $key }}</td>

                                    <!--begin::SKU=-->
                                    <td>{{ $stock->sku }}</td>
                                    <!--end::SKU=-->

                                    <!--begin::Product=-->
                                    <td>{{ $stock->product_name }}</td>
                                    <!--end::Product=-->

                                    <!--begin::MRP=-->
                                    <td>{{ $stock->mrp }} tk</td>
                                    <!--end::MRP=-->

                                    <!--begin::Stock Quantity=-->
                                    <td class="text-end">{{ $stock->quantity }} pcs</td>
                                    <!--end::Stock Quantity=-->
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->

                    <div class="pagination-container mt-10">
                        <nav>
                            {{ $stocks->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <!--begin::Modals-->
            <!--begin::Modal - Add Sale Point-->
            @include('Inventory::stocks.modals.add')
            <!--end::Modal - Add Sale Point-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>  
@endsection

@push('scripts')
    <script>
        // Trigger addPair() when the modal is fully shown
        $('#kt_modal_add_permission').on('shown.bs.modal', function () {
            // Only add one initial pair when opening the modal
            if ($('#stockContainer .pair-group').length === 0) {
                addPair();
            }
        });
    </script>
@endpush