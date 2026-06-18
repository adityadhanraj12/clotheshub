@extends('layout.app')
@section('section') <x-page-header title="Order Details" />
    <x-customer-sidebar />
    <div class="col-lg-8 col-xl-9 pl-lg-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="basket">
            <div class="basket-holder">
                <div class="basket-header">
                    <div class="row">
                        <div class="col-6">Product</div>
                        <div class="col-2">Price</div>
                        <div class="col-2">Quantity</div>
                        <div class="col-2">Total</div>
                    </div>
                </div>
                <div class="basket-body">
                    @foreach($order->orderDetails as $item)
                        <div class="item">
                            <div class="row d-flex align-items-center">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($item->product->image_url ?? 'img/shirt.png') }}" class="img-fluid"
                                            width="80">
                                        <div class="title ml-3">
                                            <h6>{{ $item->product->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    ₹{{ number_format($item->product->base_price, 2) }}
                                </div>
                                <div class="col-2">
                                    {{ $item->quantity }}
                                </div>
                                <div class="col-2">
                                    ₹{{ number_format($item->product->base_price * $item->quantity, 2) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="block">
                    <div class="block-header">
                        <h6 class="text-uppercase">Order Information</h6>
                    </div>
                    <div class="block-body">
                        <p>
                            <strong>Order ID:</strong>
                            {{ $order->order_id }}
                        </p>
                        <p>
                            <strong>Order Date:</strong>
                            {{ $order->created_at->format('d M Y h:i A') }}
                        </p>
                        <p>
                            <strong>Payment Method:</strong>
                            {{ ucfirst($order->payment_method) }}
                        </p>
                        <p>
                            <strong>Delivery Method:</strong>
                            {{ $order->delivery_method }}
                        </p>
                        @php
                            $subtotal = 0;
                            foreach($order->orderDetails as $item) {
                                $subtotal += ($item->product->base_price ?? 0) * $item->quantity;
                            }
                            $shippingCost = $subtotal * 0.02;
                            $tax = $subtotal * 0.10;
                        @endphp
                        <p>
                            <strong>Order Subtotal:</strong>
                            ₹{{ number_format($subtotal, 2) }}
                        </p>
                        <p>
                            <strong>Shipping and handling (2%):</strong>
                            ₹{{ number_format($shippingCost, 2) }}
                        </p>
                        <p>
                            <strong>Tax (10%):</strong>
                            ₹{{ number_format($tax, 2) }}
                        </p>
                        <p>
                            <strong>Total Amount:</strong>
                            ₹{{ number_format($order->total_price, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 d-flex justify-content-center align-items-center flex-column flex-sm-row">
            @if($order->status === 'pending')
                <button type="button" class="btn btn-danger wide cancel-order-btn" data-toggle="modal" data-target="#cancelOrderModal" style="border-radius: 20px; padding: 10px 30px; font-weight: bold; margin-right: 15px; text-transform: uppercase; letter-spacing: 0.05em;">
                    Cancel Order
                </button>
            @endif
            <a href="{{ route('customerOrders') }}" class="btn btn-template-outlined wide prev back-orders-btn" style="border-radius: 20px; padding: 10px 30px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em;">
                <i class="fa fa-angle-left"></i>
                Back to Orders
            </a>
        </div>

        @if($order->status === 'pending')
            <!-- Cancel Order Confirmation Modal -->
            <div id="cancelOrderModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="background: rgba(0,0,0,0.6); z-index: 9999;">
              <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 550px;">
                <div class="modal-content" style="border-radius: 0; border: none; position: relative;">
                  <!-- Close button mimicking the overview close button -->
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 50px; height: 50px; text-align: center; line-height: 50px; background: #9055A2; color: #fff; position: absolute; top: 0; right: 0; opacity: 1; font-size: 1.25rem; border: none; cursor: pointer; outline: none; z-index: 999; display: flex; align-items: center; justify-content: center; padding: 0;">
                    <span>&times;</span>
                  </button>
                  
                  <div class="modal-body" style="padding: 50px 30px; text-align: center;">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 0.1em; font-weight: 700; color: #333;">Cancel Order</h4>
                    <p style="font-weight: 300; line-height: 1.7em; color: #777; font-size: 1.1em; margin-bottom: 30px;">
                      Are you sure you want to cancel this order?<br><strong>This action cannot be undone.</strong>
                    </p>
                    <div class="d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" style="border-radius: 20px; padding: 10px 30px; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.05em; margin-right: 10px;">Cancel</button>
                      <form action="{{ route('customerOrder.cancel', $order->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-template wide" style="border-radius: 20px; padding: 10px 30px; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.05em; background: #9055A2; border-color: #9055A2; color: #fff;">Cancel Order</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        @endif

        <style>
            .back-orders-btn {
                background-color: #007bff !important;
                border-color: #007bff !important;
                color: #fff !important;
            }

            .back-orders-btn:hover {
                background-color: #0069d9 !important;
                border-color: #0062cc !important;
                color: #fff !important;
            }

            .cancel-order-btn {
                background-color: #dc3545 !important;
                border-color: #dc3545 !important;
                color: #fff !important;
            }

            .cancel-order-btn:hover {
                background-color: #c82333 !important;
                border-color: #bd2130 !important;
                color: #fff !important;
            }
        </style>
    </div>
    </section>
@endsection