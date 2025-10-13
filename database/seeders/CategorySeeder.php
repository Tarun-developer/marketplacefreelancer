<?php

namespace Database\Seeders;

use App\Modules\Products\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'WordPress Themes',
                'slug' => 'wordpress-themes',
                'description' => 'Professional WordPress themes and templates',
                'icon' => 'bi-wordpress',
                'is_active' => true,
            ],
            [
                'name' => 'PHP Scripts',
                'slug' => 'php-scripts',
                'description' => 'PHP scripts and applications',
                'icon' => 'bi-code-slash',
                'is_active' => true,
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                'description' => 'JavaScript libraries and frameworks',
                'icon' => 'bi-braces',
                'is_active' => true,
            ],
            [
                'name' => 'Mobile Apps',
                'slug' => 'mobile-apps',
                'description' => 'Mobile applications and templates',
                'icon' => 'bi-phone',
                'is_active' => true,
            ],
            [
                'name' => 'Graphics & Design',
                'slug' => 'graphics-design',
                'description' => 'Graphics, logos, and design assets',
                'icon' => 'bi-palette',
                'is_active' => true,
            ],
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'description' => 'Laravel packages and scripts',
                'icon' => 'bi-bootstrap',
                'is_active' => true,
            ],
            [
                'name' => 'React',
                'slug' => 'react',
                'description' => 'React components and applications',
                'icon' => 'bi-lightning',
                'is_active' => true,
            ],
            [
                'name' => 'Vue.js',
                'slug' => 'vuejs',
                'description' => 'Vue.js components and applications',
                'icon' => 'bi-circle',
                'is_active' => true,
            ],
            [
                'name' => 'HTML Templates',
                'slug' => 'html-templates',
                'description' => 'HTML5 templates and themes',
                'icon' => 'bi-file-earmark-code',
                'is_active' => true,
            ],
            [
                'name' => 'CSS Templates',
                'slug' => 'css-templates',
                'description' => 'CSS frameworks and templates',
                'icon' => 'bi-palette2',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}