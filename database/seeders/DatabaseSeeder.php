<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 👑 Admin par défaut
        User::firstOrCreate(
            ['email' => 'admin@hopetrack.com'],
            [
                'name'     => 'Administrateur',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // 👷 Employé de test
        User::firstOrCreate(
            ['email' => 'employe@hopetrack.com'],
            [
                'name'     => 'Employé Test',
                'password' => Hash::make('password'),
                'role'     => 'employe',
            ]
        );
    }
}
