<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create an admin user for Filament';

    public function handle()
    {
        $this->info('Creating Admin User...');

        $name = $this->ask('Name', 'Admin');
        $email = $this->ask('Email', 'admin@alenwan.com');
        $password = $this->secret('Password (default: password)') ?: 'password';

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
            'is_premium' => true,
        ]);

        $this->info('Admin user created successfully!');
        $this->table(
            ['Name', 'Email', 'Is Admin'],
            [[$user->name, $user->email, 'Yes']]
        );

        return Command::SUCCESS;
    }
}
