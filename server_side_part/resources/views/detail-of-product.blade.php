@extends('layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/detail-of-product.css') }}">
@endsection

@section('title', 'Detail of product page')

@section('main')
<div class="container-fluid product-container">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-12 left-panel">
            <div class="content p-4">
                <h3 class="mb-4">Product Description</h3>
                <p>{{ $product->description ?? 'No description available.' }}</p>
            </div>
        </div>

        <div class="col-lg-6 col-md-4 col-12 center-panel">
            <div class="content p-4">
                @foreach($product->images as $image)
                    @php
                        $base64 = $image->image_data;
                        $imageData = base64_decode($base64);
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $imageData);
                        finfo_close($finfo);
                    @endphp
                    <img src="data:{{ $mimeType }};base64,{{ $base64 }}" class="img-fluid main-image mb-4" alt="Product Image">
                @endforeach
                @if($product->images->isEmpty())
                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid main-image mb-4" alt="No Image Available">
                @endif
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-12 right-panel">
            <div class="content p-4">
                <h3 class="mb-4">{{ $product->name}}</h3>
                @if (session('success'))
                    <div class="alert alert-success form-label" role="alert">
                        {{ session('success') }}
                        <a href="{{ route('cart') }}" class="btn btn-custom  ms-2">Go to Cart</a>
                    </div>
                @endif
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Count</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" step="1">
                    </div>
                    <button type="submit" class="btn btn-custom w-100 mb-3">Add to Cart</button>
                </form>
                

                <h5>Price: ${{ number_format($product->price, 2) }}</h5>
                <h5 class="mt-4">Ingredients</h5>
                <ul class="listOfIng">
                    @foreach($product->ingredients as $ingredient)
                        <li>{{ $ingredient->name }}</li>
                    @endforeach
                    @if($product->ingredients->isEmpty())
                        <li>No ingredients listed.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

@include('partials.recommended-products')
@endsection

@section('scripts')
<script>
    document.getElementById('quantity').addEventListener('input', function () {
        if (this.value === '') {
            return;
        }
        if (this.value <= 0) {
            this.value = 1;
        }
        this.value = Math.floor(this.value);
    });
</script>
@endsection