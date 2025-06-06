<base href="{{ asset('dist') }}/./">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? 'GIS Lansia' }}</title>
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('dist') }}/assets/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('dist') }}/assets/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('dist') }}/assets/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dist') }}/assets/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('dist') }}/assets/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('dist') }}/assets/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('dist') }}/assets/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('dist') }}/assets/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('dist') }}/assets/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"
    href="{{ asset('dist') }}/assets/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('dist') }}/assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('dist') }}/assets/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('dist') }}/assets/favicon/favicon-16x16.png">
<link rel="manifest" href="{{ asset('dist') }}/assets/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<!-- ICONS-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Vendors styles-->
<link rel="stylesheet" href="{{ asset('dist') }}/vendors/simplebar/css/simplebar.css">
<link rel="stylesheet" href="{{ asset('dist') }}/css/vendors/simplebar.css">
<!-- Main styles for this application-->
<link href="{{ asset('dist') }}/css/style.css" rel="stylesheet">
<!-- We use those styles to show code examples, you should remove them in your application.-->
<link href="{{ asset('dist') }}/css/examples.css" rel="stylesheet">
<link href="{{ asset('dist') }}/vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet">

<script src="{{ asset('dist') }}/js/config.js"></script>
<script src="{{ asset('dist') }}/js/color-modes.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@vite(['resources/css/app-custom.css'])
