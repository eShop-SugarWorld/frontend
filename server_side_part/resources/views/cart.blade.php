@extends('layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('title', 'Cart page')

@section('main')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 col-md-7 col-12 mb-4">
            <div class="cart-items p-4 rounded">
                <h2 class="mb-4">Your Bag</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (count($cartItems) > 0)
                    <div class="cart-items-list">
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
                            <div class="cart-item d-flex align-items-center mb-3 p-3 rounded">
                                @if($base64)
                                    <img src="data:{{ $mimeType }};base64,{{ $base64 }}" class="cart-item-img me-3" alt="{{ $item->product->name }}">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" class="cart-item-img me-3" alt="No image available">
                                @endif
                                <div class="cart-item-details flex-grow-1">
                                    <p class="mb-1">{{ $item->product->name }}</p>
                                    <p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit($item->product->description, 50) }}</p>
                                    <a href="{{ route('cart.remove', $item->product->id) }}" class="text-danger small">Remove</a>
                                </div>
                                <div class="cart-item-price me-3">
                                    <p class="mb-0">${{ number_format($item->product->price, 2) }}</p>
                                </div>
                                <form action="{{ route('cart.update', $item->product->id) }}" method="POST" class="cart-item-quantity d-flex align-items-center">
                                    @csrf
                                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="btn btn-sm btn-custom-quantity me-2">-</button>
                                    <span>{{ $item->quantity }}</span>
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="btn btn-sm btn-custom-quantity ms-2">+</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Your cart is empty.</p>
                @endif
            </div>
        </div>

        <div class="col-lg-4 col-md-5 col-12">
            <div class="cart-info p-4 rounded">
                <h3 class="mb-4">Order Summary</h3>
                <div class="mb-3">
                    <p class="d-flex justify-content-between"><span>Subtotal:</span> <span>${{ number_format($subtotal, 2) }}</span></p>
                    <p class="d-flex justify-content-between"><span>Shipping:</span> <span>${{ number_format($shipping, 2) }}</span></p>
                    <p class="d-flex justify-content-between"><span>Tax:</span> <span>${{ number_format($tax, 2) }}</span></p>
                </div>
                <div class="mb-3">
                    <label for="promoCode" class="form-label">Promo Code</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="promoCode" placeholder="Enter promo code">
                        <button class="btn btn-custom" type="button">Apply</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="shippingMethod" class="form-label">Shipping Method</label>
                    <select class="form-select" id="shippingMethod">
                        <option value="5.00" selected>Standard Shipping ($5.00)</option>
                        <option value="10.00">Express Shipping ($10.00)</option>
                        <option value="0.00">Pickup (Free)</option>
                    </select>
                </div>
                <p class="d-flex justify-content-between fw-bold"><span>Total:</span> <span id="totalPrice">${{ number_format($total, 2) }}</span></p>
                <a href="{{ route('checkout') }}" class="btn btn-custom w-100">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
    // Оновлення загальної суми при зміні методу доставки
    document.getElementById('shippingMethod').addEventListener('change', function () {
        const subtotal = {{ $subtotal }};
        const tax = {{ $tax }};
        const shipping = parseFloat(this.value);
        const total = subtotal + tax + shipping;
        document.getElementById('totalPrice').textContent = `$${total.toFixed(2)}`;
    });
</script>
@endsection