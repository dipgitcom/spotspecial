@extends('backend.master')

@section('title', 'User Management')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 mb-4 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">User Details</h3>
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">Back to Users</a>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Information</h5>

                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Name:</strong> {{ $user->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Email:</strong> {{ $user->email }}
                        </li>
                        <li class="list-group-item">
                            <strong>Roles:</strong>
                            @forelse ($user->roles as $role)
                                <span class="badge bg-info">{{ $role->name }}</span>
                            @empty
                                <span class="text-muted">No roles assigned</span>
                            @endforelse
                        </li>
                        <li class="list-group-item">
                            <strong>Create date :</strong> {{ $user->created_at->format('d M Y') }}
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
