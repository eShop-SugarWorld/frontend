@extends('layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/home-page.css') }}">
@endsection

@section('title', 'Home page')

@section('main')
    <!-- Carousel -->
    <div class="car bd-example">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('/images/homePage/advertisement/90714-OIMX21-883 1.png') }}" class="d-block w-100"
                         alt="cat1">
                    <div class="carousel-caption">
                    <h5 class="fs-6 fs-md-4">Celebrate Love</h5>
                    <p class="fs-6 fs-md-5">Surprise someone special with sweet gifts and heartfelt treats this Valentine’s Day.</p>

                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/homePage/advertisement/90714-OIMX21-883 2.png') }}" class="d-block w-100"
                         alt="cat2">
                    <div class="carousel-caption">
                    <h5 class="fs-6 fs-md-4">Valentine’s Specials</h5>
                    <p class="fs-6 fs-md-5">Discover our limited edition products made with love — only for a short time.</p>

                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
        <img src="{{ asset('images/homePage/elements/Vector 1.png') }}" class="d-block w-100" style="height: 80px;" alt="cat1">
    </div>

    <!-- Most Popular Products -->
    <div class="container my-5 popularProductsMainDiv">
        <h2 class="text-center mb-4">Most Popular Products</h2>
        <div id="popularProductsCarousel" class="carousel slide">
            <div class="carousel-inner">
                @foreach($popularProducts->chunk(4) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach($chunk as $product)
                                <div class="col-6 col-sm-6 col-md-3 mb-4">
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
                                    @include('partials.product-card', [
                                    'product' => $product,
                                    'base64' => $base64,
                                    'mimeType' => $mimeType,
                                    'image' => $image?->path ?? null,
                                    'showPrice' => false
                                ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#popularProductsCarousel"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#popularProductsCarousel"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container mb-5 mt-5 p-4  bg-lightblue border rounded shadow">
    <div class="card border-0">
        <div class="row g-0 align-items-center">
            <div class="col-md-6">
                @php
                    $image = $randomProduct->images->first();
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
                @if($base64 ?? false)
                    <img src="data:{{ $mimeType }};base64,{{ $base64 }}" style="max-height: 300px;" class="img-fluid  product-image rounded" alt="{{ $randomProduct->name }}">
                @else
                    <img src="{{ $image?->path ?? asset('images/placeholder.jpg') }}" style="max-height: 300px;" class="img-fluid product-image  rounded" alt="{{ $randomProduct->name }}">
                @endif
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h3 class="card-title">{{ $randomProduct->name }}</h3>
                    <p class="card-text">{{ Str::limit($randomProduct->description, 150) }}</p>
                    <p class="card-text">{{ $randomProduct->price }} $</p>
                    <a href="{{ route('detail-of-product', $randomProduct->id) }}" class="btn btn-custom ">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- New Products -->
    <div class="container my-5 popularProductsMainDiv">
        <h2 class="text-center mb-4">New Products</h2>
        <div id="newProductsCarousel" class="carousel slide">
            <div class="carousel-inner">
                @foreach($newProducts->chunk(4) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach($chunk as $product)
                                <div class="col-6 col-sm-6 col-md-3 mb-4">
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
                                    @include('partials.product-card', [
                                    'product' => $product,
                                    'base64' => $base64,
                                    'mimeType' => $mimeType,
                                    'image' => $image?->path ?? null,
                                    'showPrice' => false
                                ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#newProductsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#newProductsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection