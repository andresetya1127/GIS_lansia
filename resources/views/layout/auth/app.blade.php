@include('layout.auth.styles')

<body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            @yield('content')
        </div>
    </div>
    @include('layout.auth.scripts')

</body>

</html>
