@extends('backend.master')

@section('title', 'Permission Management')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="mb-5 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Edit Permissions</h3>
                <a href="{{ route('role.index') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-12">
            <form action="{{ route('role.permission.update', $role->id) }}" method="POST" class="card p-4 shadow-sm">
                @csrf

                @if ($permissions->count() > 0)
                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-md-3 col-sm-6 col-12 mb-3">
                                <div class="rounded  p-2 h-100 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" name="permissions[]"
                                        value="{{ $permission->id }}"
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label mb-0">{{ ucfirst($permission->name) }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No permissions available.</p>
                @endif

                <div class="mt-3">
                    <button type="submit" class="btn btn-success w-100"> Update Permissions</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
