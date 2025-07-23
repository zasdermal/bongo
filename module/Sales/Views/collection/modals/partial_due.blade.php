<div class="modal fade" id="kt_modal_update_permission" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder"></h2>
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
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            <!-- begin::Invoice 3-->
                            <div class="card">
                                <!-- begin::Body-->
                                <div class="card-body py-20">
                                    <!-- begin::Wrapper-->
                                    <div class="mw-lg-1000px mx-auto w-100">
                                        <div id="invoice-content">
                                            <!-- begin::Header-->
                                            <div class="d-flex justify-content-between flex-column flex-sm-row mb-10">
                                                <h4 class="fw-boldest text-gray-800 fs-2qx pe-5 pb-7">Invoice</h4>
                                                <!--end::Logo-->
                                                <div class="text-sm-end fs-4">
                                                    <!--begin::Message-->
                                                    <div id="greetings" class="fw-bolder fs-2">


                                                        <!--content from ajax-->


                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Header-->
            
                                            <!--begin::Body-->
                                            <div class="pb-12">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column gap-7 gap-md-5">
                                                    <!--begin::Separator-->
                                                    <div class="separator"></div>
                                                    <!--begin::Separator-->
            
                                                    <!--begin::Order details-->
                                                    <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bolder">
                                                        <div id="invoice_number" class="flex-root d-flex flex-column">
                                                            

                                                            <!--content from ajax-->


                                                        </div>
                                                        <div id="order_date" class="flex-root d-flex flex-column">
                                                            

                                                            <!--content from ajax-->


                                                        </div>
                                                        <div id="payment_type" class="flex-root d-flex flex-column">


                                                            <!--content form ajax-->


                                                        </div>
                                                        <div id="depot" class="flex-root d-flex flex-column">


                                                            <!--content from ajax-->


                                                        </div>
                                                    </div>
                                                    <!--end::Order details-->
            
                                                    <!--begin::Billing & shipping-->
                                                    <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bolder">
                                                        <div id="address" class="flex-root d-flex flex-column">


                                                            <!--content form ajax-->


                                                        </div>
                                                        <div id="order_and_delivery" class="flex-root d-flex flex-column">
                                                            

                                                            <!--content form ajax-->


                                                        </div>
                                                    </div>
                                                    <!--end::Billing & shipping-->
            
                                                    <!--begin:Order summary-->
                                                    <div class="d-flex justify-content-between flex-column">
                                                        <!--begin::Table-->
                                                        <div class="table-responsive border-bottom mb-9">
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                                <thead>
                                                                    <tr class="border-bottom fs-6 fw-bolder text-muted">
                                                                        <th class="min-w-50px pb-2">S.N</th>
                                                                        <th class="min-w-250px pb-2">Products</th>
                                                                        <th class="min-w-70px text-end pb-2">SKU</th>
                                                                        <th class="min-w-80px text-end pb-2">QTY</th>
                                                                        <th class="min-w-80px text-end pb-2">MRP</th>
                                                                        <th class="min-w-100px text-end pb-2">Total</th>
                                                                    </tr>
                                                                </thead>
            
                                                                <tbody id="order_details" class="fw-bold text-gray-600">
                                                                    

                                                                    <!--content form ajax-->

                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!--end::Table-->
                                                    </div>
                                                    <!--end:Order summary-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                    </div>
                                    <!-- end::Wrapper-->
                                </div>
                                <!-- end::Body-->
                            </div>
                            <!-- end::Invoice 1-->
                        </div>
                        <!--end::Container-->
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
    function collection(collection_id) {
        let url = "{{ route('collections_report.collection', ['id' => ':collection_id']) }}";
        let action = url.replace(':collection_id', collection_id);

        $.ajax({
            url: action,
            method: 'GET',
            success: function (data) {
                // greetings
                const greetings_div = `
                    Dear ${ data.collection.order_invoice.sales_point.name }
                    <span class="fs-6">(${ data.collection.order_invoice.sales_point.code_number })</span>,
                    <br />
                    <span class="text-muted fs-5">Here are your order details. We thank you for your purchase.</span>
                `;

                $('#greetings').html(greetings_div);

                // invoice number
                const invoice_number_div = `
                    <span class="text-muted">Invoice Number</span>
                    <span class="fs-7">#${ data.collection.order_invoice.invoice_number }</span>
                `;

                $('#invoice_number').html(invoice_number_div);

                // order date
                const created_at = data.collection.order_invoice.created_at;
                const order_date = new Date(created_at);
                
                const order_date_div = `
                    <span class="text-muted">Order Date</span>
                    <span class="fs-7">${ order_date.toDateString() }</span>
                `;

                $('#order_date').html(order_date_div);

                // payment type
                const payment_type_div = `
                    <span class="text-muted">Payment Type</span>
                    <span class="fs-7">${ data.collection.order_invoice.sales_point.payment_type }</span>
                `;

                $('#payment_type').html(payment_type_div);

                // depot
                const depot_div = `
                    <span class="text-muted">Depot</span>
                    <span class="fs-7">
                        ${ data.collection.order_invoice.sales_point.depot.name }
                    </span>
                `;

                $('#depot').html(depot_div);

                // address
                const address_div = `
                    <span class="text-muted">Billing Address</span>
                    <span class="fs-7">
                        ${ data.collection.order_invoice.sales_point.name } (${ data.collection.order_invoice.sales_point.code_number })
                        <br /> ${ data.collection.order_invoice.sales_point.address }
                        <br /> Phone: ${ data.collection.order_invoice.sales_point.contact_number }
                    </span>
                `;

                $('#address').html(address_div);

                // order and delivery
                const order_and_delivery_div = `
                    <span class="text-muted">Order By</span>
                    <span class="fs-7">
                        User ID: ${ data.collection.order_invoice.user.username }
                        <br /> Name: ${ data.collection.order_invoice.user.employee.name }
                    </span>

                    <span class="text-muted mt-2">Delivery By</span>
                    <span class="fs-7">
                        Delivery Man: ${ data.collection.order_invoice.delivery_man.employee.name }
                        <br />Phone: ${ data.collection.order_invoice.delivery_man.employee.contact }
                    </span>
                `;

                $('#order_and_delivery').html(order_and_delivery_div);

                // order list
                const orders = data.collection.order_invoice.orders;
                let tbody_content = '';
                
                orders.forEach((order, index) => {
                    tbody_content += `
                        <tr>
                            <td>${ index + 1 }</td>

                            <!--begin::Product-->
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0)" class="symbol">
                                        ${ order.product_name }
                                    </a>
                                </div>
                            </td>
                            <!--end::Product-->

                            <!--begin::SKU-->
                            <td class="text-end">${ order.sku }</td>
                            <!--end::SKU-->

                            <!--begin::Quantity-->
                            <td class="text-end">${ order.quantity }</td>
                            <!--end::Quantity-->

                            <!--begin::Trade Price-->
                            <td class="text-end">${ order.depot_stock_product.mrp }</td>
                            <!--end::Trade Price-->

                            <!--begin::Total-->
                            <td class="text-end">Tk ${ order.total_amount }</td>
                            <!--end::Total-->
                        </tr>
                    `;
                });

                tbody_content += `
                    <!--begin::Subtotal-->
                    <tr>
                        <td colspan="5" class="text-end">Subtotal</td>
                        <td class="text-end">Tk ${ data.collection.order_invoice.total_amount }</td>
                    </tr>
                    <!--end::Subtotal-->

                    <!--begin::Dis Amount-->
                    <tr>
                        <td colspan="5" class="text-end">Sell Dis Amount</td>
                        <td class="text-end">Tk ${ data.collection.order_invoice.sell_discount_amount }</td>
                    </tr>
                    <!--end::Dis Amount-->

                    <!--begin::Collected Amount-->
                    <tr>
                        <td colspan="5" class="text-end">Previous Payment</td>
                        <td class="text-end">Tk ${ data.collection.collected_amount }</td>
                    </tr>
                    <!--end::Collected Amount-->

                    <!--begin::Due-->
                    <tr>
                        <td colspan="5" class="text-end">Due</td>
                        <td class="text-end">Tk ${ data.collection.due }</td>
                    </tr>
                    <!--end::Due-->

                    <!--begin::Grand total-->
                    <tr>
                        <td colspan="5" class="fs-3 text-dark fw-bolder text-end">Net Payable</td>
                        <td class="text-dark fs-3 fw-boldest text-end">Tk ${ data.collection.due }</td>
                    </tr>
                    <!--end::Grand total-->

                    <!--begin::Collect Payment-->
                    <tr>
                        <td colspan="5" class="text-end">Collect Payment</td>
                        <td>
                            <input id="collected_payment" class="text-end form-control form-control-solid" type="text" value=".00">
                        </td>
                    </tr>
                    <!--end::Collect Payment-->
                `;

                // Setting the HTML content to a container element
                $('#order_details').html(tbody_content);
            },
            error: function (error) {
                console.error('Error fetching collection data:', error);
            }
        });

        // Form submission event handler
        $('#kt_modal_update_permission_form').submit(function(event) {
            let url = "{{ route('collections_report.collection_update', ['id' => ':collection_id']) }}";
            let action = url.replace(':collection_id', collection_id);
            // Prevent the default form submission
            event.preventDefault();

            // Get the collected payment value
            const collected_payment = $('#collected_payment').val();

            // Serialize the form data
            const form_data = $(this).serialize();

            // Append the collected payment value to the form data
            const form_data_with_payment = form_data + '&collected_payment=' + collected_payment;

            // Send the POST request
            $.ajax({
                url: action,
                method: 'POST',
                contentType: 'application/x-www-form-urlencoded',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data_with_payment,
                success: function(response) {
                    // Handle the response
                    console.log('data: ', response.collected_payment);
                    // window.location.href = "{{ route('collections_report.dues') }}";
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr);
                }
            });
        });
    }
</script>