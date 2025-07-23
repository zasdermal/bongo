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
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Sidebar-->
                    <div class="flex-lg-auto min-w-lg-300px me-xl-10 me-lg-7">
                        <!--begin::Card-->
                        <div class="card" data-kt-sticky="true" data-kt-sticky-name="invoice" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', lg: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                            <!--begin::Card body-->
                            <div class="card-body p-10">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder fs-6 text-gray-700 required">Employee</label>
                                    <!--end::Label-->

                                    <!--begin::Select Product Name-->
                                    <select onchange="user()" id="user_id" data-control="select2" data-placeholder="Select Employee" class="form-select form-select-solid">
                                        <option></option>
                                        @foreach ($users as $user)
                                            <option 
                                                value="{{ $user->id }}" 
                                                data-territory_id="{{ $user->employee->territory_id }}"
                                                >
                                                {{ $user->name }} - ({{ $user->employee->territory->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select Product Name-->
                                </div>
                                <!--end::Input group-->
                                
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder fs-6 text-gray-700 required">Sale Point</label>
                                    <!--end::Label-->

                                    <!--begin::Select Product-->
                                    <select id="sale_point_id" data-control="select2" data-placeholder="Select Sale Point" class="form-select form-select-solid">
                                        <!--option will be populated from ajax request-->
                                    </select>
                                    <!--end::Select Product-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder fs-6 text-gray-700 required">Products</label>
                                    <!--end::Label-->

                                    <!--begin::Select Product-->
                                    <select id="stock_id" data-control="select2" data-placeholder="Select product" class="form-select form-select-solid">
                                        <option></option>
                                        @foreach ($stocks as $stock)
                                            <option 
                                                value="{{ $stock->id }}"
                                                data-product_name="{{ $stock->product_name }}"
                                                data-sku="{{ $stock->sku }}"
                                                data-mrp="{{ $stock->mrp }}"
                                                >
                                                {{ $stock->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select Product-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder fs-6 text-gray-700 required">Quantity</label>
                                    <!--end::Label-->

                                    <!--begin::Quantity-->
                                    <input id="quantity" class="no-spinner form-control form-control-solid" type="number" required />
                                    <!--end::Quantity-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Actions-->
                                <div class="mb-0">
                                    <button onclick="add_product()" class="btn btn-primary w-100">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="currentColor" />
                                                <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->

                                        Add Product
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Sidebar-->
                    
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid mb-10 mb-lg-0">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Form-->
                                <form id="kt_invoice_form">
                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive mb-10">
                                            <!--begin::Table-->
                                            <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                                        <th class="min-w-200px">Product</th>
                                                        <th class="min-w-100px">QTY</th>
                                                        <th class="min-w-100px">Unit Price</th>
                                                        <th class="min-w-100px text-end">Total</th>
                                                        <th class="min-w-100px text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->

                                                <!--begin::Table body-->
                                                <tbody id="product_list">
                                                    <!--tbody will populate data from js function (display_products())-->
                                                </tbody>
                                                <!--end::Table body-->

                                                <!--begin::Table foot-->
                                                <tfoot id="invoice_footer">
                                                    <tr class="align-top fw-bolder text-gray-700">
                                                        <th></th>

                                                        <th colspan="2" class="fs-4 ps-0">Total</th>
                                                        <th colspan="2" class="text-end fs-4 text-nowrap">
                                                            <span data-kt-element="grand-total">
                                                                <!-- The value will be populated from desplay_product() function-->
                                                            </span>
                                                            Tk
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                                <!--end::Table foot-->
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Wrapper-->

                                    <div class="d-flex justify-content-end">
                                        <!--begin::Button-->
                                        {{-- <a href="{{ route('order_management.order_invoices') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a> --}}
                                        <!--end::Button-->

                                        <!--begin::Button-->
                                        <button onclick="store()" type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Save Invoice</span>
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Container-->


        </div>
        <!--end::Post-->
    </div>
@endsection

@push('scripts')
    <script>
        function user() {
            let url = "{{ route('salePoint_by_territory_', ['id' => ':territory_id']) }}";

            let selectedUserOption = $('#user_id').find('option:selected');
            let territory_id = selectedUserOption.data('territory_id');

            let action = url.replace(':territory_id', territory_id);

            $('#sale_point_id').empty();

            if (territory_id !== '') {
                $.ajax({
                    url: action,
                    method: 'GET',
                    success: function (data) {
                        $('#sale_point_id').append('<option></option>');
                        $.each(data.sale_points, function (key, sale_point) {
                            $('#sale_point_id').append(
                                '<option value="' + sale_point.id + '">'
                                    + sale_point.name 
                                    + '</option>'
                            );
                        });
                    },
                    error: function (error) {
                        console.log('Error fetching products data:', error);
                    }
                });
            } 
        }

        function add_product() {
            var selectedUser = $('#user_id').val();
            if (!selectedUser) {
                toastr.error('Please select an employee.');
                return;
            }

            var selectedSalePoint = $('#sale_point_id').val();
            if (!selectedSalePoint) {
                toastr.error('Please select a sale point.');
                return;
            }

            var selectedStock = $('#stock_id').val();
            if (!selectedStock) {
                toastr.error('Please select a product.');
                return;
            }

            var selectedStockOption = $('#stock_id option:selected');
            var product_name = selectedStockOption.data('product_name');
            var sku = selectedStockOption.data('sku');
            var mrp = selectedStockOption.data('mrp');

            // console.log(product_name, sku, mrp);

            var quantity = $('#quantity').val();
            if (quantity == 0) {
                toastr.error('Please type quantity.');
                return;
            }

            let order_total_amount = quantity * mrp;

            var order = {
                stock_id: selectedStock,
                product_name: product_name,
                sku: sku,
                unit_price: mrp,
                quantity: quantity,
                order_total_amount: order_total_amount
            };

            var orders = JSON.parse(localStorage.getItem('orders')) || [];
            orders.push(order);
            localStorage.setItem('orders', JSON.stringify(orders));

            display_products();

            $("#stock_id").val('').trigger('change');
            $("#quantity").val('');
        }

        function display_products() {
            var orders = JSON.parse(localStorage.getItem('orders')) || [];
            
            $('#product_list').empty();
            var invoice_total_amount = 0;
            
            for (var index = 0; index < orders.length; index++) {
                var order = orders[index];                
                $('#product_list').append(
                    '<tr class="border-bottom border-bottom-dashed hover-row">'
                        + '<td class="pe-7">' + order.product_name + '</td>'
                        + '<td class="ps-7">' + order.quantity + '</td>'
                        + '<td class="ps-7">' + order.unit_price + '</td>'
                        + '<td class="text-end">' + order.order_total_amount.toFixed(2) + ' Tk' + '</td>'

                        + '<td class="pt-2 text-end">'
                            + '<button onclick="remove_product(' + index + ')" type="button" class="btn btn-sm btn-icon btn-active-color-primary">'
                                + '<span class="svg-icon svg-icon-3">'
                                    + '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'
                                        + '<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />'
                                        + '<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />'
                                        + '<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />'
                                    + '</svg>'
                                + '</span>'
                            + '</button>'
                        + '</td>'
                    +'</tr>'
                );
                
                invoice_total_amount += order.order_total_amount;
            }

            $('#invoice_footer [data-kt-element="grand-total"]').text(invoice_total_amount.toFixed(2));
        }

        function remove_product(index) {
            var orders = JSON.parse(localStorage.getItem('orders')) || [];
            orders.splice(index, 1);
            localStorage.setItem('orders', JSON.stringify(orders));
            
            display_products();
        }

        function store() {
            let selectedUserOption = $('#user_id').find('option:selected');
            let user_id = selectedUserOption.val();
            let territory_id = selectedUserOption.data('territory_id');

            var selectedSalePoint = $('#sale_point_id').val();

            var orders = JSON.parse(localStorage.getItem('orders')) || [];

            var invoice_total_amount = parseFloat($('#invoice_footer [data-kt-element="grand-total"]').text().replace('Tk ', ''));
            
            var order_invoice = {
                user_id: user_id,
                sale_point_id: selectedSalePoint,
                territory_id: territory_id,
                total_amount: invoice_total_amount,
                orders: [],
            };
            
            for (var index = 0; index < orders.length; index++) {
                var order = orders[index];
                
                var order_data = {
                    stock_id: order.stock_id,
                    product_name: order.product_name,
                    sku: order.sku,
                    quantity: order.quantity,
                    unit_price: order.unit_price,
                    total_amount: order.order_total_amount
                };

                order_invoice.orders.push(order_data);
            }
            
            $.ajax({
                url: "{{ route('order.store_invoice') }}",
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(order_invoice),
                success: function(response) {
                    localStorage.removeItem('orders');
                    
                    $('#product_list').empty();
                    $('#invoice_footer [data-kt-element="grand-total"]').text('0.00');
                    
                    toastr.success('Invoice submitted successfully');

                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
                error: function(error) {
                    toastr.error('Error submitting invoice');
                    console.error('Error submitting invoice', error);
                }
            });
            
            event.preventDefault();
        }

        $(document).ready(function() {
            display_products();
        });
    </script> 
@endpush