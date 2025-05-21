@extends('components.layouts.app')
@section('title')
    Qetcil | Checkout
@endsection

@section('content')
    <!-- Checkout Page -->
    <div class="container my-5">
        <h1 class="mb-4">Checkout</h1>

        <form action="{{ route('front.checkoutProcess') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <input type="hidden" name="bouquet_id" value="{{ $bouquet['id'] }}">
            <input type="hidden" name="quantity" value="{{ $data['quantity'] }}">

            <div class="row">
                <!-- Left Section -->
                <div class="col-lg-8">
                    <!-- Shipping Address -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Alamat Pengiriman</h5>
                            <p class="mb-1"><strong>Rumah · {{ Auth::user()->name }}</strong></p>
                            <p class="text-muted">Jl. Beji No.99, Universitas Gunadarma, Depok, Jawa Barat</p>
                            {{-- <button class="btn btn-outline-secondary btn-sm" type="button">Ganti</button> --}}
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Qetcil</h5>
                            <div class="d-flex align-items-start mb-3">
                                <img src="{{ Storage::url($bouquet['thumbnail']) }}" alt="Product Image"
                                    class="img-fluid rounded me-3" width="80" height="80">
                                <div>
                                    <p class="mb-1">{{ $bouquet['name'] }}</p>
                                    <p class="text-muted mb-0">{{ $data['quantity'] }} x
                                        Rp{{ number_format($bouquet['price'], 0, ',', '.') }}</p>
                                    <p class="text-muted">Size: {{ $data['size'] }}</p>
                                </div>
                            </div>
                            <textarea name="note" class="form-control" rows="2" placeholder="Kasih catatan (opsional)"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-lg-4">
                    <!-- Payment Method -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Metode Pembayaran</h5>
                            @forelse ($banks as $bank)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="bank_id" id="bank_{{ $bank->id }}" value="{{ $bank->id }}" {{ $loop->first ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bank_{{ $bank->id }}">
                                        {{ $bank->bank_name }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted">Tidak ada metode pembayaran yang tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Transaction Summary -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Cek Ringkasan Transaksimu, Yuk</h5>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total Harga ({{ $data['quantity'] }} Bouquet)</span>
                                    <span>Rp{{ number_format($bouquet['price'] * $data['quantity'], 0, ',', '.') }}</span>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total Tagihan</strong>
                                <strong>Rp{{ number_format($bouquet['price'] * $data['quantity'], 0, ',', '.') }}</strong>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-3">Bayar Sekarang</button>
                            <p class="text-muted small text-center mt-2">Dengan melanjutkan pembayaran, kamu menyetujui S&K</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    @endpush
@endsection
