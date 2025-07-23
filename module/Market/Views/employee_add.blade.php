<div class="modal fade" id="employee_add" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Employee Add</h2>
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
                <form id="employee_add" class="form">
                    <div id="zoneEmpDiv" class="fv-row mb-7" style="display: none">
                        <label class="form-label">Zone Employees</label>

                        <!--begin::Select2-->
                        <select id="zone_user_id" data-dropdown-parent="#employee_add" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select zone employee" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($zone_employees as $zone_employee)
                                <option value="{{ $zone_employee->id }}">
                                    {{ ucfirst($zone_employee->name) }} ({{ $zone_employee->user->username }})
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="regionEmpDiv" class="fv-row mb-7" style="display: none">
                        <label class="form-label">Region Employees</label>

                        <!--begin::Select2-->
                        <select id="region_user_id" data-dropdown-parent="#employee_add" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select region employee" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($region_employees as $region_employee)
                                <option value="{{ $region_employee->id }}">
                                    {{ ucfirst($region_employee->name) }} ({{ $region_employee->user->username }})
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="areaEmpDiv" class="fv-row mb-7" style="display: none">
                        <label class="form-label">Area Employees</label>

                        <!--begin::Select2-->
                        <select id="area_user_id" data-dropdown-parent="#employee_add" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select area employee" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($area_employees as $area_employee)
                                <option value="{{ $area_employee->id }}">
                                    {{ ucfirst($area_employee->name) }} ({{ $area_employee->user->username }})
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="sub_areaEmpDiv" class="fv-row mb-7" style="display: none">
                        <label class="form-label">Sub Area Employees</label>

                        <!--begin::Select2-->
                        <select id="sub_area_user_id" data-dropdown-parent="#employee_add" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select sub area employee" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($sub_area_employees as $sub_area_employee)
                                <option value="{{ $sub_area_employee->id }}">
                                    {{ ucfirst($sub_area_employee->name) }} ({{ $sub_area_employee->user->username }})
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="territoryEmpDiv" class="fv-row mb-7" style="display: none">
                        <label class="form-label">Territory Employees</label>

                        <!--begin::Select2-->
                        <select id="territory_user_id" data-dropdown-parent="#employee_add" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select territory employee" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($territory_employees as $territory_employee)
                                <option value="{{ $territory_employee->id }}">
                                    {{ ucfirst($territory_employee->name) }} ({{ $territory_employee->user->username }})
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>
                   
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary">
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
    function employee_add(type, id) {
        const form = $('#employee_add');
        
        // Hide all employee divisions
        $('#zoneEmpDiv, #regionEmpDiv, #areaEmpDiv, #sub_areaEmpDiv, #territoryEmpDiv').hide();

        // Dynamically show the specific division based on the type
        const divId = `#${type}EmpDiv`;        
        $(divId).show();

        // Add change event listener for dropdown within the selected division
        $(`${divId} select`).on('change', function () {
            const selectedEmpId = $(this).val(); // Get selected employee ID

            if (selectedEmpId) {
                // Replace :employee_id with the selected employee ID in the route
                let url = "{{ route('user_management.update_employee', ['id' => ':employee_id']) }}";
                let action = url.replace(':employee_id', selectedEmpId);
                form.data('action', action); // Update the form's action attribute
            }
        });

        // Handle form submission with AJAX
        form.on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            const action = form.data('action'); // Get the dynamic action URL

            let idToSend = '';
            if (type === 'zone') {
                idToSend = id;
            } else if (type === 'region') {
                idToSend = id;
            } else if (type === 'area') {
                idToSend = id;
            } else if (type === 'sub_area') {
                idToSend = id;
            } else if (type === 'territory') {
                idToSend = id;
            }

            const formData = form.serialize() + type + '_id=' + idToSend;

            $.ajax({
                url: action,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log('Success:', response);
                    window.location.href = "{{ route('location.design') }}";
                },
                error: function (xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        });
    }
</script>