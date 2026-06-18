@extends('layout.app')
@section('section')
  <x-page-header title="Checkout" />

  <section class="checkout">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <ul class="nav nav-pills">
            <li class="nav-item"><a href="{{ route('checkout1') }}" class="nav-link active">Address</a></li>
            <li class="nav-item"><a href="#" class="nav-link disabled">Delivery Method </a></li>
            <li class="nav-item"><a href="#" class="nav-link disabled">Payment Method </a></li>
            <li class="nav-item"><a href="#" class="nav-link disabled">Order Review</a></li>
          </ul>
          <div class="tab-content">
            <div id="address" class="active tab-block">
              <form action="{{ route('checkout1.save') }}" method="POST">
                @csrf
                @php
                  $invoiceAddress = $addresses->where('address_type', 'invoice')->first();
                  $shippingAddress = $addresses->where('address_type', 'shipping')->first();

                  $states = [
                    "Andhra Pradesh",
                    "Arunachal Pradesh",
                    "Assam",
                    "Bihar",
                    "Chhattisgarh",
                    "Goa",
                    "Gujarat",
                    "Haryana",
                    "Himachal Pradesh",
                    "Jharkhand",
                    "Karnataka",
                    "Kerala",
                    "Madhya Pradesh",
                    "Maharashtra",
                    "Manipur",
                    "Meghalaya",
                    "Mizoram",
                    "Nagaland",
                    "Odisha",
                    "Punjab",
                    "Rajasthan",
                    "Sikkim",
                    "Tamil Nadu",
                    "Telangana",
                    "Tripura",
                    "Uttar Pradesh",
                    "Uttarakhand",
                    "West Bengal"
                  ];
                @endphp
                <!-- Invoice Address-->
                <div class="block-header mb-5">
                  <h6>Invoice address</h6>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>First Name</label>
                    <input name="first_name" value="{{ old('first_name', $invoiceAddress->first_name ?? '') }}"
                      class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label>Last Name</label>
                    <input name="last_name" value="{{ old('last_name', $invoiceAddress->last_name ?? '') }}"
                      class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label>Email Address</label>
                    <input name="email_address" value="{{ old('email_address', $invoiceAddress->email_address ?? '') }}"
                      class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label>Street</label>
                    <input name="street" value="{{ old('street', $invoiceAddress->street ?? '') }}" class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label>City</label>
                    <input name="city" value="{{ old('city', $invoiceAddress->city ?? '') }}" class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label>Postal Code</label>
                    <input name="postal_code" value="{{ old('postal_code', $invoiceAddress->postal_code ?? '') }}"
                      class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                    <label for="state">State</label>
                    <select id="state" name="state" class="form-control"
                      style="width: 350px; height: 40px; padding: 10px;">
                      <option value="">Select State</option>

                      @foreach ($states as $state)
                        <option value="{{ $state }}" {{ old('state', $invoiceAddress->state ?? '') == $state ? 'selected' : '' }}>
                          {{ $state }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label>Phone Number</label>
                    <input name="phone_number" value="{{ old('phone_number', $invoiceAddress->phone_number ?? '') }}"
                      class="form-control">
                  </div>

                  <!-- Shipping toggle -->
                  <div class="form-group col-12 mt-3 ml-3">
                    <input id="another-address" type="checkbox" name="different_shipping" value="1"
                      class="checkbox-template" {{ old('different_shipping', session('different_shipping', $shippingAddress ? 1 : 0)) ? 'checked' : '' }}>
                    <label for="another-address" data-toggle="collapse" data-target="#shippingAddress"> Use different
                      shipping address </label>
                  </div>
                </div>
                <!-- Shipping Address-->
                <div id="shippingAddress" class="collapse {{ old('different_shipping', session('different_shipping', $shippingAddress ? 1 : 0)) ? 'show' : '' }}">
                  <div class="block-header mb-5 mt-3">
                    <h6>Shipping address</h6>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>First Name</label>
                      <input name="shipping_first_name" class="form-control"
                        value="{{ old('shipping_first_name', $shippingAddress->first_name ?? '') }}">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Last Name</label>
                      <input name="shipping_last_name" class="form-control"
                        value="{{ old('shipping_last_name', $shippingAddress->last_name ?? '') }}">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Email</label>
                      <input name="shipping_email" class="form-control"
                        value="{{ old('shipping_email', $shippingAddress->email_address ?? '') }}">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Street</label>
                      <input name="shipping_address" class="form-control"
                        value="{{ old('shipping_address', $shippingAddress->street ?? '') }}">
                    </div>

                    <div class="form-group col-md-6">
                      <label>City</label>
                      <input name="shipping_city" class="form-control"
                        value="{{ old('shipping_city', $shippingAddress->city ?? '') }}">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Postal Code</label>
                      <input name="shipping_zip" class="form-control"
                        value="{{ old('shipping_zip', $shippingAddress->postal_code ?? '') }}">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="shipping_state">State</label>
                      <select id="shipping_state" name="shipping_state" class="form-control"
                        style="width: 350px; height: 40px; padding: 10px;">
                        <option value="">Select State</option>

                        @foreach ($states as $state)
                          <option value="{{ $state }}" {{ old('shipping_state', $shippingAddress->state ?? '') == $state ? 'selected' : '' }}>
                            {{ $state }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Phone Number</label>
                      <input name="shipping_phone_number" class="form-control"
                        value="{{ old('shipping_phone_number', $shippingAddress->phone_number ?? '') }}">
                    </div>

                  </div>
                </div>
                @if ($errors->any())
                  <div class="alert alert-danger">
                    {{ $errors->first() }}
                  </div>
                @endif

                <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
                  <a href="{{ route('cart') }}" class="btn btn-template-outlined wide prev"><i
                      class="fa fa-angle-left"></i>Back to basket</a>
                  <button type="submit" class="btn btn-template wide next">Choose delivery method<i
                      class="fa fa-angle-right"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <x-order-summary :carts="$carts" />
      </div>
    </div>
  </section>

@endsection