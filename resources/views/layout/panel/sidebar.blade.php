@php
    $menus = collect(config('menus'));
@endphp


<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg>
            <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#signet"></use>
            </svg>
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

                <li class="nav-item">
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
