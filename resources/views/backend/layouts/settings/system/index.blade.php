@extends('backend.master')

@section('title', 'System Settings')

@section('content')
    <div class="row mb-5">
        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4"> Website Settings</h4>

                    <form method="POST" action="{{ route('system.update') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3 row">
                            <label for="title" class="col-sm-4 col-form-label form-label">Website Title</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $system->title ?? '') }}" placeholder="Enter Title" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $system->email ?? '') }}" placeholder="Enter Email" required>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="mb-3 row align-items-center">
                            <label for="logo" class="col-sm-4 col-form-label form-label">Logo</label>
                            <div class="col-md-8 d-flex gap-3 flex-wrap">
                                <input type="file" class="form-control w-50" id="logo" name="logo"
                                    onchange="previewImage(this, 'logoPreview')">

                                <!-- New Preview -->
                                <div class=" rounded p-1">
                                    <img id="logoPreview" src="#" alt="New Logo Preview"
                                        style="max-height: 60px; display: none;">
                                </div>

                                <!-- Current Logo -->
                                @if (!empty($system->logo))
                                    <div class=" rounded p-1">
                                        <img src="{{ asset($system->logo) }}" alt="Current Logo" style="max-height: 60px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Favicon -->
                        <div class="mb-3 row align-items-center">
                            <label for="favicon" class="col-sm-4 col-form-label form-label">Favicon</label>
                            <div class="col-md-8 d-flex gap-3 flex-wrap">
                                <input type="file" class="form-control w-50" id="favicon" name="favicon"
                                    onchange="previewImage(this, 'faviconPreview')">

                                <!-- New Preview -->
                                <div class=" rounded p-1">
                                    <img id="faviconPreview" src="#" alt="New Favicon Preview"
                                        style="max-height: 60px; display: none;">
                                </div>

                                <!-- Current Favicon -->
                                @if (!empty($system->favicon))
                                    <div class=" rounded p-1">
                                        <img src="{{ asset($system->favicon) }}" alt="Current Favicon"
                                            style="max-height: 60px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Copyright -->
                        <div class="mb-3 row">
                            <label for="copyright" class="col-sm-4 col-form-label form-label">Copyright</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="copyright" name="copyright"
                                    value="{{ old('copyright', $system->copyright ?? '') }}"
                                    placeholder="© Company Name 2025" required>
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

            {{-- instagram  --}}
            <div class="col-md-12 mt-2">
                <form method="POST" action="{{ route('social.update') }}">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body mt-2">
                            <h5 class="card-title mb-3">Instagram</h5>

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="instagram_title" value="{{ $instagram->name ?? '' }}"
                                    class="form-control">
                            </div>


                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input type="url" name="instagram_url" value="{{ $instagram->url ?? '' }}"
                                    class="form-control">
                            </div>

                            <div class="text-end">
                                <button type="submit" name="submit_section" value="instagram"
                                    class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Facebook -->
            <div class="col-md-12 mt-2">
                <form method="POST" action="{{ route('social.update') }}">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body mt-2">
                            <h5 class="card-title mb-3">Facebook</h5>

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="facebook_title" value="{{ $facebook->name ?? '' }}"
                                    class="form-control">
                            </div>



                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input type="url" name="facebook_url" value="{{ $facebook->url ?? '' }}"
                                    class="form-control">
                            </div>

                            <div class="text-end">
                                <button type="submit" name="submit_section" value="facebook"
                                    class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Twitter -->
            <div class="col-md-12 mt-2">
                <form method="POST" action="{{ route('social.update') }}">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body ">
                            <h5 class="card-title mb-3">Twitter</h5>

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="twitter_title" value="{{ $twitter->name ?? '' }}"
                                    class="form-control">
                            </div>



                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input type="url" name="twitter_url" value="{{ $twitter->url ?? '' }}"
                                    class="form-control">
                            </div>

                            <div class="text-end">
                                <button type="submit" name="submit_section" value="twitter"
                                    class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TikTok -->
            <div class="col-md-12 mt-2 ">
                <form method="POST" action="{{ route('social.update') }}">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body mt-2">
                            <h5 class="card-title mb-3">TikTok</h5>

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="tiktok_title" value="{{ $tiktok->name ?? '' }}"
                                    class="form-control">
                            </div>


                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input type="url" name="tiktok_url" value="{{ $tiktok->url ?? '' }}"
                                    class="form-control">
                            </div>

                            <div class="text-end">
                                <button type="submit" name="submit_section" value="tiktok"
                                    class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

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
