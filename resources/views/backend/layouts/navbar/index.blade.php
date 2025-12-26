@extends('backend.master')

@section('title', 'Navbar Management')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Navbar Settings Card -->
        <div class="col-lg-6">
            <div class="card mb-4 shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Navbar Management</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form action="{{ route('admin.navbar.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            @if($navbarSetting && $navbarSetting->logo)
                                <img src="{{ asset('storage/' . $navbarSetting->logo) }}" style="height: 60px;" class="mt-2" alt="Logo">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Site Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $navbarSetting->name ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $navbarSetting->phone ?? '') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Navbar Settings</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Items Card -->
        <div class="col-lg-6">
            <div class="card mb-4 shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Navigation Items</h5>
                    <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#addNavItemModal">
                        + Add Nav Item
                    </button>
                </div>
                <div class="card-body p-0">
                    @if($navItems->count())
                        <ul class="list-group list-group-flush">
                            @foreach($navItems as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->title }}</strong> <span class="text-secondary">({{ $item->url }})</span>
                                        @if(!$item->is_active)
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        @endif
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary editNavItemBtn"
                                            data-id="{{ $item->id }}"
                                            data-title="{{ $item->title }}"
                                            data-url="{{ $item->url }}"
                                            data-order="{{ $item->order }}"
                                            data-active="{{ $item->is_active }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.navbar.navItemDelete', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-3">No navigation items found. Add your first!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Changes Section -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Recent Changes</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @if($recentNavbarSetting)
                            <li class="list-group-item">
                                <strong>Navbar Updated:</strong> {{ $recentNavbarSetting->updated_at->diffForHumans() }}
                            </li>
                        @endif
                        @foreach($recentNavItems as $nav)
                            <li class="list-group-item">
                                <strong>{{ $nav->title }}</strong>
                                ({{ $nav->url }})
                                @if($nav->created_at == $nav->updated_at)
                                    <span class="badge bg-success">Added</span>
                                @else
                                    <span class="badge bg-warning">Updated</span>
                                @endif
                                <small class="text-muted">{{ $nav->updated_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Nav Item Modal -->
<div class="modal fade" id="addNavItemModal" tabindex="-1" aria-labelledby="addNavItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.navbar.navItemStore') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addNavItemModalLabel">Add Navigation Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" name="url" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <div class="mb-3">
                    <label class="form-label">Active</label>
                    <select name="is_active" class="form-select">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Item</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Nav Item Modal -->
<div class="modal fade" id="editNavItemModal" tabindex="-1" aria-labelledby="editNavItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" class="modal-content" id="editNavItemForm">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editNavItemModalLabel">Edit Navigation Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="editNavItemId">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="editTitle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" name="url" id="editUrl" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" id="editOrder" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Active</label>
                    <select name="is_active" id="editIsActive" class="form-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Item</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.editNavItemBtn');
        const editForm = document.getElementById('editNavItemForm');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const url = this.getAttribute('data-url');
                const order = this.getAttribute('data-order');
                const isActive = this.getAttribute('data-active');

                document.getElementById('editNavItemId').value = id;
                document.getElementById('editTitle').value = title;
                document.getElementById('editUrl').value = url;
                document.getElementById('editOrder').value = order;
                document.getElementById('editIsActive').value = isActive;

                editForm.action = `/admin/navbar/nav-items/${id}`;

                const editModal = new bootstrap.Modal(document.getElementById('editNavItemModal'));
                editModal.show();
            });
        });
    });
</script>
@endpush
