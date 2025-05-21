@extends('components.layouts.app')

@section('title', 'Qetcil Bouquet | Checkout')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Right Column: Payment Details -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="fs-2">Metode Pembayaran</h3>
                    <!-- Payment Details -->
                    <div class="mt-5">
                        <div class="mb-3">
                            <p class="fw-bold fs-6 mb-0">{{ $transaction->bank->bank_name }}</p>
                            <p class="fs-6">{{ $transaction->bank->bank_account_name }}</p>
                            <p class="fw-bold fs-6 mb-0">Nomor Virtual Account</p>
                            <div class="d-flex align-items-center">
                                <p class="fs-6" id="bankAccountNumber">{{ $transaction->bank->bank_account_number }}</p>
                                <button class="btn btn-outline-secondary btn-sm ms-2" onclick="copyToClipboard('#bankAccountNumber')">Salin</button>
                            </div>
                        </div>
                    </div>

                    <!-- Amount and Instructions -->
                    <div class="mt-3">
                        <h6 class="fw-bold fs-6">Total Pembayaran</h6>
                        <div class="d-flex align-items-center">
                            <p class="fw-bold fs-6" id="totalAmount">Rp{{ number_format($transaction->grand_total_amount, 0, ',', '.') }}</p>
                            <button class="btn btn-outline-secondary btn-sm ms-2" onclick="copyToClipboard('#totalAmount')">Salin</button>
                        </div>
                        <p class="fs-6">Batas waktu pembayaran: {{ \Carbon\Carbon::parse($transaction->created_at)->addDay()->format('l, d F Y H:i') }}</p>
                    </div>

                    <!-- Confirm Payment Button -->
                    {{-- <a href="{{ route('front.paymentStore', $transaction->transaction_trx_id) }}" class="btn btn-dark w-100">Confirm Payment</a> --}}
                </div>
            </div>
        </div>

        <!-- Left Column: Product Details -->
        <div class="col-md-4">
            <div class="card border border-2 align-items-center mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Upload Proof</h5>
                    <div class="d-flex">
                        <form action="{{ route('front.paymentStore', $transaction->transaction_trx_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <input type="file" class="form-control" id="proof" accept="image/*" name="proof" required onchange="previewImage(event)">
                            </div>
                            <div class="mb-3">
                                <img id="imagePreview" class="img-fluid rounded" src="" alt="Image Preview" style="display: none;">
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    function copyToClipboard(elementId) {
        var copyText = document.querySelector(elementId);
        var range = document.createRange();
        range.selectNode(copyText);
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();
        alert("Copied to clipboard: " + copyText.textContent);
    }

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection
