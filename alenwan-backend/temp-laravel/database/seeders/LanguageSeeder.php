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
                'name' => 'Arabic',
                'native_name' => 'العربية',
                'code' => 'ar',
                'flag' => '🇸🇦',
                'direction' => 'rtl',
                'is_default' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'English',
                'native_name' => 'English',
                'code' => 'en',
                'flag' => '🇺🇸',
                'direction' => 'ltr',
                'is_default' => false,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'French',
                'native_name' => 'Français',
                'code' => 'fr',
                'flag' => '🇫🇷',
                'direction' => 'ltr',
                'is_default' => false,
                'is_active' => false,
                'order' => 3,
            ],
            [
                'name' => 'German',
                'native_name' => 'Deutsch',
                'code' => 'de',
                'flag' => '🇩🇪',
                'direction' => 'ltr',
                'is_default' => false,
                'is_active' => false,
                'order' => 4,
            ],
            [
                'name' => 'Spanish',
                'native_name' => 'Español',
                'code' => 'es',
                'flag' => '🇪🇸',
                'direction' => 'ltr',
                'is_default' => false,
                'is_active' => false,
                'order' => 5,
            ],
            [
                'name' => 'Turkish',
                'native_name' => 'Türkçe',
                'code' => 'tr',
                'flag' => '🇹🇷',
                'direction' => 'ltr',
                'is_default' => false,
                'is_active' => false,
                'order' => 6,
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }

        $this->command->info('✅ تم إضافة 6 لغات بنجاح!');
        $this->command->info('✅ 6 languages seeded successfully!');
    }
}
