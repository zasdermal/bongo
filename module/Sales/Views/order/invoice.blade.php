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
                <!-- begin::Invoice 3-->
                <div class="card">
                    <!-- begin::Body-->
                    <div class="card-body py-20">
                        <!-- begin::Wrapper-->
                        <div class="mw-lg-950px mx-auto w-100">
                            <div id="invoice-content">
                                <!-- begin::Header-->
                                <div class="d-flex justify-content-between flex-column flex-sm-row mb-10">
                                    @if ($orderInvoice->status !== 'Requested')
                                        <h4 class="fw-boldest text-gray-800 fs-2qx pe-5 pb-7">Invoice</h4>
                                    @else
                                        <h4 class="text-gray-800 fs-2 pe-5 pb-7">Update Order Quantity</h4>
                                    @endif

                                    {{-- <div class="text-sm-end fs-4">
                                        <!--begin::Message-->
                                        <div class="fw-bolder fs-2">
                                            Dear {{ $order_invoice->sales_point->name }}
                                            <span class="fs-6">({{ $order_invoice->sales_point->code_number }})</span>,
                                            <br />
                                            <span class="text-muted fs-5">Here are your order details. We thank you for your purchase.</span>
                                        </div>
                                    </div> --}}
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="pb-12">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column gap-7 gap-md-10">
                                        <!--begin::Separator-->
                                        <div class="separator"></div>
                                        <!--begin::Separator-->

                                        <!--begin::Order details-->
                                        <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bolder">
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Invoice Number</span>
                                                @if ($orderInvoice->status !== 'Requested')
                                                    <span class="fs-5">{{ $orderInvoice->invoice_number }}</span>
                                                @endif
                                            </div>
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Order Date</span>
                                                <span class="fs-5">{{ $orderInvoice->created_at->format('d M, Y / h:i A') }}</span>
                                            </div>
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Payment Type</span>
                                                {{-- <span class="fs-5">{{ $orderInvoice->sales_point->payment_type }}</span> --}}
                                            </div>
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Depot</span>
                                                <span class="fs-5">
                                                    {{-- {{ $order_invoice->depot->name }} --}}
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::Order details-->

                                        <!--begin::Billing & shipping-->
                                        <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bolder">
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Billing Address</span>
                                                <span class="fs-6">
                                                    {{ $orderInvoice->salePoint->name }} ({{ $orderInvoice->salePoint->code_number }})
                                                    @foreach (explode(',', $orderInvoice->salePoint->address) as $part)
                                                        <br />{{ trim($part) }},
                                                    @endforeach
                                                    <br />Phone: {{ $orderInvoice->salePoint->contact_number }}
                                                </span>
                                            </div>
                                            <div class="flex-root d-flex flex-column">
                                                <span class="text-muted">Order By</span>
                                                <span class="fs-6">
                                                    User ID: {{ $orderInvoice->user->username }}
                                                    <br />Name: {{ $orderInvoice->user->employee->name }}
                                                </span>

                                                {{-- @if ($orderInvoice->delivery_man) --}}
                                                    <span class="text-muted mt-2">Delivery By</span>
                                                    <span class="fs-6">
                                                        {{-- Delivery Man: {{ $order_invoice->delivery_man->employee->name }} --}}
                                                        {{-- <br />Phone: {{ $order_invoice->delivery_man->employee->contact }} --}}
                                                    </span>
                                                {{-- @endif --}}
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
                                                            <th class="min-w-100px pb-2">Products</th>
                                                            <th class="min-w-70px pb-2">SKU</th>
                                                            <th class="min-w-80px pb-2">QTY</th>
                                                            <th class="min-w-80px text-end pb-2">Unit Price</th>
                                                            <th class="min-w-100px text-end pb-2">Total</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="fw-bold text-black-600">
                                                        <!--begin::Products-->
                                                        @foreach ($orderInvoice->orders as $key => $order)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>

                                                                <!--begin::Product-->
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <a class="symbol symbol-50px">
                                                                            <div class="fw-bolder">{{ $order->product_name }}</div>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <!--end::Product-->

                                                                <!--begin::SKU-->
                                                                <td>{{ $order->sku }}</td>
                                                                <!--end::SKU-->

                                                                <!--begin::Quantity-->
                                                                {{-- <td class="text-end">{{ $order->quantity }}</td> --}}

                                                                <td>
                                                                    <span class="quantity-display" onclick="showInputField(this)">{{ $order->quantity }}</span>
                                                                    @if ($orderInvoice->status !== 'Accepted')
                                                                        <input 
                                                                            type="number" 
                                                                            class="quantity-input d-none" 
                                                                            value="{{ $order->quantity }}" 
                                                                            data-order-id="{{ $order->id }}" 
                                                                            min="1" 
                                                                            style="width: 70px; text-align: left;"
                                                                        />
                                                                    @endif
                                                                </td>
                                                                <!--end::Quantity-->

                                                                <!--begin::Price-->
                                                                <td class="text-end">{{ $order->unit_price }}</td>
                                                                <!--end::Price-->

                                                                <!--begin::Total-->
                                                                <td class="text-end">
                                                                    Tk {{ $order->total_amount }}
                                                                </td>
                                                                <!--end::Total-->
                                                            </tr>
                                                        @endforeach
                                                        <!--end::Products-->

                                                        <!--begin::Subtotal-->
                                                        <tr>
                                                            <td colspan="5" class="text-end">Subtotal</td>
                                                            <td class="text-end">Tk {{ $orderInvoice->total_amount }}</td>
                                                        </tr>
                                                        <!--end::Subtotal-->

                                                        <!--begin::Dis Amount-->
                                                        {{-- @if ($order_invoice->sell_discount_amount) --}}
                                                            <tr>
                                                                <td colspan="5" class="text-end">Sell Dis Amount</td>
                                                                {{-- <td class="text-end">Tk {{ $order_invoice->sell_discount_amount }}</td> --}}
                                                            </tr>
                                                        {{-- @endif --}}
                                                        <!--end::Dis Amount-->

                                                        <!--begin::Grand total-->
                                                        <tr>
                                                            <td colspan="5" class="fs-3 text-dark fw-bolder text-end">Grand Total</td>
                                                            @php
                                                                $grand_total = $orderInvoice->total_amount
                                                            @endphp
                                                            <td class="text-dark fs-3 fw-boldest text-end">Tk {{ number_format($grand_total, 2) }}</td>
                                                        </tr>
                                                        <!--end::Grand total-->
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

                            <!-- begin::Footer-->
                            <!-- begin::Grand Total in Words -->
                            <div class="mt-2">
                                {{-- <span class="fs-6">
                                    <i>In Words: {{ $grand_total_in_words }}</i> --}}
                                    <h6 class="text-black-400">In Words: {{ $grand_total_in_words }}</h6>
                                {{-- </span> --}}
                            </div>
                            <!-- end::Grand Total in Words -->

                            <!-- begin::Signatures-->
                            @if ($orderInvoice->status !== 'Requested')
                                <div class="d-flex justify-content-between mt-20 pt-5">
                                    <div class="text-center">
                                        <div class="border-top border-dark w-150px mx-auto"></div>
                                        <span class="fw-bold">Customer Signature</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="border-top border-dark w-150px mx-auto"></div>
                                        <span class="fw-bold">Authorized Signature</span>
                                    </div>
                                </div>
                            @endif
                            <!-- end::Signatures-->

                            <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                                <!-- begin::Action-->
                                @if ($orderInvoice->status !== 'Requested')
                                    <button type="button" class="btn btn-success my-1 me-12" onclick="window.print();">Print Invoice</button>
                                @endif
                                <!-- end::Action-->

                                <!-- begin::Actions-->
                                @if ($orderInvoice->status !== 'Accepted')
                                    <div class="my-1 me-5">
                                        <button type="button" class="btn btn-primary my-1">Accept</button>
                                    </div>
                                @endif
                                <!-- end::Actions-->
                            </div>
                            <!-- end::Footer-->
                        </div>
                        <!-- end::Wrapper-->
                    </div>
                    <!-- end::Body-->
                </div>
                <!-- end::Invoice 1-->

                <!--begin::Modals-->
                <div class="modal fade" id="quantity_update_confirmation" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Quantity Update Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to update quantity?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success quantity_update">Update</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Modal -->
                <div class="modal fade" id="stockErrorModal" tabindex="-1" aria-labelledby="stockErrorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="stockErrorModalLabel">Stock Error</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body text-danger" id="stockErrorMessage">
                                <!-- Error message will be inserted here -->
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection

@push('scripts')
    <script>
        // Show the input field when clicking on the quantity
        function showInputField(element) {
            const $quantityDisplay = $(element);
            const $quantityInput = $quantityDisplay.siblings('.quantity-input');
    
            // Hide the display and show the input field
            $quantityDisplay.addClass('d-none');
            $quantityInput.removeClass('d-none').focus();
        }
    
        // Handle the blur event to save the quantity and revert to display
        $(document).on('blur', '.quantity-input', function() {
            const $quantityInput = $(this);
            const $quantityDisplay = $quantityInput.siblings('.quantity-display');
            const newQuantity = $quantityInput.val();
            const orderId = $quantityInput.data('order-id');
            
            const oldQuantity = $quantityDisplay.text().trim(); // Get the old quantity from the display
    
            // Only send the request if the quantity has changed
            if (newQuantity !== oldQuantity) {
                let url = "{{ route('order.update_order', ['id' => ':id']) }}";
                let action = url.replace(':id', orderId);
                // Optionally, send the new quantity to the server

                $('#quantity_update_confirmation').modal('show');

                $('.quantity_update').on('click', function () {
                    $.ajax({
                        url: action,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            quantity: newQuantity
                        },
                        success: function(data) {
                            toastr.success(data.message);

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 || xhr.status === 404 || xhr.status === 500) {
                                const errorMessage = xhr.responseJSON?.error || 'An unknown error occurred';

                                // Set and show the stock error modal
                                $('#stockErrorMessage').text(errorMessage);
                                $('#stockErrorModal').modal('show');
                                // alert(errorMessage);
                            } else {
                                console.error('Unexpected error:', xhr);
                            }
                        }
                    });
                }); 
            }
    
            // Revert to display mode
            $quantityDisplay.removeClass('d-none');
            $quantityInput.addClass('d-none');
        });

        function update_order_invoice_and_stock(action) {
            $.ajax({
                url: action,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Order invoice shipped successfully');
                    window.location.href = "{{ route('order.invoices') }}";
                },
                error: function(xhr) {
                    // console.error('Failed to shipped order invoice', xhr);

                    // Check for validation or custom error
                    if (xhr.status === 400 || xhr.status === 404) {
                        const errorMessage = xhr.responseJSON?.error || 'An unknown error occurred';

                        // Set and show the stock error modal
                        $('#stockErrorMessage').text(errorMessage);
                        $('#stockErrorModal').modal('show');
                    } else {
                        console.error('Unexpected error:', xhr);
                    }
                }
            });
        }
    </script>
@endpush