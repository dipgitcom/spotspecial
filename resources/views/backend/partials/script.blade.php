 <!-- Libs JS -->

 <script src="{{ asset('backend') }}/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 <script src="{{ asset('backend') }}/assets/libs/feather-icons/dist/feather.min.js"></script>
 <script src="{{ asset('backend') }}/assets/libs/simplebar/dist/simplebar.min.js"></script>

 <!-- Theme JS -->
 <script src="{{ asset('backend') }}/assets/js/theme.min.js"></script>
 <script src="{{ asset('backend') }}/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
 <!-- jQuery + DataTables CDN -->

 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 {{-- sweet alerrt  --}}
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <!-- Select2 JS -->
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 {{-- select 2  --}}
 <script>
     $(document).ready(function() {
         $('.select2').select2({
             placeholder: "Select an option",
             allowClear: true
         });
     });
 </script>
 <script>
     $(document).on('click', '.btn-delete', function(e) {
         e.preventDefault()
         const url = $(this).data('url')
         Swal.fire({
             title: "Are you sure?",
             text: "You won't be able to revert this!",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#3085d6",
             cancelButtonColor: "#d33",
             confirmButtonText: "Yes, delete it!"
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = url
             }
         });
     })
 </script>

 <script>
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

     @if (session('success'))
         Toast.fire({
             icon: "success",
             title: "{{ session('success') }}"
         })
     @endif


     @if (session('error'))
         Toast.fire({
             icon: "error",
             title: "{{ session('error') }}"
         })
     @endif
 </script>
