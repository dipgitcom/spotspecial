@extends('backend.master')

@section('content')
    <div class="row">
        <div class="col-xl-9 col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body">

                    <!-- Profile Heading -->
                    <div class="mb-4">
                        <h3 class="mb-0">Profile Settings</h3>
                    </div>

                    <!-- Profile Info -->
                    <form action="{{ route('profile.update') }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <!-- Avatar -->
                        <div class="mb-4 d-flex align-items-center">
                            <div>
                                @php
                                    $avatarPath =
                                        $user && $user->profile_photo && file_exists(public_path($user->profile_photo))
                                            ? $user->profile_photo
                                            : 'uploads/user.png';
                                @endphp
                                <img src="{{ asset($avatarPath) }}" alt="User Avatar" width="100" height="100"
                                    class="rounded-circle me-3">
                            </div>

                            <div>
                                <label class="btn btn-outline-secondary">
                                    Upload Photo
                                    <input type="file" name="avatar" class="d-none" onchange="this.form.submit()">
                                </label>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                    required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                    required>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3 row">
                            <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                                    required>
                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <hr class="my-5">

                    <!-- Change Password -->
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        <h4 class="mb-4">Change Password</h4>

                        <!-- Current Password -->
                        <div class="mb-3 row">
                            <label for="old_password" class="col-sm-4 col-form-label">Current Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="old_password" class="form-control" id="old_password" required>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3 row">
                            <label for="new_password" class="col-sm-4 col-form-label">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password" class="form-control" id="new_password" required>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3 row">
                            <label for="new_password_confirmation" class="col-sm-4 col-form-label">Confirm New
                                Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="new_password_confirmation" class="form-control"
                                    id="new_password_confirmation" required>
                            </div>
                        </div>

                        <!-- Change Password Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning">Change Password</button>
                        </div>
                    </form>

                    <!-- Forgot password link -->
                    <div class="text-end mt-3">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Add preview script here if needed -->
@endpush
