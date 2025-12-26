@extends('backend.master')
@section('title', 'FAQ Management')
@section('content')
<div class="container py-4">
    <div class="row">
        <!-- FAQ Section Title/Subtitle -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>FAQ Section Title & Subtitle</h5>
                </div>
                <div class="card-body">
                    @if(session('section_success'))
                        <div class="alert alert-success">{{ session('section_success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('faq-section.update') }}">
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

        <!-- ADD FAQ FORM -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Add FAQ</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('faqs.store') }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Question</label>
                            <input name="question" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Answer</label>
                            <textarea name="answer" class="form-control" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" class="form-control" value="1" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Add FAQ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>All FAQs</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead><tr>
                            <th>Question</th><th>Answer</th><th>Order</th><th>Actions</th>
                        </tr></thead>
                        <tbody>
                        @foreach($faqs as $f)
                            <tr>
                                <td>{{ $f->question }}</td>
                                <td>{{ $f->answer }}</td>
                                <td>{{ $f->order }}</td>
                                <td>
                                    <form method="POST" action="{{ route('faqs.destroy', $f) }}" style="display:inline-block">
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
