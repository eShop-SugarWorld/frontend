<div class="container my-5">
    <h2 class="text-center mb-4">Recommended Products</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @foreach($recommendedProducts as $recommendedProduct)
            @php
                $image = $recommendedProduct->images->first();
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
            @include('partials.product-card', [
                'product' => $recommendedProduct,
                'base64' => $base64,
                'mimeType' => $mimeType
            ])
        @endforeach
    </div>
</div>