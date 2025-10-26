<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'flag_path' => '/flags/en.svg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arabic',
                'code' => 'ar',
                'flag_path' => '/flags/ar.svg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'French',
                'code' => 'fr',
                'flag_path' => '/flags/fr.svg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spanish',
                'code' => 'es',
                'flag_path' => '/flags/es.svg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }

        $this->command->info('Languages seeded successfully!');
    }
}
