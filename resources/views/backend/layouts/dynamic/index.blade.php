@extends('backend.master')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('title', 'Dynamic Pages')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="mb-5">
                <h3 class="mb-0">Dynamic Pages</h3>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-7 col-12">
            <div class="card mb-4">
                <div class="card">
                    <div class="card-header d-md-flex border-bottom-0">
                        <div class="flex-grow-1">
                            <a href="" class="text-bolder"><label class="form-label">Dynamic Pages List</label></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row dt-row">
                                    <div class="col-sm-12">
                                        <table id="dynamicPagesTable"
                                            class="table table-striped table-hover align-middle text-nowrap table-centered mt-0 dataTable no-footer dtr-inline"
                                            style="width: 100%;" role="grid" aria-describedby="example_info">
                                            <thead class="table-light">
                                                <tr role="row">
                                                    <th class="pe-0 sorting_asc" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 42px;"
                                                        aria-sort="ascending"
                                                        aria-label=": activate to sort column descending">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th>#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 200px;"
                                                        aria-label="Title: activate to sort column ascending">Title
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 150px;"
                                                        aria-label="Slug: activate to sort column ascending">Slug
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 250px;"
                                                        aria-label="Content: activate to sort column ascending">Content
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 100px;"
                                                        aria-label="Status: activate to sort column ascending">Status
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 180px;"
                                                        aria-label="Action: activate to sort column ascending">Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- DataTables will populate --}}
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

        {{-- Dynamic Pages Form --}}
        <div class="col-lg-5 col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center gap-2 justify-content-center">
                    <i class="bi bi-plus-circle"></i>
                    <h5 class="mb-0">
                        {{ isset($dynamicPage) ? 'Edit Dynamic Page' : 'Add New Dynamic Page' }}
                    </h5>
                </div>

                <div class="card-body">
                    <form
                        action="{{ isset($dynamicPage) ? route('dynamic-pages.update', $dynamicPage->id) : route('dynamic-pages.store') }}"
                        method="POST">
                        @csrf
                        @isset($dynamicPage)
                            @method('PUT')
                        @endisset

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $dynamicPage->title ?? '') }}"
                                placeholder="Enter title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{--
                        <div class="mb-3">
                            <label for="slug" class="form-label">
                                Slug <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('slug') is-invalid @enderror"
                                id="slug"
                                name="slug"
                                value="{{ old('slug', $dynamicPage->slug ?? '') }}"
                                placeholder="Enter slug"
                                required
                            >
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        --}}

                        <div class="mb-3">
                            <label for="content" class="form-label">Dynamic Page Content</label>
                            <textarea class="form-control summernote @error('content') is-invalid @enderror" name="content" id="content"
                                rows="5">{{ old('content', $dynamicPage->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @isset($dynamicPage)
                            <button type="submit" class="btn btn-primary w-100">Update</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary w-100 mt-2">Back</a>
                        @else
                            <button type="submit" class="btn btn-primary w-100">Create</button>
                        @endisset
                    </form>
                </div>
            </div>
        </div>

        {{-- End form --}}
    @endsection

    @push('scripts')
        {{-- // summernote js  --}}
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#dynamicPagesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,

                    language: {
                        searchPlaceholder: "Search pages...",
                        search: "",
                        paginate: {
                            previous: "Previous",
                            next: "Next"
                        },
                        info: "Showing _START_ to _END_ of _TOTAL_ pages",
                        infoEmpty: "No pages available",
                        lengthMenu: "Show _MENU_ pages per page",
                        processing: "Loading..."
                    },

                    ordering: false,
                    paging: true,
                    lengthChange: true,
                    info: true,

                    ajax: {
                        url: "{{ route('dynamic-pages.index') }}",
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
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'slug',
                            name: 'slug'
                        },
                        {
                            data: 'content',
                            name: 'content',
                            render: function(data, type, row) {
                                // Limit content to 50 chars with ellipsis
                                return data.length > 50 ? data.substr(0, 50) + '...' : data;
                            }
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



        {{-- // summernote initial  --}}
        <script>
            $(document).ready(function() {
                $('.summernote').summernote({
                    height: 200
                });
            });
        </script>
    @endpush
