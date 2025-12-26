@extends('backend.master')

@section('content')
<main class="min-vh-100 d-flex justify-content-center align-items-center bg-light" id="theme-wrapper" data-bs-theme="light">
    <div class="col-lg-4 col-md-6 col-sm-8">
        <div class="card smooth-shadow-md position-relative">
            

            <div class="card-body text-center px-5 py-4">
                <h1 class="mb-4 fw-bold">Register</h1>

                <form action="{{ route('register') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="name" class="form-label fw-semibold">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Full name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                        @error('name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 text-start">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email address here" value="{{ old('email') }}" required autocomplete="username" />
                        @error('email') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password" />
                        @error('password') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" />
                        @error('password_confirmation') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary fw-semibold">Register</button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">Already registered?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@push('scripts')

@endpush
