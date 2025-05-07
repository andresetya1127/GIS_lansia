<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = $this->ask('What is your name?', 'Admin');
            $email = $this->ask('What is your  email?.', 'admin@example.com');
            $password = $this->ask('What is your password?');
            $role = $this->choice('What is your role?', ['admin', 'petugas']);

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            $user->assignRole($role);
            $this->info('User created successfully.');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }
}
