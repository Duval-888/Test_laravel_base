<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Général',
                'description' => 'Discussions générales et off-topic',
                'slug'        => 'general',
            ],
            [
                'name'        => 'Questions & Réponses',
                'description' => 'Posez vos questions et obtenez des réponses',
                'slug'        => 'q-a',
            ],
            [
                'name'        => 'PHP & Laravel',
                'description' => 'Discussions sur PHP et Laravel',
                'slug'        => 'php-laravel',
            ],
            [
                'name'        => 'JavaScript & Frontend',
                'description' => 'Discussions sur JavaScript, React, Vue, etc.',
                'slug'        => 'javascript-frontend',
            ],
            [
                'name'        => 'Base de Données',
                'description' => 'Discussions sur MySQL, PostgreSQL, MongoDB, etc.',
                'slug'        => 'database',
            ],
            [
                'name'        => 'Projets & Portfolios',
                'description' => 'Présentez vos projets et portfolios',
                'slug'        => 'projects',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}