<ul class="header-nav ms-auto">
    <li class="nav-item dropdown"><a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button"
            aria-haspopup="true" aria-expanded="false">
            <svg class="icon icon-lg my-1 mx-2">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
            </svg>
            <span
                class="position-absolute top-0 end-0 bg-danger rounded-circle badge">{{ $notifications->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg pt-0" style="">
            <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2"
                data-coreui-i18n="notificationsCounter, { 'counter': 5 }">You have {{ $notifications->count() }}
                notifications</div>
            @foreach ($notifications as $notif)
                <a @class(['dropdown-item', 'fw-semibold' => $notif->read_at == null]) href="javascript:void(0);"
                    wire:click="markAsRead('{{ $notif->id }}')">
                    <i class="{{ $notif->data['icon'] }}"></i>
                    <span><b class="fw-semibold text-capitalize text-info">{{ $notif->data['name'] }}</b> -
                        {{ $notif->data['title'] }}</span>
                </a>
            @endforeach

            <div class="dropdown-divider"></div>

            <a class="dropdown-item text-center" href="#">
                <strong>Lihat Semua</strong>
                <svg class="icon ms-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-right"></use>
                </svg>
            </a>
        </div>
    </li>
</ul>
