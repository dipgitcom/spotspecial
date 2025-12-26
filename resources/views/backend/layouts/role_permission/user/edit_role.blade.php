@extends('backend.master')

@section('title', 'User Management')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <h3 class="mb-0">Edit Role</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-4 col-12">
            <form action="{{ route('user.role.update', $user->id) }}" method="POST">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-header  text-white">
                        <h5>Assign Roles </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Roles</label>
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                {{ in_array($role->id, $userRoles) ? 'checked' : '' }}
                                                class="form-check-input" id="role-6">
                                            <label class="form-check-label" for="role-{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-success">Update Assign Roles</button>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>

@endsection

@push('scripts')
@endpush
