@extends('components.layouts.app')
@section('title')
    Qetcil | Cart
@endsection

@section('content')
    <!-- Cart Page -->
    <div class="container my-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Your cart</h1>
            {{-- <a href="#" class="text-decoration-none text-primary">Continue shopping</a> --}}
        </div>

        <!-- Cart Table -->
        <div class="table-responsive">
            <table class="table align-middle cart-items">
                <caption class="visually-hidden">
                    Your cart
                </caption>
                <thead>
                    <tr>
                        <th scope="col" colspan="2">Product</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-end">Total</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cartItems as $cart)
                        <tr data-cart-id="{{ $cart->id }}">
                            <td class="cart-item__media">
                                <a href="" class="cart-item__link">
                                    <img src="{{ Storage::url($cart->bouquet->thumbnail) }}" alt="Product Image"
                                        class="img-fluid rounded" height="100" width="100">
                                </a>
                            </td>
                            <td>
                                <h5 class="fw-semibold mb-1">{{ $cart->bouquet->name }}</h5>
                                @if ($cart->size != 0)
                                    <p class="text-muted mb-0">Size: {{ $cart->size }}</p>
                                @endif
                                <p class="text-muted mb-0">Rp {{ number_format($cart->bouquet->price, 0, ',', '.') }}</p>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex align-items-center mt-3">
                                    <a href="{{ route('cart.quantity.remove', $cart->bouquet->id) }}"
                                       class="btn btn-outline-secondary btn-quantity remove-quantity"
                                       data-cart-id="{{ $cart->id }}" role="button">
                                        -
                                    </a>

                                    <span id="quantity-{{ $cart->id }}" class="mx-2">{{ $cart->quantity }}</span>

                                    <a href="{{ route('cart.quantity.add', $cart->bouquet->id) }}"
                                       class="btn btn-outline-secondary btn-quantity add-quantity"
                                       data-cart-id="{{ $cart->id }}" role="button">
                                        +
                                    </a>

                                    <input type="hidden" id="quantity_input-{{ $cart->id }}" value="{{ $cart->quantity }}">
                                    <input type="hidden" id="bouquetPrice-{{ $cart->id }}" value="{{ $cart->bouquet->price }}">
                                </div>

                            </td>
                            <td class="text-end">
                                <p id="subtotal-{{ $cart->id }}" class="mb-0 fw-bold">Rp
                                    {{ number_format($cart->total_price, 0, ',', '.') }}</p>
                            </td>
                            <td class="text-center">
                                <a href="" class="text-dark p-0 remove-item"
                                     title="Remove item">
                                    <i class="bi bi-trash fs-5"></i>
                                </a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Your cart is empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Total and Checkout -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <p class="fw-bold">Estimated total:</p>
                <h5 id="grandtotal" class="fw-bold">
                    Rp {{ number_format($cartItems->sum('total_price'), 0, ',', '.') }} IDR
                </h5>
                <a href="{{ $cartItems->isNotEmpty() ? route('cart.checkout.add') : '' }}" class="btn btn-dark checkout-btn px-5 py-2 mt-5">Check out</a>

            </div>
        </div>
    </div>

    @push('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

    @endpush
@endsection
