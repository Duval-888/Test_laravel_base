<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name'        => 'Premier Message',
                'description' => 'Publié votre premier message',
                'icon'        => '🎯',
                'criteria'    => 'first_post',
            ],
            [
                'name'        => 'Création Productive',
                'description' => 'Publié 10 messages',
                'icon'        => '📝',
                'criteria'    => '10_posts',
            ],
            [
                'name'        => 'Contributeur Actif',
                'description' => 'Publié 50 messages',
                'icon'        => '⚡',
                'criteria'    => '50_posts',
            ],
            [
                'name'        => 'Expert du Forum',
                'description' => 'Publié 100 messages',
                'icon'        => '🏆',
                'criteria'    => '100_posts',
            ],
            [
                'name'        => 'Membre Utile',
                'description' => 'Vos réponses ont été bien notées',
                'icon'        => '🛡️',
                'criteria'    => 'helpful_member',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}