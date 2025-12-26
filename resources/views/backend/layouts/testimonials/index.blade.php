@extends('backend.master')
@section('title', 'Testimonials Management')
@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Section title/subtitle form -->
        <div class="col-lg-6 mb-4">
            <div class="card"><div class="card-header bg-info text-white">
                <h5>Testimonials Section Title & Subtitle</h5>
            </div>
            <div class="card-body">
                @if(session('section_success'))
                    <div class="alert alert-success">{{ session('section_success') }}</div>
                @endif
                <form method="POST" action="{{ route('testimonial-section.update') }}">
                    @csrf
                    <div class="mb-2">
                        <label>Title</label>
                        <input name="title" value="{{ $section->title ?? '' }}" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Subtitle</label>
                        <input name="subtitle" value="{{ $section->subtitle ?? '' }}" class="form-control">
                    </div>
                    <button class="btn btn-success w-100">Update Section</button>
                </form>
            </div>
            </div>
        </div>
        <!-- Add testimonial -->
        <div class="col-lg-6 mb-4">
            <div class="card"><div class="card-header bg-info text-white">
                <h5>Add Testimonial</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('testimonials.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label>Quote</label>
                        <textarea name="quote" class="form-control" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Author</label>
                        <input name="author" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Location</label>
                        <input name="location" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="1" required>
                    </div>
                    <button class="btn btn-success w-100">Add</button>
                </form>
            </div>
            </div>
        </div>
    </div>
    <!-- Testimonials List -->
    <div class="row">
        <div class="col-12">
            <div class="card"><div class="card-header bg-info text-white">
                <h5>All Testimonials</h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Quote</th>
                            <th>Author</th>
                            <th>Location</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($testimonials as $t)
                        <tr>
                            <td>{{ $t->quote }}</td>
                            <td>{{ $t->author }}</td>
                            <td>{{ $t->location }}</td>
                            <td>{{ $t->order }}</td>
                            <td>
                                <form method="POST" action="{{ route('testimonials.destroy', $t) }}" style="display:inline-block">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                </form>
                                {{-- Add Edit modal trigger here if needed --}}
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
