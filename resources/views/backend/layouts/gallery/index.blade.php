@extends('backend.master')
@section('title','Gallery Management')
@section('content')
<div class="container py-4">
    <div class="row">
        <!-- SECTION TITLE/SUBTITLE Edit -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Gallery Section Title & Subtitle</h5>
                </div>
                <div class="card-body">
                    @if(session('section_success'))
                        <div class="alert alert-success">{{ session('section_success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('gallery-section.update') }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Title</label>
                            <input name="title" value="{{ $section->title ?? '' }}" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Subtitle</label>
                            <input name="subtitle" value="{{ $section->subtitle ?? '' }}" class="form-control">
                        </div>
                        <button class="btn btn-success w-100">Update Section</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- ADD IMAGE FORM -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Add Gallery Item</h5>
                </div>
                <div class="card-body">
                    @if(session('image_success'))
                        <div class="alert alert-success">{{ session('image_success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('galleries.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Caption</label>
                            <input name="caption" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" class="form-control" value="1">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Add Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- IMAGE LIST -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>All Gallery Images</h5>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Caption</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($galleries as $gallery)
                            <tr>
                                <td>
                                    @if($gallery->image)
                                        <img src="{{ asset('storage/'.$gallery->image) }}" alt="img" width="80">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $gallery->caption }}</td>
                                <td>{{ $gallery->order }}</td>
                                <td>
                                    {{-- (Add edit modal if needed) --}}
                                    <form action="{{ route('galleries.destroy', $gallery) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
