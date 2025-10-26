<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Action', 'slug' => 'action', 'icon' => 'fa-bolt', 'color' => '#ef4444'],
            ['name' => 'Comedy', 'slug' => 'comedy', 'icon' => 'fa-laugh', 'color' => '#f59e0b'],
            ['name' => 'Drama', 'slug' => 'drama', 'icon' => 'fa-masks-theater', 'color' => '#8b5cf6'],
            ['name' => 'Horror', 'slug' => 'horror', 'icon' => 'fa-ghost', 'color' => '#000000'],
            ['name' => 'Sci-Fi', 'slug' => 'sci-fi', 'icon' => 'fa-rocket', 'color' => '#3b82f6'],
            ['name' => 'Romance', 'slug' => 'romance', 'icon' => 'fa-heart', 'color' => '#ec4899'],
            ['name' => 'Thriller', 'slug' => 'thriller', 'icon' => 'fa-user-secret', 'color' => '#64748b'],
            ['name' => 'Documentary', 'slug' => 'documentary', 'icon' => 'fa-film', 'color' => '#10b981'],
            ['name' => 'Animation', 'slug' => 'animation', 'icon' => 'fa-wand-magic-sparkles', 'color' => '#a855f7'],
            ['name' => 'Sports', 'slug' => 'sports', 'icon' => 'fa-futbol', 'color' => '#06b6d4'],
            ['name' => 'Family', 'slug' => 'family', 'icon' => 'fa-people-roof', 'color' => '#14b8a6'],
            ['name' => 'Adventure', 'slug' => 'adventure', 'icon' => 'fa-mountain', 'color' => '#f97316'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                    'color' => $category['color'],
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
