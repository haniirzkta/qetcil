@extends('components.layouts.app')

@section('title', 'Bouquet Detail Page')

@push('before-styles')
    <style>
        /* Custom Styling for Size Options */
        /* Styling for Size Options to Look Like Buttons */
        .size-option {
            display: none;
            /* Hide the radio button itself */
        }

        .size-option-label {
            cursor: pointer;
            transition: all 0.3s ease;
            color: #495057;
            border-radius: 50px;
            /* Rounded corners for button-like look */
            border: 2px solid #ced4da;
            /* Initial border color */
        }

        .size-option:checked+.size-option-label {
            background-color: #000;
            color: white;
            border-color: #000;
        }

        .size-option-label:hover {
            background-color: #f8f9fa;
            color: #000;
        }

        /* Optional: Size label active styling */
        .size-option:checked+.size-option-label {
            background-color: #212529;
            color: white;
        }


        /* Quantity Input Styling */
        .quantity-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-container button {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            width: 40px;
            height: 40px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .quantity-container input {
            width: 60px;
            text-align: center;
            border: 1px solid #ced4da;
            padding: 5px;
        }

        .opacity-50 {
            opacity: 0.5;
        }
    </style>
@endpush

@section('content')
    @forelse ($bouquet as $bouquet)
        <div class="container my-5">
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    <div class="card border-0">
                        <img src="{{ Storage::url($bouquet->thumbnail) }}" id="main-image" alt="Main Product" class="img-fluid">

                        <!-- Thumbnail Images -->
                        <div class="mt-2 d-flex">
                            <img src="{{ Storage::url($bouquet->thumbnail) }}"
                                data-src="{{ Storage::url($bouquet->thumbnail) }}" class="thumbnail p-1 rounded me-2 active"
                                alt="Thumbnail" width="120" height="120">
                            @forelse ($bouquet->bouquetPhotos as $photo)
                                <img src="{{ Storage::url($photo->photo) }}" data-src="{{ Storage::url($photo->photo) }}"
                                    class="thumbnail p-1 rounded me-2 cursor-pointer" alt="Thumbnail" width="120"
                                    height="120">
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-md-6">
                    <h1 class="fw-bold">{{ $bouquet->name }}</h1>
                    <h6 class="fw-bold">Rp {{ number_format($bouquet->price, 2, ',', '.') }} IDR</h6>
                    <p class="text-secondary"><small>Shipping calculated at checkout.</small></p>

                    <form method="POST" action="{{ route('cart.add', $bouquet->id) }}">
                        @csrf
                        <input type="hidden" name="bouquet_id" value="{{ $bouquet->id }}">

                        <!-- Quantity Section -->
                        <div class="mb-4">
                            <label for="quantity" class="fw-semibold">Quantity:</label>
                            <div class="quantity-container">
                                <button type="button" class="btn btn-outline-dark" id="decrement">-</button>
                                <input type="number" class="form-control text-center" name="quantity" id="quantity"
                                    value="1" min="1">
                                <button type="button" id="increment">+</button>
                            </div>
                        </div>

                         <!-- Size Section -->
                        @if ($bouquet->category->name == 'Rings')
                            <div class="mb-4">
                                <h5 class="fw-semibold">Choose Size</h5>
                                <div class="d-flex gap-3 flex-wrap">
                                    @forelse ($bouquet->bouquetSizes as $size)
                                        <div>
                                            <!-- Radio Button for Size -->
                                            <input class="size-option" type="radio" name="size"
                                                id="size-{{ $size->size }}" value="{{ $size->size }}" required>

                                            <!-- Label for Size with Bootstrap Button-like Style -->
                                            <label
                                                class="size-option-label px-3 py-2 rounded border border-secondary d-inline-block text-center"
                                                for="size-{{ $size->size }}">
                                                {{ $size->size }} cm
                                            </label>
                                        </div>
                                    @empty
                                        <p>No sizes available</p>
                                    @endforelse
                                </div>
                            </div>

                        @else
                            <input type="hidden" name="size" value="0">
                        @endif



                        <!-- Buttons -->
                        <div class="d-grid gap-2 mt-4 mb-3">
                            @if ($bouquet->is_sold)
                                <a class="btn btn-dark py-2">Bouquet Is Sold</a>
                            @else
                                <button class="btn btn-dark py-2" type="submit"
                                    formaction="{{ route('checkout.add') }}">Buy
                                    Now</button>
                                <button class="btn btn-outline-dark py-2" type="submit"
                                    formaction="{{ route('cart.add', $bouquet->id) }}">Add to Cart</button>
                            @endif
                        </div>
                    </form>

                    <!-- Product Details -->
                    <ul class="list-unstyled mt-4">
                        <li><strong>Color:</strong> Rose Gold</li>
                        <li><strong>Purity:</strong> 16K (70%)</li>
                        <li><strong>Length:</strong> 15.5 - 16.5 Centimeter</li>
                    </ul>
                </div>
            </div>
        </div>
    @empty
        <p>No bouquet found.</p>
    @endforelse
@endsection

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        // Quantity Increment/Decrement Logic
        document.getElementById('increment').addEventListener('click', () => {
            const qty = document.getElementById('quantity');
            qty.value = parseInt(qty.value) + 1;
        });

        document.getElementById('decrement').addEventListener('click', () => {
            const qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        });

        // Size Selection Logic
        document.querySelectorAll('.size-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Jalankan setelah halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', () => {
            // Klik otomatis thumbnail pertama
            const firstThumbnail = document.querySelector('.thumbnail');
            if (firstThumbnail) {
                firstThumbnail.click();
            }
        });

        // Thumbnail Click Logic
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Change main image
                const mainImage = document.getElementById('main-image');
                mainImage.src = this.dataset.src;

                // Update styles for active thumbnail
                document.querySelectorAll('.thumbnail').forEach(tn => {
                    tn.classList.remove('border-blue', 'opacity-100');
                    tn.classList.add('opacity-50');
                });
                this.classList.remove('opacity-50');
                this.classList.add('border-blue');
            });
        });
    </script>
@endpush
