@extends('backend.master')
@section('title', 'Why Us Panels')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Add Why Us Panel</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('why-us-panels.store') }}">
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
                            <label class="form-label">Order</label>
                            <input name="order" type="number" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Add Panel</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>All Why Us Panels</h5>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif
                    <table class="table mb-0">
                        <thead><tr><th>Title</th><th>Description</th><th>Order</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach($panels as $panel)
                            <tr>
                                <td>{{ $panel->title }}</td>
                                <td>{{ $panel->description }}</td>
                                <td>{{ $panel->order }}</td>
                                <td>
                                    <!-- Edit modal/button pattern here -->
                                    <form action="{{ route('why-us-panels.destroy', $panel) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">Delete</button>
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
