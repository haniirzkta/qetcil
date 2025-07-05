@extends('components.layouts.app')

@section('title', 'Qetcil Bouquet | My Account')

@section('content')

@push('after-styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endpush


<div class="container">
    <div class="row">
        <!-- Main Content Area -->
        <div class="col-md-9 col-lg-10 p-5">
            <h2>Edit Profile</h2>
            <p class="text-muted w-50">
                Your profile is the key to your experience with us. Keep it up to date to ensure you’re getting the most out of our services.
                Here, you can easily update your personal information, including your name, email address, address, and password.
            </p>

            <!-- Edit Profile Form -->
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <!-- Name Input -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                </div>

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                </div>

                <!-- Address Input -->
                @php
    $userAddress = auth()->user()->address;
@endphp

<div class="mb-3">
    <label for="phone_number" class="form-label">No. Telepon</label>
    <input type="text" class="form-control" id="phone_number" name="phone_number"
        value="{{ old('phone_number', $user->phone_number) }}">
</div>


<div class="mb-3">
    <label for="address" class="form-label">Alamat</label>
    <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address', $userAddress->address ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="city" class="form-label">Kota</label>
    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $userAddress->city ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="post_code" class="form-label">Kode Pos</label>
    <input type="text" class="form-control" id="post_code" name="post_code" value="{{ old('post_code', $userAddress->post_code ?? '') }}" required>
</div>


                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty to keep current">
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Leave empty to keep current">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-dark py-2 px-5 mt-3">Update Profile</button>
            </form>
        </div>
    </div>
</div>

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endpush
@endsection