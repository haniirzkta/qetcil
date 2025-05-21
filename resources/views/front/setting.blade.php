@extends('components.layouts.app')

@section('title', 'My Account')

@section('content')

    @push('after-styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @endpush
    <div class="container">
        <div class="row">


            <!-- Main Content Area -->
            <div class="col-md-9 col-lg-10 p-5">
                <h2>Settings</h2>
                <p class="text-muted w-50">Your account is the heart of your experience with us. Customize and update your
                    personal information, adjust your privacy settings, and make sure your account is secure.</p>

                <!-- Card for My Profile and Password -->
                <div class="row mt-5">
                    <!-- My Profile -->
                    <div class="col-md-4 mb-4">
                        <div class="card border border-3 py-5">
                            <div class="card-body text-center">
                                <i class="bi bi-person-circle fs-1 mb-3"></i>
                                <h5 class="card-title">My Profile</h5>
                                <p class="card-text">Ubah data diri kamu</p>
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark">Edit Now</a>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions -->
                    <div class="col-md-4 mb-4">
                        <div class="card border border-3 py-5">
                            <div class="card-body text-center">
                                <i class="bi bi-credit-card fs-1 mb-3"></i>
                                <h5 class="card-title">Transactions</h5>
                                <p class="card-text">View your transaction history</p>
                                {{-- {{ route('transactions.index') }} --}}
                                <a href="{{ route('profile.transactions') }}" class="btn btn-outline-dark">View History</a>
                            </div>
                        </div>
                    </div>

                    <!-- Logout -->
                    <div class="col-md-4 mb-4">
                        <div class="card border border-3 py-5">
                            <div class="card-body text-center">
                                <i class="bi bi-box-arrow-right fs-1 mb-3"></i>
                                <h5 class="card-title">Logout</h5>
                                <p class="card-text">Log out of your account securely.</p>
                                <form method="POST" action="{{ route('filament.customer.auth.logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-dark">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    @endpush
@endsection
