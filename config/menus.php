<?php
return [
    [
        'name' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'fas fa-home',
        'divider' => false,
        'role' => ['admin', 'petugas'],
    ],
    [
        'name' => 'Lansia',
        'route' => 'lansia',
        'icon' => 'fa-solid fa-users-rays',
        'divider' => 'Data',
        'role' => ['admin', 'petugas'],
    ],
    [
        'name' => 'Pengguna',
        'route' => 'users',
        'icon' => 'fas fa-users',
        'divider' => 'Hak Akses',
        'role' => ['admin'],
    ],
    [
        'name' => 'Peran & Izin',
        'route' => 'role',
        'icon' => 'fa-user-shield',
        'divider' => false,
        'role' => ['admin'],
    ],
    // [
    //     'name' => 'Website',
    //     'route' => 'role',
    //     'icon' => 'fa-globe',
    //     'divider' => 'Pengaturan',
    //     'role' => ['admin'],
    // ],

];
