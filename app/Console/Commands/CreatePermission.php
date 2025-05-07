<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat izin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = $this->ask('Nama izin ?', 'show users');
            $guard = $this->ask('Nama penjaga ?.', 'web');
            $group = $this->ask('group?');

            $permission = Permission::create([
                'name' => $name,
                'guard' => $guard,
                'group_name' => $group,
            ]);

            $permission->assignRole('admin');
            $this->info('Izin berhasil disimpan.');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }
}
