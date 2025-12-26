@extends('backend.master')

@section('login')
    <main class="min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-3">
            <!-- Card -->
            <div class="card smooth-shadow-md position-relative">
                <!-- Theme toggle (optional positioning fix) -->
                {{-- <div class="position-absolute top-0 start-50 translate-middle-x mt-3">
                    <div class="dropdown">
                        <button class="btn btn-ghost btn-icon rounded-circle" type="button" aria-expanded="false"
                            data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">

                            <span class="visually-hidden bs-theme-text">Toggle theme</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="light" aria-pressed="false">
                                    <i class="bi theme-icon bi-sun-fill"></i>
                                    <span class="ms-2">Light</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="dark" aria-pressed="false">
                                    <i class="bi theme-icon bi-moon-stars-fill"></i>
                                    <span class="ms-2">Dark</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center active"
                                    data-bs-theme-value="auto" aria-pressed="true">
                                    <i class="bi theme-icon bi-circle-half"></i>
                                    <span class="ms-2">Auto</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div> --}}

                <!-- Card body -->
                <div class="card-body p-6">
                    <div class="mb-4 text-center">
                        <a href="">
                            <img src="{{ asset(Auth::user()->profile_photo ?? 'uploads/user.png') }}"
                                class="mb-2 text-inverse" style="width: 100px" alt="Image" />
                        </a>
                    </div>
                    <!-- Form -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="email" class="">Email</label>
                            <input type="email" id="email" class="form-control" value="{{ session('email') ?? '' }}"
                                name="email" placeholder="Email address here" required />
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password"
                                value="{{ session('password') }}" required />
                        </div>
                        <!-- Checkbox -->
                        <div class="d-lg-flex justify-content-between align-items-center mb-4">
                            <div class="form-check custom-checkbox">
                                <input type="checkbox" name="remember" {{ session('remember') ? 'checked' : '' }}
                                    class="form-check-input" id="rememberme" />
                                <label class="form-check-label" for="rememberme">Remember me </label>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </div>

                        <div class="d-md-flex justify-content-between mt-4">
                            <div>
                                <a href="/forgot-password" class="text-inherit fs-5">Forgot your password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
@endpush
