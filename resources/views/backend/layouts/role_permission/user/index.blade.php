@extends('backend.master')

@section('title', 'User Management')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <h3 class="mb-0">{{ isset($user) ? 'Edit User' : 'Add User' }}</h3>
        </div>
    </div>

    <div class="row">
        {{-- User Form --}}
        <div class="col-lg-5 col-12">
            <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <div class="card shadow-sm">
                    <div class="card-header text-white text-center ">
                        <h5 class="mb-0">
                            <i class="bi {{ isset($user) ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                            {{ isset($user) ? 'Edit User' : 'Add User' }}
                        </h5>
                    </div>
                    <div class="card-body">

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name ?? '') }}" placeholder="Enter name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email ?? '') }}" placeholder="Enter email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">{{ isset($user) ? 'New Password (optional)' : 'Password' }}</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label
                                class="form-label">{{ isset($user) ? 'Confirm New Password' : 'Confirm Password' }}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm password">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Photo --}}
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" id="photoInput">
                            @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            @if (isset($user) && $user->photo)
                                <div class="mt-2">
                                    <label class="form-label d-block">Current Photo:</label>
                                    <img src="{{ asset($user->photo) }}" class="border p-1" width="100"
                                        alt="User Photo">
                                </div>
                            @endif

                            <div class="mt-2" id="newPhotoPreview" style="display:none;">
                                <label class="form-label d-block">New Photo Preview:</label>
                                <img id="previewImage" class="border p-1" width="100" alt="Preview">
                            </div>
                        </div>
                        {{-- assign role --}}
                        @if (isset($roles) && $roles->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">Assign Role</label>
                                <select name="roles[]" class="form-select select2" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button class="btn btn-success mb-2">{{ isset($user) ? 'Update' : 'Create' }}</button>
                            @if (isset($user))
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- User List --}}
        <div class="col-lg-7 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <label class="form-label fw-bold mb-0">User List</label>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table id="usersTable" class="table table-striped table-hover align-middle text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 42px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAllUsers">
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th style="min-width: 130px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data populated by DataTables --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview Image
        document.getElementById('photoInput').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('newPhotoPreview');
            const previewImage = document.getElementById('previewImage');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });

        // DataTable Init
        $(function() {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ordering: false,
                paging: false,
                lengthChange: false,
                info: false,

                ajax: '{{ route('user.index') }}',
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
