@extends('backend.master')
@section('title','Footer Settings')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <!-- Edit Copyright (left) -->
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Edit Footer Copyright</h5>
                </div>
                <form method="POST" action="{{ route('footer-settings.update', $footer->id) }}">
                    @csrf @method('PUT')
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Copyright</label>
                            <input name="copyright" value="{{ $footer->copyright }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-success px-5">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Footer Links (right) -->
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">Footer Right-side Links</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                        <tr><th>Order</th><th>Label</th><th>URL</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        @foreach($links as $link)
                        <tr>
                            <form method="POST" action="{{ route('footer-links.update', $link->id) }}">
                                @csrf @method('PUT')
                                <td>
                                    <input type="number" name="order" value="{{ $link->order }}" style="width:50px" class="form-control">
                                </td>
                                <td>
                                    <input name="label" value="{{ $link->label }}" class="form-control">
                                </td>
                                <td>
                                    <input name="url" value="{{ $link->url }}" class="form-control">
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-info">Save</button>
                            </form>
                                    <form method="POST" action="{{ route('footer-links.destroy', $link->id) }}" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-xs btn-danger" onclick="return confirm('Delete?')">Del</button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('footer-links.store') }}" class="d-flex gap-2">
                        @csrf
                        <input name="order" type="number" value="1" class="form-control" style="width:60px" placeholder="Order">
                        <input name="label" class="form-control" placeholder="Label">
                        <input name="url" class="form-control" placeholder="URL">
                        <button class="btn btn-success btn-sm">Add Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
