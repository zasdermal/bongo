<div class="modal fade" id="kt_modal_update_user" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Update Employee</h2>
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
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form method="POST" id="kt_modal_update_user_form" class="form">
                    @csrf
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="form-label">Username</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" name="username" readonly />
                        <!--end::Input-->
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2 required">Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Type name" name="name" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <div class="fv-row mb-7">
                        <!--begin::Select store template-->
                        <label class="required form-label">Role</label>
                        <!--end::Select store template-->

                        <!--begin::Select2-->
                        <select name="role_id" data-dropdown-parent="#kt_modal_update_user" data-control="select2" data-placeholder="Select role" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div class="fv-row mb-7">
                        <!--begin::Select designation-->
                        <label class="form-label">Designation</label>
                        <!--end::Select designation-->
                        <!--begin::Select2-->
                        <select id="designation_id" name="designation_id" data-dropdown-parent="#kt_modal_update_user" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select designation" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}" data-designation_slug="{{ $designation->slug }}">
                                    {{ ucfirst($designation->name) }}
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="zone_div" style="display: none">
                        <div class="fv-row mb-2" style="display: flex; align-items: center;">
                            <!--begin::Label-->
                            <label class="form-label" style="font-size: 1.1rem; color: #333; margin-right: 10px;">Assigned Zone:</label>
                            <!--end::Label-->

                            <h6 style="color: #0056b3;" name="zone_name"></h6>
                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Select designation-->
                            <label class="form-label">Assign Zone</label>
                            <!--end::Select designation-->
                            <!--begin::Select2-->
                            <select id="zone_id" data-dropdown-parent="#kt_modal_update_user" name="zone_id" class="form-select-solid form-select mb-2" data-control="select2" class="form-select form-select-solid">
                                <option value="">None</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ ucfirst($zone->name) }}</option>
                                @endforeach
                            </select>
                            <!--end::Select2-->
                        </div>
                    </div>

                    <div class="fv-row mb-7" id="division_div" style="display: none">
                        <!--begin::Select designation-->
                        <label class="form-label">Division</label>
                        <!--end::Select designation-->
                        <!--begin::Select2-->
                        <select id="division_id" name="division_id" data-dropdown-parent="#kt_modal_update_user" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select division" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ ucfirst($division->name) }}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div class="fv-row mb-7" id="region_div" style="display: none">
                        <!--begin::Select designation-->
                        <label class="form-label">Region</label>
                        <!--end::Select designation-->
                        <!--begin::Select2-->
                        <select id="region_id" data-dropdown-parent="#kt_modal_update_user" name="region_id" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select region" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ ucfirst($region->name) }}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div class="fv-row mb-7" id="area_div" style="display: none">
                        <!--begin::Select designation-->
                        <label class="form-label">Area</label>
                        <!--end::Select designation-->
                        <!--begin::Select2-->
                        <select id="area_id" data-dropdown-parent="#kt_modal_update_user" name="area_id" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select area" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ ucfirst($area->name) }}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div class="fv-row mb-7" id="territory_div" style="display: none">
                        <!--begin::Select designation-->
                        <label class="form-label">Territory</label>
                        <!--end::Select designation-->
                        <!--begin::Select2-->
                        <select id="territory_id" name="territory_id" data-dropdown-parent="#kt_modal_update_user" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select territory" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($territories as $territory)
                                <option value="{{ $territory->id }}">{{ ucfirst($territory->name) }}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2">Contact</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Type contact number" name="contact" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2">Address</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Type address" name="address" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="form-label fw-bolder fs-6 text-gray-700">Joining Date</label>
                        <!--end::Label-->
                        <!--begin::Select-->
                        <input class="form-control form-control-solid" type="date" name="joining_date">
                        <!--end::Select-->
                    </div>
                   
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary" onclick="updateUserForm(this)">
                            <span class="indicator-label">Submit</span>
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
    function updateUserForm(button) {
        let form = $('#kt_modal_update_user_form');
        let url = form.attr('action');

        // Disable the button and show loading
        $(button).prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm align-middle me-2"></span>Submitting...'
        );

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            success: function (response) {
                toastr.success(response.message);

                $('#kt_modal_update_user').modal('hide');

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
                $(button).prop('disabled', false).html('Submit');
            }
        });
    }
</script>