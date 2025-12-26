@extends('backend.master')

@section('title', 'Email Settings')

@section('content')
    <div class="row mb-8">
        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <div class="card" id="edit">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="mb-1">Email Configuration</h4>
                    </div>

                    <form action="{{ route('mail.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mail Mailer</label>
                                <input type="text" name="mail_mailer"
                                    class="form-control @error('mail_mailer') is-invalid @enderror"
                                    value="{{ old('mail_mailer', env('MAIL_MAILER')) }}" required>
                                @error('mail_mailer')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mail Host</label>
                                <input type="text" name="mail_host"
                                    class="form-control @error('mail_host') is-invalid @enderror"
                                    value="{{ old('mail_host', env('MAIL_HOST')) }}" required>
                                @error('mail_host')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mail Port</label>
                                <input type="text" name="mail_port"
                                    class="form-control @error('mail_port') is-invalid @enderror"
                                    value="{{ old('mail_port', env('MAIL_PORT')) }}" required>
                                @error('mail_port')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mail Username</label>
                                <input type="text" name="mail_username"
                                    class="form-control @error('mail_username') is-invalid @enderror"
                                    value="{{ old('mail_username', env('MAIL_USERNAME')) }}" required>
                                @error('mail_username')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mail Password</label>
                                <input type="text" name="mail_password"
                                    class="form-control @error('mail_password') is-invalid @enderror"
                                    value="{{ old('mail_password', env('MAIL_PASSWORD')) }}" required>
                                @error('mail_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mail Encryption</label>
                                <input type="text" name="mail_encryption"
                                    class="form-control @error('mail_encryption') is-invalid @enderror"
                                    value="{{ old('mail_encryption', env('MAIL_ENCRYPTION')) }}" required>
                                @error('mail_encryption')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Mail From Address</label>
                            <input type="email" name="mail_from_address"
                                class="form-control @error('mail_from_address') is-invalid @enderror"
                                value="{{ old('mail_from_address', env('MAIL_FROM_ADDRESS')) }}" required>
                            @error('mail_from_address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
