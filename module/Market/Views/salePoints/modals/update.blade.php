<div class="modal fade" id="kt_modal_update_permission" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Update Sale Point</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
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
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form method="POST" id="kt_modal_update_permission_form" class="form">
                    @csrf
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 form-label required">Sale Point Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Type sale point name" name="name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 form-label">Address</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Type address" name="address" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 form-label">Contact Person Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Type contact person name" name="contact_name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 form-label">Contact Person Number</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="no-spinner form-control form-control-solid" placeholder="Type contact person number" name="contact_number" type="number" autocomplete="off" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label">Select Territory</label>

                        <!--begin::Select2-->
                        <select name="territory_id" data-dropdown-parent="#kt_modal_update_permission" class="form-select form-select-solid mb-2" data-control="select2">
                            <option value="">None</option>
                            @foreach ($territories as $territory)
                                <option value="{{ $territory->id }}">
                                    {{ $territory->name }}
                                    
                                    {{ $territory->area?->name ? ' / ' . $territory->area->name : '' }}
                                    {{ $territory->area?->region?->name ? ' / ' . $territory->area->region->name : '' }}
                                    {{ $territory->area?->region?->division?->name ? ' / ' . $territory->area->region->division->name : '' }}
                                    {{ $territory->area?->region?->division?->zone?->name ? ' / ' . $territory->area->region->division->zone->name : '' }}

                                    —

                                    @if ($territory->user)
                                        ({{ $territory->user->name }} - {{ $territory->user->username }})
                                    @else
                                        (Not Assign)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" onclick="updateSalePointForm(this)">
                            <span class="indicator-label">Update</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<script>
    function updateSalePointForm(button) {
        let form = $('#kt_modal_update_permission_form');
        let url = form.attr('action');

        // Disable the button and show loading
        $(button).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm align-middle me-2"></span>Updating...'
        );

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            success: function (response) {
                toastr.success(response.message);

                $('#kt_modal_update_permission').modal('hide');

                setTimeout(function () {
                    location.reload();
                }, 1500); // 1 second delay
            },
            error: function (xhr) {
                $('.text-danger').remove(); // Remove previous errors

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        let input = form.find('[name="' + key + '"]');
                        input.before('<div class="text-danger mb-1">' + messages[0] + '</div>');
                    });
                } else {
                    toastr.error('Something went wrong');
                }
            },
            complete: function () {
                // Re-enable the button
                $(button).prop('disabled', false).html('Update');
            }
        });
    }
</script> 