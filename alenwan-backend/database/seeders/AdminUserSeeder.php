<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('email', 'admin@alenwan.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@alenwan.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@alenwan.com');
            $this->command->info('Password: admin123');
            $this->command->warn('Please change the admin password after first login!');
        } else {
            $this->command->warn('Admin user already exists. Skipping...');
        }
    }
}
