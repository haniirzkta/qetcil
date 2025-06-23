{{-- Navbar --}}
<header>
    <nav class="navbar navbar-light bg-white sticky-top py-3">
        <div class="container">
            <button class="navbar-toggler position-absolute start-0 ps-5" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand Title -->
            <h1 class="m-0 text-center w-100">
                <a href="/" class="text-decoration-none brand">QETCIL</a>
            </h1>

            <!-- Icons Profile dan Cart -->
            <div class="d-flex position-absolute end-0 pe-5 align-items-center">

                <a href="{{ route('profile.setting') }}" class="text-dark me-4">
                    <i class="bi bi-person fs-4"></i> {{ Auth::user() ? Auth::user()->name : ''}}
                </a>

                <a href="{{ route('cart.index') }}" class="text-dark position-relative">
                    <i class="bi bi-cart fs-4"></i>
                    <!-- Cart Item Count Badge -->
                    {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">
                        3
                    </span> --}}
                </a>
            </div>
        </div>
    </nav>
</header>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-start m-3 rounded" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title brand" id="offcanvasMenuLabel">Qetcil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <!-- Menu Items -->
        @foreach ($categories as $category)
            <a href="{{ route('front.category', $category->slug) }}" class="menu-item text-decoration-none text-dark">
                <p class="nav-item">{{ $category->name }}</p>
                <i class="bi bi-chevron-right"></i>
            </a>
        @endforeach
        {{-- <a href="{{ route('front.bouquet') }}" class="menu-item text-decoration-none text-dark">
            <p class="nav-item">Bracelets</p>
            <i class="bi bi-chevron-right"></i>
        </a>
        <a href="" class="menu-item text-decoration-none text-dark">
            <p class="nav-item">Earrings</p>
            <i class="bi bi-chevron-right"></i>
        </a>
        <a href="" class="menu-item text-decoration-none text-dark">
            <p class="nav-item">Necklaces</p>
            <i class="bi bi-chevron-right"></i>
        </a>
        <a href="" class="menu-item text-decoration-none text-dark">
            <p class="nav-item">Rings</p>
            <i class="bi bi-chevron-right"></i>
        </a> --}}

        <!-- Footer Buttons -->
        {{-- <div class="menu-footer">
            @guest
                <a href="{{ route('filament.customer.auth.login') }}" class="btn btn-dark">Login</a>
                <a href="{{ route('filament.customer.auth.register') }}" class="btn btn-outline-dark">Registration</a>
            @endguest
            @auth
                <form action="{{ route('filament.customer.auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            @endauth

        </div> --}}
    </div>
</div>
