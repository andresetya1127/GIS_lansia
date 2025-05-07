<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Styles -->
    @include('layout.panel.styles')
    @yield('styles')
</head>

<body>
    @include('sweetalert::alert')

    @include('layout.panel.loader')

    <!-- Sidebar -->
    @include('layout.panel.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">
        <!-- Navbar -->
        @include('layout.panel.navbar')
        <div class="body flex-grow-1">
            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer px-4">
            <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">GIS Lansia</a></div>
        </footer>
    </div>

    <!-- Scripts -->
    @include('layout.panel.scripts')
    @yield('scripts')
</body>

</html>
