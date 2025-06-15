<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = Role::create(['name' => 'admin']);
        $petugas = Role::create(['name' => 'petugas']);

        $permission = Permission::insert([
            ['name' => 'show roles', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'create roles', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'edit roles', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'delete roles', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'show dashboard', 'guard_name' => 'web', 'group_name' => 'dashboard'],
            ['name' => 'show users', 'guard_name' => 'web', 'group_name' => 'users'],
            ['name' => 'create users', 'guard_name' => 'web', 'group_name' => 'users'],
            ['name' => 'edit users', 'guard_name' => 'web', 'group_name' => 'users'],
            ['name' => 'delete users', 'guard_name' => 'web', 'group_name' => 'users'],
            ['name' => 'show lansia', 'guard_name' => 'web', 'group_name' => 'lansia'],
            ['name' => 'create lansia', 'guard_name' => 'web', 'group_name' => 'lansia'],
            ['name' => 'edit lansia', 'guard_name' => 'web', 'group_name' => 'lansia'],
            ['name' => 'delete lansia', 'guard_name' => 'web', 'group_name' => 'lansia'],
        ]);

        $admin->givePermissionTo([
            'show roles',
            'create roles',
            'edit roles',
            'delete roles',
            'show dashboard',
            'show users',
            'create users',
            'edit users',
            'delete users',
            'show lansia',
            'create lansia',
            'edit lansia',
            'delete lansia',
        ]);

        $petugas->givePermissionTo([
            'show dashboard',
            'show lansia',
            'create lansia',
            'edit lansia',
            // 'delete lansia',
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
        ]);

        $user->assignRole('admin');
    }
}
