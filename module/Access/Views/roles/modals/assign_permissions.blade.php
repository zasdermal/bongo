<div class="modal fade" id="kt_modal_assign_permissions" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Assign Role Permissions</h2>
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
            <div class="modal-body scroll-y mx-5 my-7">
                <!--begin::Form-->
                <form method="POST" id="kt_modal_assign_permissions_form" class="form">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="form-label mb-8"></label>
                            <!--end::Label-->
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-bold">
                                        @foreach ($menus as $menu)
                                            <!--begin::Table row-->
                                            <tr>
                                                <!--begin::Label-->
                                                <td class="text-gray-800">
                                                    <div class="badge badge-light-info" style="font-size: 14px;">{{ $menu->name }}</div>
                                                </td>
                                                <!--end::Label-->

                                                <td>
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                        <input class="form-check-input select-all" type="checkbox" id="select_all_{{ $menu->id }}" data-menu_id="{{ $menu->id }}" />
                                                        <span class="form-check-label" for="select_all_{{ $menu->id }}">Select all</span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                </td>
                                                
                                                @foreach ($menu->subMenus as $sub_menu)
                                                    <tr>
                                                        <!--begin::Label-->
                                                        <td class="text-gray-800 ps-10">{{ $sub_menu->name }}</td>
                                                        <!--end::Label-->

                                                        <!--begin::Input group-->
                                                        <td>
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex">
                                                                @foreach ($sub_menu->permissions as $permission)
                                                                    <!--begin::Checkbox-->
                                                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                        <input class="form-check-input permission-checkbox menu_{{ $menu->id }}" type="checkbox" value="{{ $permission->id }}" name="permissions[]" />
                                                                        <span class="form-check-label">{{ $permission->name }}</span>
                                                                    </label>
                                                                    <!--end::Checkbox-->
                                                                @endforeach
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </td>
                                                        <!--end::Input group-->
                                                    </tr>
                                                @endforeach
                                            </tr>

                                            <tr><td colspan="3" style="height: 20px;"></td></tr>
                                            <!--end::Table row-->
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary" onclick="assignPermissionsForm(this)">
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
    function assignPermissionsForm(button) {
        let form = $('#kt_modal_assign_permissions_form');
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

                $('#kt_modal_assign_permissions').modal('hide');

                setTimeout(function () {
                    location.reload();
                }, 1500); // 1 second delay
            },
            error: function (xhr) {
                toastr.error('Failed to assign role permissions');
                console.error(xhr);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Get all 'select-all' checkboxes
        const selectAllCheckboxes = document.querySelectorAll(".select-all");

        selectAllCheckboxes.forEach(selectAll => {
            selectAll.addEventListener("change", function () {
                const id = this.dataset.menu_id; // Get module ID
                const permissionCheckboxes = document.querySelectorAll(`.menu_${id}`);
                
                // Toggle all checkboxes in the module
                permissionCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });
    });
</script>