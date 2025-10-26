<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');

        // Seed in proper order to maintain referential integrity

        // 1. Core data - Languages and Categories
        $this->command->info('Seeding languages...');
        $this->call(LanguageSeeder::class);

        $this->command->info('Seeding categories...');
        $this->call(CategorySeeder::class);

        // 2. Subscription plans
        $this->command->info('Seeding subscription plans...');
        $this->call(SubscriptionPlanSeeder::class);

        // 3. Admin user
        $this->command->info('Seeding admin user...');
        $this->call(AdminUserSeeder::class);

        // 4. Sample content
        $this->command->info('Seeding sample movies...');
        $this->call(SampleMoviesSeeder::class);

        $this->command->info('Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('==============================================');
        $this->command->info('Admin Credentials:');
        $this->command->info('Email: admin@alenwan.com');
        $this->command->info('Password: admin123');
        $this->command->info('==============================================');
        $this->command->warn('Please change the admin password after first login!');
    }
}
