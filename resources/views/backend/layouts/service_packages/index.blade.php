@extends('backend.master')
@section('title', 'Service Packages Management')

@section('content')
<div class="container py-4">
    <!-- Section Title + Subtitle Edit -->
    <div class="row mb-4">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Edit Section Title & Subtitle</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('service-package-section.update') }}">
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
    </div>
    <!-- Add + List Packages -->
    <div class="row">
        <!-- Create Form -->
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Add New Service Package</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.service-packages.store') }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Title</label>
                            <input name="title" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Price</label>
                            <input name="price" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Subtitle</label>
                            <textarea name="subtitle" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Type</label>
                            <input name="type" class="form-control" placeholder="e.g. start, design, bath">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Button Text</label>
                            <input name="button_text" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Button URL</label>
                            <input name="button_url" class="form-control" value="#kontakt">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Features</label>
                            <div id="features-list"><input name="features[]" class="form-control mb-1" required></div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFeature()">+ Add Feature</button>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Save Package</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Packages List -->
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">All Service Packages</h5>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($packages as $package)
                            <tr>
                                <td>{{ $package->title }}</td>
                                <td>{{ $package->price }}</td>
                                <td>{{ $package->type }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-id="{{ $package->id }}" onclick="openEditModal(this)">Edit</button>
                                    <form action="{{ route('admin.service-packages.destroy', $package) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
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

    <!-- Edit Package Modal -->
    <div class="modal fade" id="editPackageModal" tabindex="-1" aria-labelledby="editPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editPackageForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPackageModalLabel">Edit Service Package</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editPackageId">
                        <div class="mb-2">
                            <label class="form-label">Title</label>
                            <input name="title" id="editTitle" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Price</label>
                            <input name="price" id="editPrice" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Subtitle</label>
                            <textarea name="subtitle" id="editSubtitle" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Type</label>
                            <input name="type" id="editType" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Button Text</label>
                            <input name="button_text" id="editButtonText" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Button URL</label>
                            <input name="button_url" id="editButtonUrl" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Features</label>
                            <div id="editFeaturesList"></div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="addEditFeature()">+ Add Feature</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Package</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function addFeature() {
    document.getElementById('features-list').innerHTML += '<input name="features[]" class="form-control mb-1">';
}
function addEditFeature(value = '') {
    const container = document.getElementById('editFeaturesList');
    const input = document.createElement('input');
    input.name = 'features[]';
    input.className = 'form-control mb-1';
    input.value = value;
    container.appendChild(input);
}
function openEditModal(button) {
    const tr = button.closest('tr');
    const id = button.getAttribute('data-id');
    document.getElementById('editPackageId').value = id;
    document.getElementById('editTitle').value = tr.children[0].innerText.trim();
    document.getElementById('editPrice').value = tr.children[1].innerText.trim();
    document.getElementById('editType').value = tr.children[2].innerText.trim();
    const featuresList = document.getElementById('editFeaturesList');
    featuresList.innerHTML = '';
    addEditFeature();
    const form = document.getElementById('editPackageForm');
    form.action = `/admin/service-packages/${id}`;
    const modal = new bootstrap.Modal(document.getElementById('editPackageModal'));
    modal.show();
}
</script>
@endsection
