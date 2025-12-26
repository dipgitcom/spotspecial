@extends('backend.master')

@section('title', 'Category')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="mb-5">
                <h3 class="mb-0 "> Category</h3>

            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-7 col-12">
            <div class="card mb-4">
                <!-- card body -->
                <div class="card">
                    <div class="card-header d-md-flex border-bottom-0">
                        <div class="flex-grow-1">
                            <a href="" class="text-bolder"><label class="form-label">Category
                                    List</label></a>
                        </div>
                        {{-- <div class="mt-3 mt-md-0">
                            <a href="#!" class="btn btn-outline-white ms-2">Excel</a>
                            <a href="#!" class="btn btn-outline-white ms-2">Import</a>
                            <a href="#!" class="btn btn-outline-white ms-2">Export</a>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                                {{-- table   --}}
                                <div class="row dt-row">
                                    <div class="col-sm-12">
                                        <table id="categoryTable"
                                            class="table table-striped table-hover align-middle text-nowrap table-centered mt-0 dataTable no-footer dtr-inline"
                                            style="width: 100%;" role="grid" aria-describedby="example_info">

                                            <thead class="table-light">
                                                <tr role="row">
                                                    <th class="pe-0 sorting_asc" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 42px;"
                                                        aria-sort="ascending"
                                                        aria-label="
															: activate to sort column descending">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th>#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 192px;"
                                                        aria-label="Category: activate to sort column ascending">Category
                                                        Name
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 109px;"
                                                        aria-label="Quantity: activate to sort column ascending">Category
                                                        Image
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 109px;"
                                                        aria-label="Quantity: activate to sort column ascending">Slug
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 107px;"
                                                        aria-label="Status: activate to sort column ascending">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 173px;"
                                                        aria-label="Action: activate to sort column ascending">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- category form  --}}

        <div class="col-lg-5 col-12">
            <form action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}"
                enctype = "multipart/form-data" method="post">
                <div class="card shadow-sm mb-2">
                    <div class="card-header  text-white text-center">
                        <h5 class="mb-0">
                            @if (isset($category))
                                <i class="bi bi-pencil-square me-2"></i> Edit Category
                            @else
                                <i class="bi bi-plus-circle me-2"></i> Add Category
                            @endif
                        </h5>
                    </div>
                </div>
                @if (isset($category))
                    @method('PUT')
                @endif
                @csrf
                <div class="card mb-4">
                    <div class="card-body">

                        {{-- Category Title --}}
                        <div class="mb-3">
                            <label class="form-label">Category Title</label>
                            <input type="text" name="category_title"
                                value="{{ old('category_title', $category->name ?? '') }}" class="form-control"
                                placeholder="Enter Category Title">
                            @error('category_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Category Image Upload --}}
                        <div class="mb-4">
                            <h5 class="mb-1">Product Category Image <span class="text-muted">(Optional)</span></h5>
                            <input type="file" name="category_image" class="form-control" id="categoryImageInput"
                                onchange="previewImage(event)">
                            @error('category_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            {{-- Image Preview --}}
                            <div class="mt-3">
                                <img id="imagePreview"
                                    src="{{ isset($category) && $category->image ? asset($category->image) : '' }}"
                                    alt="Image Preview" class="img-thumbnail"
                                    style="display: {{ isset($category) && $category->image ? 'block' : 'none' }}; max-width: 200px;">
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid">
                            @if (isset($category))
                                <button class="btn btn-success mb-4">Update</button>
                                <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
                            @else
                                <button class="btn btn-success mb-4">Create</button>
                            @endif
                        </div>

                    </div>
                </div>
                <!-- button -->

            </form>
        </div>
        {{-- category form  --}}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $table = $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                language: {
                    searchPlaceholder: "Search data...",
                    search: "",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    },
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No records available",
                    lengthMenu: "Show _MENU_ entries per page",
                    processing: "Loading..."

                },
                ordering: false,
                paging: true,
                lengthChange: true,
                info: true,

                ajax: {
                    url: "{{ route('category.index') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'category_title',
                        name: 'category_title'
                    },
                    {
                        data: 'category_image',
                        name: 'category_image'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>
    <script>
        $(document).on('change', '.status-toggle', function() {
            var url = $(this).data('url');
            var status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == true) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                    }
                    $table.ajax.reload(null, false);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to update status. Please try again.'
                    });
                }

            });
        });
    </script>
@endpush
