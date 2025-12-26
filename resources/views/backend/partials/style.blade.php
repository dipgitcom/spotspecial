<!-- Favicon icon-->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset($admin_setting->favicon ?? '*') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Color modes -->
<script src="{{ asset('backend') }}/assets/js/vendors/color-modes.js"></script>

<!-- Libs CSS -->
<link href="{{ asset('backend') }}/assets/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet" />
<link href="{{ asset('backend') }}/assets/libs/%40mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />
<link href="{{ asset('backend') }}/assets/libs/simplebar/dist/simplebar.min.css" rel="stylesheet" />
{{-- Datatable css  --}}
<link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
<!-- Theme CSS -->
<link rel="stylesheet" href="{{ asset('backend') }}/assets/css/theme.min.css">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{-- main css file --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('backend') }}/assets/css/main.css">
