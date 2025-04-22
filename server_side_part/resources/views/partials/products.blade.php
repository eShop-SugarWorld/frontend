@foreach($products as $product)
    @php
        $image = $product->images->first();
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
    <div class="col">
        <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none">
            <div class="card h-100">
                @if($base64)
                    <img src="data:{{ $mimeType }};base64,{{ $base64 }}" class="card-img-top" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top" alt="No image available">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                    <p class="card-text data-price">{{ $product->price }} $</p>
                    <button class="btn btn-custom">Add to bag</button>
                </div>
            </div>
        </a>
    </div>
@endforeach
