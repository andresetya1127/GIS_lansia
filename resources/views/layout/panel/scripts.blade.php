@vite(['resources/js/app.js'])

<!-- CoreUI and necessary plugins-->
<script src="{{ asset('dist') }}/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
<script src="{{ asset('dist') }}/vendors/simplebar/js/simplebar.min.js"></script>
<script>
    const header = document.querySelector('header.header');

    document.addEventListener('scroll', () => {
        if (header) {
            header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
    });
</script>
<!-- Plugins and scripts required by this view-->
<script src="{{ asset('dist') }}/vendors/@coreui/utils/js/index.js"></script>
{{-- <script src="{{ asset('dist') }}/js/main.js"></script> --}}
