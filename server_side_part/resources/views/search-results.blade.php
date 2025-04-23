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
                        <form method="GET" id="filtersForm">
                            {{-- Сортування --}}
                            <div class="filter-section mb-4">
                                <h5>Rearrangement of products</h5>
                                <select class="form-select" aria-label="Sort products" id="sortPrice" name="sortPrice" onchange="this.form.submit()">
                                    <option value="asc" {{ request('sortPrice', 'asc') === 'asc' ? 'selected' : '' }}>Low price</option>
                                    <option value="desc" {{ request('sortPrice') === 'desc' ? 'selected' : '' }}>High price</option>
                                </select>
                            </div>

                            {{-- Фільтр по типу солодощів --}}
                            <div class="filter-section mb-4">
                                <h5>Type of sweets</h5>
                                @foreach (['Chocolate', 'Marmalade', 'Biscuits'] as $sweet)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $sweet }}" id="filter-{{ strtolower($sweet) }}"
                                               name="sweet_type[]"
                                               {{ in_array($sweet, request('sweet_type', [])) ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <label class="form-check-label" for="filter-{{ strtolower($sweet) }}">{{ $sweet }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="filter-section mb-4">
                                <h5>Celebration event</h5>
                                @foreach (['Date','Wedding','Birthday party'] as  $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $label }}" id="event-{{ strtolower($label) }}"
                                               name="event_type[]"
                                               {{ in_array($label, request('event_type', [])) ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <label class="form-check-label" for="event-{{ strtolower($label) }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="filter-section mb-4">
                                <h5>Price</h5>
                                <div id="priceRange" class="mb-2"></div>
                                <div class="d-flex justify-content-between">
                                    <span id="minPrice">$0</span>
                                    <span id="maxPrice">$150</span>
                                </div>
                                <input type="hidden" id="minPriceInput" name="minPrice" value="{{ request('minPrice', 0) }}">
                                <input type="hidden" id="maxPriceInput" name="maxPrice" value="{{ request('maxPrice', 150) }}">
                            </div>
                        </form>



                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @forelse($products as $product)
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
                        @include('partials.product-card', ['product' => $product, 'base64' => $base64, 'mimeType' => $mimeType])

                    @empty
                            <div class="text-center w-100">
                                <img src="{{ asset('images/product_not_find.jpeg') }}" alt="Not found" class="img-fluid" style="max-width: 400px; margin-top: 80px;border-radius: 15px; ">
                            </div>
                    @endforelse
                </div>

                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
{{--                    {{ $products->appends(request()->query())->links() }}--}}
                </div>


@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const priceSlider = document.getElementById('priceRange');
            const minPriceInput = document.getElementById('minPriceInput');
            const maxPriceInput = document.getElementById('maxPriceInput');
            const minPriceDisplay = document.getElementById('minPrice');
            const maxPriceDisplay = document.getElementById('maxPrice');

            const startMin = parseInt(minPriceInput.value) || 0;
            const startMax = parseInt(maxPriceInput.value) || 150;

            noUiSlider.create(priceSlider, {
                start: [startMin, startMax],
                connect: true,
                step: 1,
                range: {
                    'min': 0,
                    'max': 150
                }
            });

            priceSlider.noUiSlider.on('update', function (values, handle) {
                const min = Math.round(values[0]);
                const max = Math.round(values[1]);

                minPriceDisplay.textContent = `$${min}`;
                maxPriceDisplay.textContent = `$${max}`;

                minPriceInput.value = min;
                maxPriceInput.value = max;
            });

            priceSlider.noUiSlider.on('change', function () {
                document.getElementById('filtersForm').submit();
            });
        });
    </script>
@endsection
