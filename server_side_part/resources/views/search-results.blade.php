@extends('layouts.app')


@section('title', 'Search Results')
@section('additional-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('css/search-results.css') }}">
@endsection

@section('main')
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12 mb-4">
                    <div class="filters p-4 rounded">
                        <h3 class="mb-4">Filters</h3>
                        <div class="filter-section mb-4">
                            <h5>Rearrangement of products</h5>
                            <select class="form-select" aria-label="Sort products">
                                <option selected>Low price</option>
                                <option>High price</option>
                            </select>
                        </div>
                        <div class="filter-section mb-4">
                            <h5>Type of sweets</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="filter1-option1">
                                <label class="form-check-label" for="filter1-option1">Chocolate</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="filter1-option2">
                                <label class="form-check-label" for="filter1-option2">Marmalade</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="filter1-option3">
                                <label class="form-check-label" for="filter1-option3"> Biscuits</label>
                            </div>
                        </div>
    <!--                    <div class="filter-section mb-4">-->
    <!--                        <h5>Price</h5>-->
    <!--                        <input type="range" class="form-range" min="10" max="1000" value="500" id="priceRange">-->
    <!--                        <div class="d-flex justify-content-between">-->
    <!--                            <span>10$</span>-->
    <!--                            <span>1000$</span>-->
    <!--                        </div>-->
    <!--                    </div>-->
                        <div class="filter-section mb-4">
                            <h5>Price</h5>
                            <div id="priceRange" class="mb-2"></div>
                            <div class="d-flex justify-content-between">
                                <span id="minPrice">$0</span>
                                <span id="maxPrice">$150</span>
                            </div>
                        </div>
                        <div class="filter-section">
                            <h5>Celebration event</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="filter2-option1">
                                <label class="form-check-label" for="filter2-option1">Date</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="filter2-option2">
                                <label class="form-check-label" for="filter2-option2">Wedding</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="filter2-option3">
                                <label class="form-check-label" for="filter2-option3">Birthday party </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
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
                                            <button class="btn btn-custom">Add to bag</button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>



                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>


@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var slider = document.getElementById('priceRange');
            var minPrice = document.getElementById('minPrice');
            var maxPrice = document.getElementById('maxPrice');

            noUiSlider.create(slider, {
                start: [0, 150],
                connect: true,
                range: {
                    'min': 0,
                    'max': 150
                },
                step: 5,
                tooltips: false, // Disable tooltips
                margin: 10,
                format: {
                    to: function (value) {
                        return '$' + Math.round(value);
                    },
                    from: function (value) {
                        return Number(value.replace('$', ''));
                    }
                }
            });

            slider.noUiSlider.on('update', function (values, handle) {
                minPrice.textContent = values[0];
                maxPrice.textContent = values[1];

                // filterProducts(values[0].replace('$', ''), values[1].replace('$', ''));
            });

            // function filterProducts(minPrice, maxPrice) {
            //
            //     document.querySelectorAll('.card').forEach(function (card) {
            //         var price = parseFloat(card.getAttribute('data-price')); // Add data-price to your cards
            //         if (price >= minPrice && price <= maxPrice) {
            //             card.parentElement.style.display = 'block';
            //         } else {
            //             card.parentElement.style.display = 'none';
            //         }
            //     });
            // }
        });
    </script>
@endsection
