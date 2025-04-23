<header>
    <nav class="navbar navbar-expand-lg myNavbar">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img  src="{{ asset('images/homePage/logo.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded">
            </a>
            <a href="{{ route('home') }}" class="position-absolute start-50 translate-middle-x text-decoration-none textHome">
                <h1 class="fs-4 mb-0">World Sweets</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav textOption">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="logout(event)">Log out</a>
{{--                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">--}}
{{--                                @csrf--}}
{{--                                <button type="submit" class="nav-link btn btn-link" style="cursor: pointer;">Log out</button>--}}
{{--                            </form>--}}
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Account</a>
                        </li>
                    @endauth
                    <li class="nav-item"><a class="nav-link" href="{{ route('cart') }}">Cart</a></li>

                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="containerS">
    <div class="d-flex panelSearch">
        <input class="form-control" type="search" id="searchInput" placeholder="Search" aria-label="Search">
        <button class="btn" type="button" id="searchButton" onclick="window.location.href='{{ route('search.results') }}'">Search</button>
    </div>
</div>

<div class="category-section">
    <div class="container category-container">
        <div class="row g-4 categories">
            <div class="col-6 col-md-3">
                <button class="category-btn" onclick="window.location.href='{{ route('search.results') }}'">NEW ARRIVALS</button>
            </div>
            <div class="col-6 col-md-3">
                <button class="category-btn" onclick="window.location.href='{{ route('search.results') }}'">SHOP CANDY</button>
            </div>
            <div class="col-6 col-md-3">
                <button class="category-btn" onclick="window.location.href='{{ route('search.results') }}'">SHOP GIFTS</button>
            </div>
            <div class="col-6 col-md-3">
                <button class="category-btn" onclick="window.location.href='{{ route('search.results') }}'">GIFT CONCIERGE</button>
            </div>
        </div>
    </div>
</div>
