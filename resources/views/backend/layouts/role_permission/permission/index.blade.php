@extends('backend.master')
<style>
    /* Compact table style for minimal height */
    #permissionTable {
        font-size: 0.75rem;
        /* smaller font */
        border-collapse: collapse;
        width: 100%;
    }

    #permissionTable th,
    #permissionTable td {
        padding: 4px 8px;
        /* minimal padding */
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        /* prevent wrapping */
    }

    #permissionTable th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    /* Checkbox cell narrow */
    #permissionTable td.checkbox-cell {
        width: 500px;
    }

    /* Scroll wrapper for fixed height */
    .table-scroll-wrapper {
        max-height: 400px;
        /* adjust as needed */
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>

@section('title', 'Permission Management')


@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="mb-5">
                <h3 class="mb-0 "> Permission</h3>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-12">
            <form action="{{ isset($permission) ? route('permission.update', $permission->id) : route('permission.store') }}"
                enctype="multipart/form-data" method="POST">
                @csrf
                @if (isset($permission))
                    @method('PUT')
                @endif

                <div class="card shadow-sm mb-2">
                    <div class="card-header text-white text-center">
                        <h5 class="mb-0">
                            @if (isset($permission))
                                <i class="bi bi-pencil-square me-2"></i> Edit Permission
                            @else
                                <i class="bi bi-plus-circle me-2"></i> Add Permission
                            @endif
                        </h5>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Permission Name</label>
                            <input type="text" name="permission" class="form-control" value=""
                                placeholder="Enter Permission name">
                            @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <!-- Submit -->
                        <div class="d-grid">
                            @if (isset($permission))
                                <button class="btn btn-success mb-4">Update</button>
                                <a href="{{ route('permission.index') }}" class="btn btn-secondary">Back</a>
                            @else
                                <button class="btn  btn-success mb-4">Add Permission</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Left Column: Role Table -->
        <div class="col-lg-7 col-12">



            <!-- Role Selection -->
            <div class="mb-2">
                <div class="card shadow-sm mb-2">
                    <div class="card-header text-white text-center">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i> All Permission
                        </h5>
                    </div>
                </div>


            </div>

            <!-- Scrollable permission table -->
            <div class="table-scroll-wrapper">

                <table id="permissionTable"
                    class="table table-bordered table-hover align-middle text-center small-table mb-0">

                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th class="text-start">Permission</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="text-start">{{ $permission->name }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



        </div>

    </div>

@endsection

@push('scripts')
@endpush
