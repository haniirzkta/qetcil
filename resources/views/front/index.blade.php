@extends('components.layouts.app')
@section('title')
    Qetcil Bouquet | Timeless Beauty, Forever in Bloom
@endsection

@section('content')
    {{-- Carousel --}}
    <section id="carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 500px;">
                <img src="{{ asset('assets/background/bg4.jpg') }}" class="d-block w-100" alt="qetcil">
                <div class="carousel-caption d-none d-md-block bg-pink bg-opacity-75 rounded p-3">
                    <h5 class="text-white">Crafting Stunning Arrangements, Without the Hassle</h5>
                    <p class="text-white">We take the hassle out of floral decor. Our artificial flowers are beautifully arranged and ready to enhance any space, giving you a long-lasting touch of nature’s finest.</p>
                </div>
            </div>
            <div class="carousel-item" style="height: 500px;">
                <img src="{{ asset('assets/background/bg5.jpg') }}" class="d-block w-100" alt="qetcil">
                <div class="carousel-caption d-none d-md-block bg-pink bg-opacity-75 rounded p-3">
                    <h5 class="text-white">Endless Freshness, Always in Style</h5>
                    <p class="text-white">Keep your spaces fresh and stylish all year long with our artificial flowers. Designed to maintain their beauty and charm, these blooms are a timeless addition to any decor.</p>
                </div>
            </div>
            <div class="carousel-item" style="height: 500px;">
                <img src="{{ asset('assets/background/bg6.jpg') }}" class="d-block w-100" alt="qetcil">
                <div class="carousel-caption d-none d-md-block bg-pink bg-opacity-75 rounded p-3">
                    <h5 class="text-white">Timeless Blooms, Endless Beauty</h5>
                    <p class="text-white">Enjoy the beauty of flowers that never wither. Our artificial blooms are crafted to stand the test of time, providing a timeless aesthetic that enhances any environment.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    {{-- Discover --}}
    <section id="discover" class="container my-5">
        <div class="row">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-white border-0" style="background-color: #f8d5dd;">
                    <div class="position-relative">
                        <img src="{{ asset('assets/background/bg1.jpg') }}" class="card-img-top"
                            alt="Lasting Beauty, Made with Love" style="height: 250px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 w-100 h-50"
                            style="background: linear-gradient(to top, rgba(248, 213, 221, 0.9), rgba(248, 213, 221, 0));">
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 text-center p-3">
                            <h5 class="m-0 text-dark">Lasting Beauty, Made with Love</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-white border-0" style="background-color: #f8d5dd;">
                    <div class="position-relative">
                        <img src="{{ asset('assets/background/bg2.jpg') }}" class="card-img-top" alt="A touch of forever"
                            style="height: 250px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 w-100 h-50"
                            style="background: linear-gradient(to top, rgba(248, 213, 221, 0.9), rgba(248, 213, 221, 0));">
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 text-center p-3">
                            <h5 class="m-0 text-dark">A touch of forever</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-white border-0" style="background-color: #f8d5dd;">
                    <div class="position-relative">
                        <img src="{{ asset('assets/background/bg3.jpg') }}" class="card-img-top" alt="Everlasting Blooms for Every Space"
                            style="height: 250px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 w-100 h-50"
                            style="background: linear-gradient(to top, rgba(248, 213, 221, 0.9), rgba(248, 213, 221, 0));">
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 text-center p-3">
                            <h5 class="m-0 text-dark">Everlasting Blooms for Every Space</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    @endpush
@endsection
