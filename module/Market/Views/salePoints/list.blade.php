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
                        <form class="d-flex align-items-center position-relative my-1" action="{{ route('salePoints') }}" method="GET">
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
                        @if(auth()->user()->hasPermission('sale-point', 'sale-points', 'create'))
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->

                                Add Sale Point
                            </button>
                        
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_bulk_upload">
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
                                <th class="min-w-80px">Name</th>
                                <th class="min-w-80px">Address</th>
                                <th class="min-w-80px">Contact Person</th>
                                <th class="min-w-70px text-end">Territory</th>
                                @if(auth()->user()->hasPermission('sale-point', 'sale-points', 'update'))
                                    <th class="min-w-80px">Is Active</th>
                                @endif

                                @if(
                                    auth()->user()->hasPermission('sale-point', 'sale-points', 'update') ||
                                    auth()->user()->hasPermission('sale-point', 'sale-points', 'delete')
                                )
                                    <th class="text-end min-w-100px">Actions</th>
                                @endif
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-black-200">
                            @foreach ($salePoints as $key => $salePoint)
                                <tr class="hover-row">
                                    <td>{{ $salePoints->firstItem() + $key }}</td>

                                    <!--begin::Name=-->
                                    <td>
                                        {{ $salePoint->name }} <br>
                                        ({{ $salePoint->code_number }})
                                    </td>
                                    <!--end::Name=-->

                                    <!--begin::Address=-->
                                    <td>{{ $salePoint->address }}</td>
                                    <!--end::Address=-->

                                    <!--begin::Contact person=-->
                                    <td>
                                        @if ($salePoint->contact_name)
                                            {{ $salePoint->contact_name }} <br>
                                        @endif
                                        {{ $salePoint->contact_number }}
                                    </td>
                                    <!--end::Contact person=-->

                                    <!--begin::Territory=-->
                                    <td class="text-end">
                                        @if ($salePoint->territory)
                                            {{ $salePoint->territory->name }}
                                        @endif
                                    </td>
                                    <!--end::Territory=-->

                                    <!--begin::Is Active=-->
                                    @if(auth()->user()->hasPermission('sale-point', 'sale-points', 'update'))
                                        <td>
                                            <select 
                                                onchange="statusUpdate(this, {{ $salePoint->id }}, '{{ route('update_salePoint', ['id' => ':id']) }}')"
                                                data-current_status="{{ $salePoint->is_active }}"
                                                class="form-select form-select-solid" 
                                                data-control="select2" 
                                                data-hide-search="true">
                                                <option value="Active" {{ $salePoint->is_active == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ $salePoint->is_active == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </td>
                                    @endif
                                    <!--end::Is Active=-->
                                    
                                    <!--begin::Action=-->
                                    @if(
                                        auth()->user()->hasPermission('sale-point', 'sale-points', 'update') ||
                                        auth()->user()->hasPermission('sale-point', 'sale-points', 'delete')
                                    )
                                        <td class="text-end">
                                            <!--begin::Update-->
                                            @if(auth()->user()->hasPermission('sale-point', 'sale-points', 'update'))
                                                <button onclick="sale_point({{ $salePoint->id }})" title="Update Sale Point" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="currentColor" />
                                                            <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            @endif
                                            <!--end::Update-->

                                            <!--begin::Delete-->
                                            @if(auth()->user()->hasPermission('sale-point', 'sale-points', 'delete'))
                                                <button onclick="destroy({{ $salePoint->id }}, '{{ route('destroy_salePoint', ['id' => ':id']) }}')" title="Delete Sale Point" class="btn btn-icon btn-active-light-primary w-30px h-30px">
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
                                            @endif
                                            <!--end::Delete-->
                                        </td>
                                    @endif
                                    <!--end::Action=-->
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->

                    <div class="pagination-container mt-10">
                        <nav>
                            {{ $salePoints->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <!--begin::Modals-->
            <!--begin::Modal - Add Sale Point-->
            @include('Market::salePoints.modals.add')
            <!--end::Modal - Add Sale Point-->

            <!--begin::modal - Deactivate-->
            @include('Access::layouts.deactivate')
            <!--end::modal - Deactivate-->

            <!--begin::Modal - Update Sale Point-->
            @include('Market::salePoints.modals.update')
            <!--end::Modal - Update Sale Point-->

            <!--begin::modal - Destroy-->
            @include('Access::layouts.destroy')
            <!--end::modal - Destroy-->

            <!--begin::Modal - Bulk Upload-->
            <div class="modal fade" id="kt_modal_bulk_upload" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('bulk_upload_salePoints') }}" class="form" enctype="multipart/form-data" id="bulk_upload_salePoints_form">
                            @csrf
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">Upload files</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->

                            <!--begin::Modal body-->
                            <div class="modal-body pt-10 pb-15 px-lg-17">
                                <!--begin::Input group-->
                                <div class="form-group mb-5">
                                    <!--begin::Dropzone-->
                                    <div class="mb-2">
                                        <label class="mb-2" for="file">Attach File</label>
                                        <input type="file" class="form-control" name="file" accept=".xlsx">
                                    </div>
                                    <!--end::Dropzone-->

                                    <!--begin::Hint-->
                                    <span class="form-text fs-6 text-muted">The file type should be xlsx.</span>
                                    <!--end::Hint-->
                                </div>
                                <!--end::Input group-->

                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                                    <button type="submit" class="btn btn-primary" onclick="bulkUploadSalePointsForm(event, this)">Submit</button>
                                </div>
                            </div>
                            <!--end::Modal body-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
            <!--end::Modal - Bulk Upload-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>  
@endsection

@push('scripts')
    <script>
        function sale_point(id) {
            let url = "{{ route('salePoint', ['id' => ':id']) }}";
            let action = url.replace(':id', id);

            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    const form = $('#kt_modal_update_permission_form');

                    let url = "{{ route('update_salePoint', ['id' => ':id']) }}";
                    let updateUrl = url.replace(':id', id);
                    form.attr('action', updateUrl);

                    form.find('input[name="name"]').val(data.salePoint.name);
                    form.find('input[name="address"]').val(data.salePoint.address);
                    form.find('input[name="contact_name"]').val(data.salePoint.contact_name);
                    form.find('input[name="contact_number"]').val(data.salePoint.contact_number);
                    form.find('select[name="territory_id"]').val(data.salePoint.territory_id).trigger('change');
                },
                error: function (error) {
                    console.error('Error fetching sale point data:', error);
                }
            });
        }

        function bulkUploadSalePointsForm(event, button) {
            event.preventDefault();
            const form = document.getElementById('bulk_upload_salePoints_form');
            const url = form.getAttribute('action');
            let formData = new FormData(form);

            // Disable the button and show loading
            $(button).prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm align-middle me-2"></span>Submitting...'
            );

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success(response.message);

                    $('#kt_modal_bulk_upload').modal('hide');

                    setTimeout(function () {
                        location.reload();
                    }, 1500); // 1 second delay
                },
                error: function (xhr) {
                    let errorMessage = 'Failed to upload items';

                    // Try to extract error message from JSON response
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    toastr.error(errorMessage);
                    console.error(xhr);
                },
                complete: function () {
                    // Re-enable the button
                    $(button).prop('disabled', false).html('Submit');
                }
            });
        }
    </script>
@endpush

