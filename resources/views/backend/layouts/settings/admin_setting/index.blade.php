@extends('backend.master')

@section('title', 'Admin Settings')

@section('content')
    <div class="row mb-5">
        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Admin Settings</h4>

                    <form method="POST" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3 row">
                            <label for="title" class="col-sm-4 col-form-label form-label">Title</label>
                            <div class="col-md-8">
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $admin->title ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                            <div class="col-md-8">
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $admin->email ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Copyright -->
                        <div class="mb-3 row">
                            <label for="copyright" class="col-sm-4 col-form-label form-label">Copyright</label>
                            <div class="col-md-8">
                                <input type="text" name="copyright" id="copyright" class="form-control"
                                    value="{{ $admin->copyright ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Hotline -->
                        <div class="mb-3 row">
                            <label for="hotline" class="col-sm-4 col-form-label form-label">Hotline / Phone</label>
                            <div class="col-md-8">
                                <input type="text" name="hotline" id="hotline" class="form-control"
                                    value="{{ $admin->hotline ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3 row">
                            <label for="address" class="col-sm-4 col-form-label form-label">Address</label>
                            <div class="col-md-8">
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ $admin->address ?? '' }}" required>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="mb-3 row align-items-center">
                            <label for="logo" class="col-sm-4 col-form-label form-label">Logo</label>
                            <div class="col-md-8 d-flex gap-3 flex-wrap">
                                <input type="file" class="form-control w-50" name="logo" id="logo"
                                    onchange="previewImage(this, 'logoPreviewNew')">

                                <div class=" rounded p-1">
                                    <img id="logoPreviewNew" src="#" alt="New Logo Preview"
                                        style="max-height: 60px; display:none;">
                                </div>

                                @if (!empty($admin->logo))
                                    <div class=" rounded p-1">
                                        <img src="{{ asset($admin->logo) ?? asset('backend/uploads/user.png') }}"
                                            alt="Current Logo" style="max-height: 60px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Favicon -->
                        <div class="mb-3 row align-items-center">
                            <label for="favicon" class="col-sm-4 col-form-label form-label">Favicon</label>
                            <div class="col-md-8 d-flex gap-3 flex-wrap">
                                <input type="file" class="form-control w-50" name="favicon" id="favicon"
                                    onchange="previewImage(this, 'faviconPreviewNew')">

                                <div class=" rounded p-1">
                                    <img id="faviconPreviewNew" src="#" alt="New Favicon Preview"
                                        style="max-height: 60px; display:none;">
                                </div>

                                @if (!empty($admin->favicon))
                                    <div class=" rounded p-1">
                                        <img src="{{ asset($admin->favicon) }}" alt="Current Favicon"
                                            style="max-height: 60px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Update
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
@endpush
