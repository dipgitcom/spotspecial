@extends('backend.master')
@section('title', 'Process Steps')
@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <!-- Section Meta Edit -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Edit Section Title & Subtitle</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('process-step-section.update') }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Section Title</label>
                            <input name="title" value="{{ $section->title ?? '' }}" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Section Subtitle</label>
                            <input name="subtitle" value="{{ $section->subtitle ?? '' }}" class="form-control">
                        </div>
                        <button class="btn btn-success w-100">Update Section</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Process Step -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Add Process Step</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('process-steps.store') }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Title</label>
                            <input name="title" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Step Number</label>
                            <input name="step_number" type="number" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Add Step</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Process Steps List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>All Process Steps</h5>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Step</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($steps as $step)
                            <tr>
                                <td>{{ $step->step_number }}</td>
                                <td>{{ $step->title }}</td>
                                <td>{{ $step->description }}</td>
                                <td>
                                    <form action="{{ route('process-steps.destroy', $step) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">Delete</button>
                                    </form>
                                    <!-- Optionally: Edit Btn/Modal Here -->
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
