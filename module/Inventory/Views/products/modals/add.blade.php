<div class="modal fade" id="kt_modal_add_product" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add Product</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
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
                <form method="POST" action="" class="form" id="kt_modal_add_product_form" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-bold fs-6 mb-2">Product Thumbnail</label>
                            <!--end::Label-->

                            <!--begin::Image input-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(assets/media/svg/files/blank-image.svg)">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Preview existing avatar-->

                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->

                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->

                                <!--begin::Hint-->
                                <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Image input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required form-label">Select a Category</label>
                            <!--end::Label-->
                            
                            <!--begin::Select2-->
                            <select onchange="category()" id="category_id" name="category_id" data-dropdown-parent="#kt_modal_add_product" class="form-select mb-2" data-control="select2" data-placeholder="Select a category">
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                @endforeach
                            </select>
                            <!--end::Select2-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="sub_category_div" style="display: none;">
                            <!--begin::Label-->
                            <label class="required form-label">Select a Sub Category</label>
                            <!--end::Label-->

                            <!--begin::Select2-->
                            <select id="sub_category_id" name="sub_category_id" data-dropdown-parent="#kt_modal_add_product" class="form-select mb-2" data-control="select2" data-placeholder="Select a sub category">
                                <!--option will be populated from ajax request-->
                            </select>
                            <!--end::Select2-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required form-label">Product Name</label>
                            <!--end::Label-->
                            
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control mb-2" placeholder="Product name" value="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required form-label">SKU</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" name="sku" class="form-control mb-2" placeholder="SKU Number" value="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">Discard</button>

                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Add</span>
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
    function category() {
        let url = "";
        let category_id = $('#category_id').val();
        let action = url.replace(':category_id', category_id);

        $('#sub_category_id').empty();

        if (category_id !== "") {
            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    $('#sub_category_id').append('<option></option>');
                    $.each(data.sub_categories, function (key, sub_category) {
                        $('#sub_category_id').append('<option value="' + sub_category.id + '">' + sub_category.name + '</option>');
                    });

                    $('#sub_category_div').show();
                },
                error: function (error) {
                    console.log('Error fetching sub categories data:', error);
                }
            });
        } else {
            $('#sub_category_div').hide();
        }
    }

    function country() {
        let url = "";
        let country_id = $('#country_id').val();
        let action = url.replace(':country_id', country_id);

        $('#supplier_id').empty();

        if (country_id !== "") {
            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    $('#supplier_id').append('<option></option>');
                    $.each(data.suppliers, function (key, supplier) {
                        $('#supplier_id').append('<option value="' + supplier.id + '">' + supplier.name + '</option>');
                    });

                    $('#supplier_div').show();
                },
                error: function (error) {
                    console.log('Error fetching supplier data:', error);
                }
            });
        } else {
            $('#supplier_div').hide();
        }
    }
</script>