<div class="modal fade" id="kt_modal_update_permission" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Employee Change</h2>
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
                    <div class="fv-row mb-2" style="display: flex; align-items: center;">
                        <!--begin::Label-->
                        <label class="form-label" style="font-size: 1.1rem; color: #333; margin-right: 10px;">Name:</label>
                        <!--end::Label-->

                        <h6 style="color: #0056b3;" name="name_username"></h6>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div id="zoneDiv" class="fv-row mb-2" style="display: none; display: flex; align-items: center;">
                        <!--begin::Label-->
                        <label class="form-label" style="font-size: 1.1rem; color: #333; margin-right: 10px;">Zone:</label>
                        <!--end::Label-->

                        <h6 style="color: #0056b3;" name="zone"></h6>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div id="regionDiv" class="fv-row mb-2" style="display: none; display: flex; align-items: center;">
                        <!--begin::Label-->
                        <label class="form-label" style="font-size: 1.1rem; color: #333; margin-right: 10px;">Region:</label>
                        <!--end::Label-->

                        <h6 style="color: #0056b3;" name="region"></h6>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div id="areaDiv" class="fv-row mb-2" style="display: none; display: flex; align-items: center;">
                        <!--begin::Label-->
                        <label class="form-label" style="font-size: 1.1rem; color: #333; margin-right: 10px;">Area:</label>
                        <!--end::Label-->

                        <h6 style="color: #0056b3;" name="area"></h6>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div id="subAreaDiv" class="fv-row mb-2" style="display: none; display: flex; align-items: center;">
                        <!--begin::Label-->
                        <label class="form-label" style="font-size: 1.1rem; color: #333; margin-right: 10px;">Sub Area:</label>
                        <!--end::Label-->

                        <h6 style="color: #0056b3;" name="sub_area"></h6>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div id="territoryDiv" class="fv-row mb-2" style="display: none; display: flex; align-items: center;">
                        <!--begin::Label-->
                        <label class="form-label" style="font-size: 1.1rem; color: #333; margin-right: 10px;">Territory:</label>
                        <!--end::Label-->

                        <h6 style="color: #0056b3;" name="territory"></h6>
                    </div>
                    <!--end::Input group-->

                    <div id="zoneIdDiv" class="fv-row mb-7" style="display: none;">
                        <label class="form-label">Update Zone</label>

                        <!--begin::Select2-->
                        <select id="zone_id" name="zone_id" data-dropdown-parent="#kt_modal_update_permission" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select zone" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}">
                                    {{ ucfirst($zone->name) }}
                                    —
                                    @if ($zone->user)
                                        ({{ $zone->user->employee->name }} - {{ $zone->user->username }})
                                    @else
                                        (Not Assign)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="regionIdDiv" class="fv-row mb-7" style="display: none;">
                        <label class="form-label">Update Region</label>

                        <!--begin::Select2-->
                        <select id="region_id" name="region_id" data-dropdown-parent="#kt_modal_update_permission" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select region" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">
                                    {{ ucfirst($region->name) }}
                                    /
                                    {{ $region->zone->name }}
                                    —
                                    @if ($region->user)
                                        ({{ $region->user->employee->name }} - {{ $region->user->username }})
                                    @else
                                        (Not Assign)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="areaIdDiv" class="fv-row mb-7" style="display: none;">
                        <label class="form-label">Update Area</label>

                        <!--begin::Select2-->
                        <select id="area_id" name="area_id" data-dropdown-parent="#kt_modal_update_permission" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select area" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">
                                    {{ ucfirst($area->name) }}
                                    /
                                    {{ $area->region->name }}
                                    /
                                    {{ $area->region->zone->name }}
                                    —
                                    @if ($area->user)
                                        ({{ $area->user->employee->name }} - {{ $area->user->username }})
                                    @else
                                        (Not Assign)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="subAreaIdDiv" class="fv-row mb-7" style="display: none;">
                        <label class="form-label">Update Sub Area</label>

                        <!--begin::Select2-->
                        <select id="sub_area_id" name="sub_area_id" data-dropdown-parent="#kt_modal_update_permission" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select sub area" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($sub_areas as $sub_area)
                                <option value="{{ $sub_area->id }}">
                                    {{ ucfirst($sub_area->name) }}
                                    /
                                    {{ $sub_area->area->name }}
                                    /
                                    {{ $sub_area->area->region->name }}
                                    /
                                    {{ $sub_area->area->region->zone->name }}
                                    —
                                    @if ($sub_area->user)
                                        ({{ $sub_area->user->employee->name }} - {{ $sub_area->user->username }})
                                    @else
                                        (Not Assign)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div id="territoryIdDiv" class="fv-row mb-7" style="display: none;">
                        <label class="form-label">Update Territory</label>

                        <!--begin::Select2-->
                        <select id="territory_id" name="territory_id" data-dropdown-parent="#kt_modal_update_permission" class="form-select-solid form-select mb-2" data-control="select2" data-placeholder="Select territory" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($territories as $territory)
                                <option value="{{ $territory->id }}">
                                    {{ ucfirst($territory->name) }}
                                    @if ($territory->sub_area)
                                        / {{ $territory->sub_area->name }}
                                        / {{ $territory->sub_area->area->name }}
                                        / {{ $territory->sub_area->area->region->name }}
                                        / {{ $territory->sub_area->area->region->zone->name }}
                                        —
                                    @endif
                                    
                                    @if ($territory->user)
                                        ({{ $territory->user->employee->name }} - {{ $territory->user->username }})
                                    @else
                                        (Not Assign)
                                    @endif
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
    function employee(div, id) {
        let url = "{{ route('user_management.employee', ['id' => ':employee_id']) }}";
        let action = url.replace(':employee_id', id);

        $.ajax({
            url: action,
            method: 'GET',
            success: function (data) {
                const form = $('#kt_modal_update_permission_form');
                // Clear the existing values
                form.find('h6[name="name_username"]').val('');

                // Assign new values
                let name_username = data.employee.name + ' (' + data.employee.user.username + ')';
                form.find('h6[name="name_username"]').text(name_username);

                 // Conditional assignments
                if (data.employee.zone) {
                    form.find('h6[name="zone"]').val('');
                    form.find('h6[name="zone"]').text(data.employee.zone.name);
                }
                if (data.employee.region) {
                    form.find('h6[name="region"]').val('');
                    let full_text = data.employee.region.name +
                                    ' / ' +
                                    data.employee.region.zone.name;
                    form.find('h6[name="region"]').text(full_text);
                }
                if (data.employee.area) {
                    form.find('h6[name="area"]').val('');
                    let full_text = data.employee.area.name +
                                    ' / ' +
                                    data.employee.area.region.name +
                                    ' / ' +
                                    data.employee.area.region.zone.name;
                    form.find('h6[name="area"]').text(full_text);
                }
                if (data.employee.sub_area) {
                    form.find('h6[name="sub_area"]').val('');
                    let full_text = data.employee.sub_area.name +
                                    ' / ' +
                                    data.employee.sub_area.area.name + 
                                    ' / ' +
                                    data.employee.sub_area.area.region.name +
                                    ' / ' +
                                    data.employee.sub_area.area.region.zone.name;
                    form.find('h6[name="sub_area"]').text(full_text);
                }
                if (data.employee.territory) {
                    form.find('h6[name="territory"]').val('');
                    let full_text = data.employee.territory.name +
                                    ' / ' +
                                    data.employee.territory.sub_area.name +
                                    ' / ' +
                                    data.employee.territory.sub_area.area.name +
                                    ' / ' +
                                    data.employee.territory.sub_area.area.region.name +
                                    ' / ' +
                                    data.employee.territory.sub_area.area.region.zone.name;
                    form.find('h6[name="territory"]').text(full_text);
                }

                // Hide all target divs initially
                $('#zoneDiv').hide();
                $('#regionDiv').hide();
                $('#areaDiv').hide();
                $('#subAreaDiv').hide();
                $('#territoryDiv').hide();

                // Display the specified div based on divId
                const targetDiv = $('#' + div);
                targetDiv.show();

                $('#zoneIdDiv').hide();
                $('#regionIdDiv').hide();
                $('#areaIdDiv').hide();
                $('#subAreaIdDiv').hide();
                $('#territoryIdDiv').hide();

                if (data.employee.designation.slug === 'national-sells-manager' ) {
                    $('#zoneIdDiv').show();
                }
                if (data.employee.designation.slug === 'regional-sells-manager' ) {
                    $('#regionIdDiv').show();
                }
                if (data.employee.designation.slug === 'area-manager' ) {
                    $('#areaIdDiv').show();
                }
                if (data.employee.designation.slug === 'sr-product-associate' ) {
                    $('#subAreaIdDiv').show();
                }
                if (data.employee.designation.slug === 'product-associate' ) {
                    $('#territoryIdDiv').show();
                }

                let url = "{{ route('user_management.update_employee', ['id' => ':employee_id']) }}";
                let action = url.replace(':employee_id', id);
                form.attr('action', action);

            },
            error: function (error) {
                console.error('Error fetching employee data:', error);
            }
        });
    }
</script>