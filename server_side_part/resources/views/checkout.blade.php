@extends('layouts.app')

@section('title', 'Checkout')
@section('additional-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('main')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-12 mb-4">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('order.place') }}" method="POST">
                @csrf
                <div class="checkout-section p-4 mb-4 rounded">
                    <h3 class="mb-4">1. Shipping</h3>
                    <div class="mb-3">
                        <label for="shippingMethod" class="form-label">Shipping Method</label>
                        <select class="form-select" id="shippingMethod" name="shipping_method">
                            <option value="standard" {{ $shippingMethod == 'standard' ? 'selected' : '' }}>Standard Shipping ($5.00)</option>
                            <option value="express" {{ $shippingMethod == 'express' ? 'selected' : '' }}>Express Shipping ($10.00)</option>
                            <option value="pickup" {{ $shippingMethod == 'pickup' ? 'selected' : '' }}>Pickup (Free)</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" value="{{ auth()->user()->info->first_name ?? '' }}" placeholder="Enter your first name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" value="{{ auth()->user()->info->last_name ?? '' }}" placeholder="Enter your last name" required>
                        </div>
                    </div>
                    <div class="mb-3 address-field">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Enter your country">
                    </div>
                    <div class="mb-3 address-field">
                        <label for="streetAddress" class="form-label">Street Address</label>
                        <input type="text" class="form-control" id="streetAddress" name="street_adr" placeholder="Enter your street address">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 address-field">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city">
                        </div>
                        <div class="col-md-6 mb-3 address-field">
                            <label for="region" class="form-label">Region</label>
                            <input type="text" class="form-control" id="region" name="region" placeholder="Enter your region">
                        </div>
                    </div>
                    <div class="mb-3 address-field">
                        <label for="postalCode" class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postalCode" name="postal_code" placeholder="Enter your postal code">
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phone" value="{{ auth()->user()->info->phone_number ?? '' }}" placeholder="Enter your phone number" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="checkout-section p-4 rounded">
                    <h3 class="mb-4">2. Payment Method</h3>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="detailCard" value="card">
                        <label class="form-check-label" for="detailCard">Card</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="whenReceiving" value="cash" checked>
                        <label class="form-check-label" for="whenReceiving">Cash</label>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Order</button>
                </div>
            </form>
        </div>

        <div class="col-lg-5 col-md-6 col-12">
            <div class="info-section p-4 rounded">
                <h3 class="mb-4">Information</h3>
                <div class="order-summary mb-4">
                    <h4 class="mb-3">Order Summary</h4>
                    @foreach($cartItems as $item)
                        @php
                            $image = $item->product->images->first();
                            $base64 = null;
                            $mimeType = "image/jpg";
                            if ($image && $image->image_data) {
                                $base64 = $image->image_data;
                                $imageData = base64_decode($base64);
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mimeType = finfo_buffer($finfo, $imageData);
                                finfo_close($finfo);
                            }
                        @endphp
                        <div class="order-item d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                @if($base64)
                                    <img src="data:{{ $mimeType }};base64,{{ $base64 }}" class="order-item-img me-3" alt="{{ $item->product->name }}">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" class="order-item-img me-3" alt="No image available">
                                @endif
                                <div>
                                    <p class="mb-0 item-name">{{ $item->product->name }}</p>
                                    <p class="mb-0 text-muted">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <p class="mb-0 item-price">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                        </div>
                    @endforeach
                    <div class="summary-details mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <p class="mb-0">Subtotal</p>
                            <p class="mb-0">${{ number_format($subtotal, 2) }}</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="mb-0">Shipping</p>
                            <p class="mb-0" id="shippingPrice">${{ number_format($shipping, 2) }}</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="mb-0">Tax</p>
                            <p class="mb-0">${{ number_format($tax, 2) }}</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p class="mb-0">Discount</p>
                            <p class="mb-0">$0.00</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Total</h5>
                            <h5 class="mb-0" id="totalPrice">${{ number_format($total, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    function updateSummary() {
        const shippingMethod = document.getElementById('shippingMethod').value;
        const shippingPrices = {
            'standard': 5.00,
            'express': 10.00,
            'pickup': 0.00
        };
        const shipping = shippingPrices[shippingMethod];
        const subtotal = {{ $subtotal }};
        const tax = {{ $tax }};
        const total = subtotal + tax + shipping;

        document.getElementById('shippingPrice').textContent = `$${shipping.toFixed(2)}`;
        document.getElementById('totalPrice').textContent = `$${total.toFixed(2)}`;
    }


    function toggleAddressFields() {
        const shippingMethod = document.getElementById('shippingMethod').value;
        const addressFields = document.querySelectorAll('.address-field input');
        
        if (shippingMethod === 'pickup') {
            addressFields.forEach(field => {
                field.disabled = true;
                field.value = '';
            });
        } else {
            addressFields.forEach(field => {
                field.disabled = false;
            });
        }
        updateSummary();
    }

    document.addEventListener('DOMContentLoaded', toggleAddressFields);


    document.getElementById('shippingMethod').addEventListener('change', toggleAddressFields);
</script>
@endsection