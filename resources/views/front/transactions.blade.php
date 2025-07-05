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
            <h2>Transactions History</h2>
            <p class="text-muted w-50">Your transaction history provides a detailed overview of all your recent purchases, payments, and order statuses. Easily track your spending, monitor payment statuses, and access important transaction details.</p>

            <div class="row mt-5">
                @forelse ($transactions as $transaction)
                <!-- Transactions Section -->
                <div class="col-md-4 mb-4">
                    <div class="card border border-3 py-5">
                        <div class="card-body text-center">
                            <i class="bi bi-credit-card fs-1 mb-3"></i>
                            <h5 class="card-title">{{ $transaction->transaction_trx_id }}</h5>
                            <p class="card-text">{{ number_format($transaction->grand_total_amount, 2, ',', '.') }} IDR</p>
                            <p class="card-text">{{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                            <a href="{{ $transaction->status === 'unpaid' ? route('front.payment', $transaction->transaction_trx_id) : '#' }}"
   class="btn {{ $transaction->status === 'unpaid' ? 'btn-warning' : 'btn-dark disabled' }}">
    {{ $transaction->status === 'unpaid' ? 'Continue Payment' : ucfirst($transaction->status) }}
</a>

                        </div>
                    </div>
                </div>
            @empty
                <p>No transactions found.</p>
            @endforelse

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
