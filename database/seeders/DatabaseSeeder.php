<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un admin de test
        \App\Models\User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@forum.com',
            'role'     => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Créer des utilisateurs de test
        \App\Models\User::create([
            'name'     => 'Utilisateur Test',
            'email'    => 'user@forum.com',
            'role'     => 'user',
            'password' => Hash::make('password'),
        ]);
 
        //creer un moderateur de test
        \App\Models\User::create([
    'name'     => 'Modérateur Test',
    'email'    => 'moderator@forum.com',
    'role'     => 'moderator',
    'password' => Hash::make('password'),
]);

        $this->call([
            CategorySeeder::class,
            BadgeSeeder::class,
        ]);
    }
}