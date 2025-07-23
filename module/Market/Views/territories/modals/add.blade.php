<div class="modal fade" id="kt_modal_add_permission" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add a Territory</h2>
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
                <form method="POST" action="{{ route('location.store_territory') }}" id="kt_modal_add_permission_form" class="form">
                    @csrf
                    <div class="fv-row mb-7">
                        <!--begin::Select store template-->
                        <label class="form-label">Select a Sub Area</label>
                        <!--end::Select store template-->
                        <!--begin::Select2-->
                        <select onchange="sub_area()" id="sub_area_id" name="sub_area_id" data-dropdown-parent="#kt_modal_add_permission" data-control="select2" data-placeholder="Select a sub area" class="form-select form-select-solid">
                            <option></option>
                            @foreach ($sub_areas as $sub_area)
                                <option value="{{ $sub_area->id }}">{{ ucfirst($sub_area->name) }}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>
                    
                    <!--begin::Input group-->
                    <div id="region_zone_area_div" style="display: none">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mb-2">Area</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input id="area_input" class="form-control form-control-solid" readonly />
                            <!--end::Input-->
                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mb-2">Region</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input id="region_input" class="form-control form-control-solid" readonly />
                            <!--end::Input-->
                        </div>

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mb-2">Zone</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input id="zone_input" class="form-control form-control-solid" readonly />
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2">
                            <span class="required">Territory Name</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Territory names is required to be unique."></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Enter a territory name" name="name" required />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                   
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
    function sub_area() {
        let sub_area_id = $('#sub_area_id').val();
        let url = "{{ route('location.associated_region_zone_area_by_sub_area_', ['id' => ':sub_area_id']) }}";
        let action = url.replace(':sub_area_id', sub_area_id);

        $('#area_input').empty();
        $('#region_input').empty();
        $('#zone_input').empty();

        if (sub_area_id !== "") {
            $.ajax({
                url: action,
                method: 'GET',
                success: function (response) {
                    let area_value = response.region_zone_area.area.name;
                    let region_value = response.region_zone_area.area.region.name;
                    let zone_value = response.region_zone_area.area.region.zone.name;

                    $('#region_zone_area_div').show();

                    $('#area_input').val(area_value);
                    $('#region_input').val(region_value);
                    $('#zone_input').val(zone_value);
                    
                },
                error: function (error) {
                    console.log('Error fetching sub area model data:', error);
                }
            });
        } else {
            $('#region_zone_area_div').hide()
        }
    }
</script>