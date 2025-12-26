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

        <!-- Left Column: Review Table -->
        <div class="col-lg-12 col-12">
            <div class="card mb-4">
                <div class="card">
                    <div class="card-header d-md-flex border-bottom-0">
                        <div class="flex-grow-1">
                            <a href="" class="text-bolder"><label class="form-label">Review List</label></a>
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
                                                    <th>User</th>
                                                    <th>Product</th>
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
                url: "{{ route('user.create.review') }}",
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
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'product',
                    name: 'product'
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
                url: "{{ route('review.change.user.status') }}",
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
                            title: response.message
                        });
                    }

                    $('#userReviewTable').DataTable().ajax.reload();
                }
            });
        });
    </script>
@endpush
