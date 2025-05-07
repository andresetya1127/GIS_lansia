@php
    $menus = collect(config('menus'));
@endphp


<div class="sidebar sidebar-dark sidebar-fixed border-end" style="background-color: #666768" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand ">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Lambang_Kabupaten_Lombok_Tengah.gif"
                alt="Logo Lombok tengah" width="50">
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        @foreach ($menus as $menu)
            @if (auth()->user()->hasRole($menu['role']))
                <!-- Divider -->
                @if ($menu['divider'])
                    <li class="nav-title">{{ $menu['divider'] }}</li>
                    </li>
                @endif

                <li class="nav-item ">
                    <a class="nav-link" href="{{ $menu['route'] ? route($menu['route']) : '#' }}">
                        <i class="nav-icon fa-solid {{ $menu['icon'] }} me-3"></i>
                        {{ $menu['name'] }}
                    </a>
            @endif
            </li>
        @endforeach
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>
