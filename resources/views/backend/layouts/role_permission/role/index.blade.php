@extends('backend.master')

@section('title', 'Role Management')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="mb-5">
                <h3 class="mb-0 ">
                    @if (isset($role))
                        Edit Role
                    @else
                        Add Role
                    @endif
                </h3>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Role Add/Edit Form --}}
        <div class="col-lg-5 col-12">
            <form action="{{ isset($role) ? route('role.update', $role->id) : route('role.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($role))
                    @method('PUT')
                @endif

                <div class="card shadow-sm mb-2">
                    <div class="card-header text-white text-center ">
                        <h5 class="mb-0">
                            @if (isset($role))
                                <i class="bi bi-pencil-square me-2"></i> Edit Role
                            @else
                                <i class="bi bi-plus-circle me-2"></i> Add Role
                            @endif
                        </h5>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">

                        <!-- Role Name -->
                        <div class="mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $role->name ?? '') }}" placeholder="Enter role name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            @if (isset($role))
                                <button class="btn btn-success mb-4">Update</button>
                                <a href="{{ route('role.index') }}" class="btn btn-secondary">Back</a>
                            @else
                                <button class="btn btn-success mb-4">Create</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Role List Table --}}
        <div class="col-lg-7 col-12">
            <div class="card mb-4">
                <div class="card">
                    <div class="card-header d-md-flex border-bottom-0">
                        <div class="flex-grow-1">
                            <label class="form-label fw-bold">Role List</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-striped table-hover align-middle text-nowrap table-centered mt-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1; // Initialize counter
                                    @endphp
                                    @forelse($roles as  $role)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $role->name }}</td>

                                            <td>
                                                <!-- Edit Button -->
                                                <a href="{{ route('role.edit', $role->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>

                                                <!-- Edit Permissions Button (Modal Trigger) -->
                                                <a href="{{ route('permission.edit', $role->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    Assign Permissions
                                                </a>

                                                <!-- Delete Button -->
                                                <button type="button" data-url="{{ route('role.destroy', $role->id) }}"
                                                    class="btn-delete ms-3 btn btn-ghost btn-icon btn-sm rounded-circle texttooltip"
                                                    data-template="trashTwo">
                                                    <div class="btn btn-sm btn-danger"><span>Delete</span></div>
                                                </button>
                                            </td>



                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No roles found</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Optional JS scripts --}}
@endpush
