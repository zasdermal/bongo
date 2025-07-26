<style>
    /* Remove spinner arrows for inputs with class no-spinner */
    .no-spinner::-webkit-outer-spin-button,
    .no-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .no-spinner {
        -moz-appearance: textfield; /* Firefox */
    }
</style>

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
                                            {{-- <div class="d-flex justify-content-between flex-column flex-sm-row mb-10">
                                                <h4 class="fw-boldest text-gray-800 fs-2qx pe-5 pb-7">Invoice</h4>
                                                <!--end::Logo-->
                                                <div class="text-sm-end fs-4">
                                                    <!--begin::Message-->
                                                    <div id="greetings" class="fw-bolder fs-2">


                                                        <!--content from ajax-->


                                                    </div>
                                                </div>
                                            </div> --}}
                                            <!--end::Header-->
            
                                            <!--begin::Body-->
                                            <div class="pb-12">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column gap-7 gap-md-5">
                                                    <!--begin::Separator-->
                                                    {{-- <div class="separator"></div> --}}
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
                                                                        <th class="min-w-20px">S.N</th>
                                                                        <th class="min-w-250px">Products</th>
                                                                        <th class="min-w-50px text-end">SKU</th>
                                                                        <th class="min-w-70px text-end">QTY</th>
                                                                        <th class="min-w-70px text-end">Return Qty</th>
                                                                        <th class="min-w-70px text-end">Unit Price</th>
                                                                        <th class="min-w-70px text-end">Total</th>
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
                    <div class="text-center">
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

<div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border border-warning">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light-warning">
                <p>Collected payment cannot exceed the net payable amount.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function collection(id) {
        let url = "{{ route('collection.due', ['id' => ':id']) }}";
        let action = url.replace(':id', id);

        $.ajax({
            url: action,
            method: 'GET',
            success: function (data) {
                console.log(data);
                
                // greetings
                // const greetings_div = `
                //     Dear ${ data.collection.order_invoice.sales_point.name }
                //     <span class="fs-6">(${ data.collection.order_invoice.sales_point.code_number })</span>,
                //     <br />
                //     <span class="text-muted fs-5">Here are your order details. We thank you for your purchase.</span>
                // `;

                // $('#greetings').html(greetings_div);

                // invoice number
                const invoice_number_div = `
                    <span class="text-muted">Invoice Number</span>
                    <span class="fs-7">${ data.collection.order_invoice.invoice_number }</span>
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
                // const payment_type_div = `
                //     <span class="text-muted">Payment Type</span>
                //     <span class="fs-7">${ data.collection.order_invoice.sales_point.payment_type }</span>
                // `;

                // $('#payment_type').html(payment_type_div);

                // depot
                // const depot_div = `
                //     <span class="text-muted">Depot</span>
                //     <span class="fs-7">
                //         ${ data.collection.order_invoice.depot.name }
                //     </span>
                // `;

                // $('#depot').html(depot_div);

                // address
                const address_div = `
                    <span class="text-muted">Billing Address</span>
                    <span class="fs-7">
                        ${ data.collection.order_invoice.sale_point.name } (${ data.collection.order_invoice.sale_point.code_number })
                        <br /> ${ data.collection.order_invoice.sale_point.address }
                        <br /> Phone: ${ data.collection.order_invoice.sale_point.contact_number }
                    </span>
                `;

                $('#address').html(address_div);

                // order and delivery
                const order_and_delivery_div = `
                    <span class="text-muted">Order By</span>
                    <span class="fs-7">
                        User ID: ${ data.collection.order_invoice.user.username }
                        <br /> Name: ${ data.collection.order_invoice.user.name }
                    </span>

                    
                `;

                $('#order_and_delivery').html(order_and_delivery_div);

                // order list
                const orders = data.collection.order_invoice.orders;
                let tbody_content = '';
                
                orders.forEach((order, index) => {
                    var total_order_amount = order.unit_price * (order.quantity + order.return_qty);
                    tbody_content += `
                        <tr>
                            <td>${ index + 1 }</td>

                            <!--begin::Product-->
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0)" class="symbol" title="${ order.product_name }"
                                        style="max-width: 180px; display: inline-block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"
                                    >
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

                            <!--begin::Return Qty-->
                            <td class="text-end">${ order.return_qty ?? 0 }</td>
                            <!--end::Return Qty-->

                            <!--begin::Unit Price-->
                            <td class="text-end">${ order.unit_price }</td>
                            <!--end::Unit Price-->

                            <!--begin::Total-->
                            <td class="text-end">${ total_order_amount.toFixed(2) }</td>
                            <!--end::Total-->
                        </tr>
                    `;
                });

                tbody_content += `
                    <!--begin::Subtotal-->
                    <tr>
                        <td colspan="6" class="text-end">Subtotal</td>
                        <td class="text-end">${ data.collection.order_invoice.total_amount }</td>
                    </tr>
                    <!--end::Subtotal-->

                    <!--begin::Return Amount-->
                    <tr>
                        <td colspan="6" class="text-end">Return Amount</td>
                        <td class="text-end">${ data.total_return_amount ?? '0.00' }</td>
                    </tr>
                    <!--end::Return Amount-->

                    <!--begin::Dis Amount-->
                    <tr>
                        <td colspan="6" class="text-end">Sell Dis Amount</td>
                        <td class="text-end">${ data.collection.order_invoice.sell_discount_amount ?? '0' }</td>
                    </tr>
                    <!--end::Dis Amount-->

                    <!--begin::Previous Addi Dis-->
                    <tr>
                        <td colspan="6" class="text-end">Previous Addi Dis</td>
                        <td class="text-end">${ data.total_addi_dis_amount ?? '0.00' }</td>
                    </tr>
                    <!--end::Previous Addi Dis-->

                    <!--begin::Previous Payment-->
                    <tr>
                        <td colspan="6" class="text-end">Previous Payment</td>
                        <td class="text-end">${ data.total_partial_paid ?? '0.00' }</td>
                    </tr>
                    <!--end::Previous Payment-->

                    <!--begin::Net Payable-->
                    <tr>
                        <td colspan="6" class="fs-3 text-dark fw-bolder text-end">Net Payable</td>
                        <td class="text-dark fs-3 fw-boldest fw-bolder text-end">${ data.collection.due }</td>
                        <input id="net_payable" type="hidden" value="${ data.collection.due }">
                    </tr>
                    <!--end::Net Payable-->

                    <!--begin::AIT-->
                    <tr>
                        <td colspan="6" class="text-end">Set AIT</td>
                        <td>
                            <input id="ait" class="no-spinner text-end form-control form-control-solid" type="number" placeholder="0.00" autocomplete="off">
                        </td>
                    </tr>
                    <!--end::AIT-->

                    <!--begin::Additional Discount-->
                    <tr>
                        <td colspan="6" class="text-end">Set Additional Discount</td>
                        <td>
                            <input id="additional_discount" class="no-spinner text-end form-control form-control-solid" type="number" placeholder="0.00" autocomplete="off">
                        </td>
                    </tr>
                    <!--end::Additional Discount-->

                    <!--begin::Payment-->
                    <tr>
                        <td colspan="6" class="text-end">Make Payment</td>
                        <td>
                            <input 
                                id="collected_payment" 
                                class="no-spinner text-end form-control form-control-solid" 
                                type="number"
                                placeholder="0.00"
                                autocomplete="off"
                                min="1"
                                max="${ data.collection.collection_amount }"
                            >
                        </td>
                    </tr>
                    <!--end::Payment-->
                `;

                // Setting the HTML content to a container element
                $('#order_details').html(tbody_content);
            },
            error: function (error) {
                console.error('Error fetching collection data:', error);
            }
        });

        $('#kt_modal_update_permission_form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            const net_payable = parseFloat($('#net_payable').val());
            const ait = parseFloat($('#ait').val()) || null;
            const additional_discount = parseFloat($('#additional_discount').val()) || null;
            const collected_payment = parseFloat($('#collected_payment').val()) || null;
            var total_payment = collected_payment + additional_discount + ait;

            if (total_payment > net_payable) {
                // Update the modal message dynamically
                $('#warningModal .modal-body').html(
                    `<p>Collected payment (${total_payment.toFixed(2)}) cannot exceed the net payable amount (${net_payable.toFixed(2)}).</p>`
                );
                // Show the warning modal
                $('#warningModal').modal('show');
                return;
            }

            // Check if all three values are 0
            if (ait === null && additional_discount === null && collected_payment === null) {
                $('#warningModal .modal-body').html(
                    `<p>Please enter at least one amount (AIT, Additional Discount, or Collected Payment).</p>`
                );
                $('#warningModal').modal('show');
                return;
            }

            // console.log(collected_payment);
            
            submitForm(collected_payment, additional_discount, ait); // Call the submit function
        });

        function submitForm(collected_payment, additional_discount, ait) {
            let url = "{{ route('collection.update_due', ['id' => ':id']) }}";
            let action = url.replace(':id', id);

            // Disable submit button to prevent double submissions
            const $submitBtn = $('#kt_modal_update_permission_form').find('button[type="submit"]');
            $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Please wait...');

            const form_data = $('#kt_modal_update_permission_form').serialize();
            const extra_data = {
                collected_payment: collected_payment,
                additional_discount: additional_discount,
                ait: ait
            };
            const merged_data = { ...form_data, ...extra_data };

            $.ajax({
                url: action,
                method: 'POST',
                contentType: 'application/x-www-form-urlencoded',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: merged_data,
                success: function(response) {
                    // console.log(response);
                    
                    window.location.href = "{{ route('collection.dues') }}";
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        // function validateAmount(input, maxAmount) {
        //     if (parseFloat(input.value) > maxAmount) {
        //         input.value = maxAmount;
        //     }
        // }

        // function validateAmount(input, maxAmount) {
        //     // Remove any character that's not a digit or decimal point
        //     input.value = input.value.replace(/[^\d.]/g, '');

        //     // Prevent multiple decimal points
        //     if ((input.value.match(/\./g) || []).length > 1) {
        //         input.value = input.value.substring(0, input.value.length - 1);
        //         return;
        //     }

        //     // Convert to float and validate max
        //     const numericValue = parseFloat(input.value);
        //     if (!isNaN(numericValue) && numericValue > maxAmount) {
        //         input.value = maxAmount;
        //     }
        // }
    }
</script>

{{-- <input 
    id="collected_payment" 
    class="text-end form-control form-control-solid" 
    type="text"
    min="1"
    max="${ data.collection.collection_amount }" 
    value=".00"
    oninput="validateAmount(this, ${ data.collection.collection_amount })"
> --}}
{{-- <td class="text-end">Tk ${ data.collection.order_invoice.status === 'Partial Return' ? total_order_amount.toFixed(2) : order.total_amount }</td> --}}
{{-- ${ data.collection.order_invoice.sales_point.sell_discount_type === 'TP' ? order.depot_stock_product.trade_price : order.depot_stock_product.mrp } --}}
{{-- <td class="text-end">${ data.collection.order_invoice.status === 'Partial Return' ? order.quantity + order.return_qty : order.quantity }</td> --}}

{{-- <span class="text-muted mt-2">Delivery By</span>
                    <span class="fs-7">
                        Delivery Man: ${ data.collection.order_invoice.delivery_man?.employee.name ?? '' }
                        <br />Phone: ${ data.collection.order_invoice.delivery_man?.employee.contact ?? '' }
                    </span> --}}