@extends('layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/home-page.css') }}">
@endsection

@section('title', 'Home page')


@section('main')
    <!-- <a href="http://www.freepik.com">Designed by Freepik</a> -->
    <div class="car bd-example">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('/images/homePage/advertisement/90714-OIMX21-883 1.png')}}" class="d-block w-100"
                         alt="cat1">
                    <div class="carousel-caption">
                        <h5 class="fs-6 fs-md-4">First slide label</h5>
                        <p class="fs-6 fs-md-5">Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/homePage/advertisement/90714-OIMX21-883 2.png') }}" class="d-block w-100"
                         alt="cat2">
                    <div class="carousel-caption">
                        <h5 class="fs-6 fs-md-4">Second slide label</h5>
                        <p class="fs-6 fs-md-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
        <img src="../images/homePage/elements/Vector 1.png" class="d-block w-100" style="height: 80px;" alt="cat1">
    </div>

    <!-- Most Popular Products -->
    <!-- Image by <a href="https://pixabay.com/users/jillwellington-334088/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=7107147">Jill Wellington</a> from <a href="https://pixabay.com//?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=7107147">Pixabay</a> -->
    <!-- Image by <a href="https://pixabay.com/users/fitspau-10933455/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=3865695">Pauline Bernard</a> from <a href="https://pixabay.com//?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=3865695">Pixabay</a> -->
    <!-- Image by <a href="https://pixabay.com/users/ylanite-2218222/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=8394894">Ylanite Koppens</a> from <a href="https://pixabay.com//?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=8394894">Pixabay</a> -->
    <!-- Image by <a href="https://pixabay.com/users/jillwellington-334088/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=4139982">Jill Wellington</a> from <a href="https://pixabay.com//?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=4139982">Pixabay</a> -->
    <div class="container my-5 popularProductsMainDiv">
        <h2 class="text-center mb-4">Most Popular Products</h2>
        <div id="popularProductsCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cake-balls-4139982_640.jpg"
                                         class="card-img-top" alt="product1">
                                    <div class="card-body">
                                        <h5 class="card-title">Strawberry cake</h5>
                                        <p class="card-text">Light cake with fresh strawberries and airy cream</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cookies-8394894_640.jpg"
                                         class="card-img-top" alt="product2">
                                    <div class="card-body">
                                        <h5 class="card-title">Vanilla caramel cheesecake with salted crust</h5>
                                        <p class="card-text">Delicate cheesecake with vanilla cream, sweet caramel and
                                            crispy salted base.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/christmas-3865695_640.jpg"
                                         class="card-img-top" alt="product3">
                                    <div class="card-body">
                                        <h5 class="card-title">Honey gingerbread with milk</h5>
                                        <p class="card-text">Fragrant honey gingerbread with a delicate milk aftertaste,
                                            perfect for tea</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/hearts-7107147_640.jpg"
                                         class="card-img-top" alt="product4">
                                    <div class="card-body">
                                        <h5 class="card-title">Vanilla caramel cheesecake with salted crust</h5>
                                        <p class="card-text">Delicate cheesecake with vanilla cream, sweet caramel and
                                            crispy salted base.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cookies-8394894_640.jpg"
                                         class="card-img-top" alt="product5">
                                    <div class="card-body">
                                        <h5 class="card-title">Strawberry cake</h5>
                                        <p class="card-text">Light cake with fresh strawberries and airy cream</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/christmas-3865695_640.jpg"
                                         class="card-img-top" alt="product6">
                                    <div class="card-body">
                                        <h5 class="card-title">Strawberry cake</h5>
                                        <p class="card-text">Light cake with fresh strawberries and airy cream</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cake-balls-4139982_640.jpg"
                                         class="card-img-top" alt="product7">
                                    <div class="card-body">
                                        <h5 class="card-title">Strawberry cake</h5>
                                        <p class="card-text">Light cake with fresh strawberries and airy cream</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/hearts-7107147_640.jpg"
                                         class="card-img-top" alt="product8">
                                    <div class="card-body">
                                        <h5 class="card-title">Strawberry cake</h5>
                                        <p class="card-text">Light cake with fresh strawberries and airy cream</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
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

    <div class="container mb-5 mt-5 p-4 bg-lightblue border rounded shadow">
        <div class="card border-0">
            <div class="row g-0 align-items-center">
                <div class="col-md-6">
                    <img src="../images/homePage/popularProducts/cake-balls-4139982_640.jpg" style="max-height: 300px;"
                         class="img-fluid w-100 rounded" alt="Card Image">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h3 class="card-title">Card Title</h3>
                        <p class="card-text">This is a description of the card. On medium and larger screens, it appears to
                            the right of the image.</p>
                        <a href="#" class="btn btn-primary" id="clickButton">Click Me</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container my-5 popularProductsMainDiv">
        <h2 class="text-center mb-4">New Products</h2>
        <div id="newProductsCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cake-balls-4139982_640.jpg"
                                         class="card-img-top" alt="product1">
                                    <div class="card-body">
                                        <h5 class="card-title">Vanilla caramel cheesecake with salted crust</h5>
                                        <p class="card-text">Delicate cheesecake with vanilla cream, sweet caramel and
                                            crispy salted base</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/hearts-7107147_640.jpg"
                                         class="card-img-top" alt="product1">
                                    <div class="card-body">
                                        <h5 class="card-title">Vanilla caramel cheesecake with salted crust</h5>
                                        <p class="card-text">Delicate cheesecake with vanilla cream, sweet caramel and
                                            crispy salted base</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cookies-8394894_640.jpg"
                                         class="card-img-top" alt="product3">
                                    <div class="card-body">
                                        <h5 class="card-title">Honey gingerbread with milk</h5>
                                        <p class="card-text">Fragrant honey gingerbread with a delicate milk aftertaste,
                                            perfect for tea</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/christmas-3865695_640.jpg"
                                         class="card-img-top" alt="product4">
                                    <div class="card-body">
                                        <h5 class="card-title">Coconut sweets</h5>
                                        <p class="card-text">Juicy coconut sweets with a rich tropical flavor</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cake-balls-4139982_640.jpg"
                                         class="card-img-top" alt="product5">
                                    <div class="card-body">
                                        <h5 class="card-title">Vanilla caramel cheesecake with salted crust</h5>
                                        <p class="card-text">Delicate cheesecake with vanilla cream, sweet caramel and
                                            crispy salted base.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/christmas-3865695_640.jpg"
                                         class="card-img-top" alt="product6">
                                    <div class="card-body">
                                        <h5 class="card-title">Coconut sweets</h5>
                                        <p class="card-text">Juicy coconut sweets with a rich tropical flavor.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/cookies-8394894_640.jpg"
                                         class="card-img-top" alt="product7">
                                    <div class="card-body">
                                        <h5 class="card-title">Honey gingerbread with milk</h5>
                                        <p class="card-text">Fragrant honey gingerbread with a delicate milk aftertaste,
                                            perfect for tea.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 mb-4">
                            <a href="info-product-page.html" class="text-decoration-none">
                                <div class="card">
                                    <img src="../images/homePage/popularProducts/hearts-7107147_640.jpg"
                                         class="card-img-top" alt="product8">
                                    <div class="card-body">
                                        <h5 class="card-title">Strawberry cake</h5>
                                        <p class="card-text">Light cake with fresh strawberries and airy cream</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
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
