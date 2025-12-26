@extends('backend.master')
@section('title', 'Edit Hero Section')
@section('content')
<div class="container py-4">
    <div class="col-lg-10 mx-auto">
        <div class="card mb-5">
            <div class="card-header bg-info text-white">
                <h5>Edit Hero Section</h5>
            </div>
            <form method="POST" action="{{ route('admin.hero-section.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Badge --}}
                    <div class="mb-4">
                        <label class="form-label">Badge (chip)</label>
                        <input name="badge" class="form-control" value="{{ $section->badge ?? '' }}">
                    </div>

                    {{-- Headline --}}
                    <div class="mb-4">
                        <label class="form-label">Headline</label>
                        <textarea name="headline" class="form-control" rows="2" required>{{ $section->headline ?? '' }}</textarea>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ $section->description ?? '' }}</textarea>
                    </div>

                    {{-- Rating --}}
                    <div class="mb-4">
                        <label class="form-label">Rating (right badge)</label>
                        <input name="rating" class="form-control" value="{{ $section->rating ?? '' }}">
                    </div>

                    {{-- Features --}}
                    <div class="mb-4 p-3 bg-body-tertiary rounded">
                        <div class="mb-2 d-flex align-items-center justify-content-between">
                            <label class="form-label mb-0">Features</label>
                            <button type="button" onclick="addFeature()" class="btn btn-outline-primary btn-sm">+ Add Feature</button>
                        </div>
                        <div id="features-group">
                            @foreach($section->features ?? [] as $i => $feature)
                                <div class="row align-items-center mb-2">
                                    <div class="col-sm-3">
                                        <label>Icon Image</label>
                                        <input type="file" name="features[{{$i}}][icon]" accept="image/*" class="form-control" />
                                        @php
                                            $icon = $feature['icon'] ?? '';
                                            $isUrl = !empty($icon) && filter_var($icon, FILTER_VALIDATE_URL);
                                            $imgSrc = '';
                                            if ($isUrl) {
                                                $imgSrc = $icon;
                                            } elseif (!empty($icon) && file_exists(public_path($icon))) {
                                                $imgSrc = asset($icon);
                                            } elseif (!empty($icon) && file_exists(storage_path('app/public/' . ltrim($icon, '/')))) {
                                                $imgSrc = asset('storage/' . ltrim($icon, '/'));
                                            }
                                        @endphp
                                        @if(!empty($imgSrc))
                                            <div class="mt-2">
                                                <img src="{{ $imgSrc }}" alt="Icon Image" style="max-width: 40px; max-height: 40px; border-radius: 3px;">
                                                <input type="hidden" name="features[{{$i}}][icon_old]" value="{{ $feature['icon'] }}">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <textarea name="features[{{$i}}][text]" class="form-control feature-text-editor" placeholder="Text">{{ $feature['text'] }}</textarea>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.row').remove()">&times;</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="mb-4 p-3 bg-body-tertiary rounded">
                        <div class="mb-2 d-flex align-items-center justify-content-between">
                            <label class="form-label mb-0">Buttons</label>
                            <button type="button" onclick="addButton()" class="btn btn-outline-primary btn-sm">+ Add Button</button>
                        </div>
                        <div id="buttons-group">
                            @foreach($section->buttons ?? [] as $i => $button)
                                <div class="row align-items-center mb-2">
                                    <div class="col-sm-3">
                                        <input name="buttons[{{$i}}][text]" class="form-control" placeholder="Button Text" value="{{ $button['text'] }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <input name="buttons[{{$i}}][type]" class="form-control" placeholder="Type (primary/ghost)" value="{{ $button['type'] }}">
                                    </div>
                                    <div class="col">
                                        <input name="buttons[{{$i}}][url]" class="form-control" placeholder="URL" value="{{ $button['url'] }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.row').remove()">&times;</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Panel (Kicker & Shots) --}}
                    <div class="mb-2">
                        <div class="card p-3 bg-info text-white shadow-sm">
                            <label class="form-label">Side Panel Kicker</label>
                            <input name="panel[kicker]" class="form-control mb-3" value="{{ $section->panel['kicker'] ?? '' }}">
                            <label class="form-label">Panel Shots (with image uploads)</label>
                            <div id="shots-group">
                                @foreach($section->panel['shots'] ?? [] as $i => $shot)
                                    <div class="row align-items-center mb-3 bg-body-tertiary rounded py-2">
                                        <div class="col-12 col-md-3 mb-2 mb-md-0">
                                            @php
                                                $image = $shot['image'] ?? '';
                                                $isUrl = !empty($image) && filter_var($image, FILTER_VALIDATE_URL);
                                            @endphp
                                            @if(!empty($image) && ($isUrl || file_exists(public_path($image))))
                                                <img src="{{ $isUrl ? $image : asset($image) }}" style="max-width:100%;max-height:70px" class="border rounded mb-1">
                                            @endif
                                            <input type="file" name="panel[shots][{{$i}}][image]" class="form-control">
                                            <input type="hidden" name="panel[shots][{{$i}}][image_old]" value="{{ $shot['image'] ?? '' }}">
                                        </div>
                                        <div class="col">
                                            <input name="panel[shots][{{$i}}][caption]" class="form-control" placeholder="Caption" value="{{ $shot['caption'] }}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.row').remove()">&times;</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addShot()" class="btn btn-outline-light btn-sm mt-2">+ Add Shot</button>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button class="btn btn-success px-5">Update Hero Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.feature-text-editor').forEach(textarea => {
            if (!textarea.classList.contains('ck-editor__editable')) {
                CKEDITOR.replace(textarea);
            }
        });
    });

    function addFeature() {
        let i = document.querySelectorAll('#features-group .row').length;
        let html = `
            <div class="row align-items-center mb-2">
                <div class="col-sm-3">
                    <label>Icon Image</label>
                    <input type="file" name="features[${i}][icon]" accept="image/*" class="form-control" />
                </div>
                <div class="col">
                    <textarea name="features[${i}][text]" class="form-control feature-text-editor" placeholder="Text"></textarea>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.row').remove()">&times;</button>
                </div>
            </div>`;
        document.getElementById('features-group').insertAdjacentHTML('beforeend', html);
        // Re-initialize CKEditor on newly added textarea
        let newTextareas = document.querySelectorAll('#features-group .feature-text-editor');
        let latest = newTextareas[newTextareas.length - 1];
        CKEDITOR.replace(latest);
    }

    function addButton() {
        let i = document.querySelectorAll('#buttons-group .row').length;
        let html = `
            <div class="row align-items-center mb-2">
                <div class="col-sm-3"><input name="buttons[${i}][text]" class="form-control" placeholder="Button Text"></div>
                <div class="col-sm-2"><input name="buttons[${i}][type]" class="form-control" placeholder="Type"></div>
                <div class="col"><input name="buttons[${i}][url]" class="form-control" placeholder="URL"></div>
                <div class="col-auto"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.row').remove()">&times;</button></div>
            </div>`;
        document.getElementById('buttons-group').insertAdjacentHTML('beforeend', html);
    }

    function addShot() {
        let i = document.querySelectorAll('#shots-group .row').length;
        let html = `
            <div class="row align-items-center mb-3 bg-body-tertiary rounded py-2">
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                    <input type="file" name="panel[shots][${i}][image]" class="form-control">
                </div>
                <div class="col">
                    <input name="panel[shots][${i}][caption]" class="form-control" placeholder="Caption">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.row').remove()">&times;</button>
                </div>
            </div>`;
        document.getElementById('shots-group').insertAdjacentHTML('beforeend', html);
    }
</script>
@endpush
@endsection
