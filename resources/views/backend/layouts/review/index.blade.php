@extends('backend.master')

@section('title', 'Banner')


@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="mb-5">
                <h3 class="mb-0 "> Review</h3>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-12">
            <form action="{{ isset($review) ? route('review.update', $review->id) : route('review.store') }}"
                enctype="multipart/form-data" method="POST">
                @csrf
                @if (isset($review))
                    @method('PUT')
                @endif

                <div class="card shadow-sm mb-2">
                    <div class="card-header text-white text-center">
                        <h5 class="mb-0">
                            @if (isset($review))
                                <i class="bi bi-pencil-square me-2"></i> Edit Review
                            @else
                                <i class="bi bi-plus-circle me-2"></i> Add Review
                            @endif
                        </h5>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $review->name ?? '' }}"
                                placeholder="Enter reviewer name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Profession -->
                        <div class="mb-3">
                            <label class="form-label">Profession</label>
                            <input type="text" name="profession" class="form-control"
                                value="{{ $review->profession ?? '' }}" placeholder="Enter profession">
                            @error('profession')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Review Content -->
                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <textarea name="review_content" class="form-control" rows="4" placeholder="Write your review here...">{{ $review->review_content ?? '' }}</textarea>
                            @error('review_content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Rating -->
                        <div class="mb-3">
                            <label class="form-label">Rating (out of 5)</label>
                            <input type="number" step="0.1" min="0" max="5" name="rating_point"
                                class="form-control" value="{{ $review->rating_point ?? '' }}"
                                placeholder="Enter rating (e.g., 4.5)">
                            @error('rating_point')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Photo -->
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" id="photoInput">
                            @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            {{-- Previous Photo --}}
                            @if (isset($review) && $review->photo)
                                <div class="mt-2">
                                    <label class="form-label d-block">Previous Photo:</label>
                                    <img src="{{ asset($review->photo) }}" alt="Reviewer Photo"
                                        style="width: 100px; height: auto; border: 1px solid #ddd; padding: 2px;">
                                </div>
                            @endif

                            {{-- New Photo Preview --}}
                            <div class="mt-2" id="newPhotoPreview" style="display:none;">
                                <label class="form-label d-block">New Photo Preview:</label>
                                <img id="previewImage" src="" alt="Preview"
                                    style="width: 100px; height: auto; border: 1px solid #ddd; padding: 2px;">
                            </div>
                        </div>


                        <!-- Submit -->
                        <div class="d-grid">
                            @if (isset($review))
                                <button class="btn btn-success mb-4">Update</button>
                                <a href="{{ route('review.index') }}" class="btn btn-secondary">Back</a>
                            @else
                                <button class="btn btn-success mb-4">Create</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Left Column: Review Table -->
        <div class="col-lg-7 col-12">
            <div class="card mb-4">
                <div class="card">
                    <div class="card-header d-md-flex border-bottom-0">
                        <div class="flex-grow-1">
                            <a href="" class="text-bolder"><label class="form-label">Admin Review List</label></a>
                        </div>

                        {{-- <div class="mt-3 mt-md-0">
                            <a href="#!" class="btn btn-outline-white ms-2">Excel</a>
                            <a href="#!" class="btn btn-outline-white ms-2">Import</a>
                            <a href="#!" class="btn btn-outline-white ms-2">Export</a>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <div class="dataTables_wrapper dt-bootstrap5 no-footer">

                                <!-- Table -->
                                <div class="row dt-row">
                                    <div class="col-sm-12">
                                        <table id="userReviewTable"
                                            class="table table-striped table-hover align-middle text-nowrap table-centered mt-0 dataTable no-footer dtr-inline"
                                            style="width: 100%;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="pe-0 sorting_asc" style="width: 42px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                                        </div>
                                                    </th>
                                                    <th>#</th>
                                                    {{-- <th>User</th> --}}
                                                    <th>photo</th>
                                                    <th>Name</th>
                                                    <th>Profession</th>
                                                    <th>Review</th>
                                                    <th>Rating</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- DataTables will populate -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $('#userReviewTable').DataTable({
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
                url: "{{ route('review.index') }}",
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
                    data: 'photo',
                    name: 'photo'
                },

                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'profession',
                    name: 'profession'
                },

                {
                    data: 'review_content',
                    name: 'review_content'
                },
                {
                    data: 'rating_point',
                    name: 'rating_point'
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
                }
            ],


        });
    </script>

    {{-- status chanage --}}
    <script>
        $(document).on('click', '.change-status', function(e) {
            e.preventDefault();
            const reviewId = $(this).data('id');
            const status = $(this).data('status');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('review.changeStatus') }}",
                method: 'POST',
                data: {
                    review_id: reviewId,
                    status: status
                },

                success: function(response) {
                    if (response.success === true) {
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
                            title: response.message || "Operation successful"
                        });
                    }

                    $('#userReviewTable').DataTable().ajax.reload();
                }
            });
        });
    </script>

    <script>
        document.getElementById('photoInput').addEventListener('change', function(event) {
            let previewContainer = document.getElementById('newPhotoPreview');
            let previewImage = document.getElementById('previewImage');
            let file = event.target.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    </script>
@endpush
