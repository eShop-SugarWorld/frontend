<div class="col">
    <a href="{{ route('detail-of-product', $product->id) }}" class="text-decoration-none">
        <div class="card h-100">
            @if($base64 ?? false)
                <img src="data:{{ $mimeType }};base64,{{ $base64 }}" class="card-img-top" alt="{{ $product->name }}">
            @else
                <img src="{{ $image ?? asset('images/placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name ?? 'No image available' }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                @if(!isset($showPrice) || $showPrice)
                    <p class="card-text data-price">{{ $product->price }} $</p>
                @endif
                <button class="btn btn-custom">Add to cart</button>
            </div>
        </div>
    </a>
</div>