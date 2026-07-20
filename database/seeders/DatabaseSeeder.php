<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::factory()->create([
            'name' => 'Admin Shebok',
            'email' => 'admin@shebok.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        // Default user account (can also apply as provider)
        User::factory()->create([
            'name' => 'Default User',
            'email' => 'user@shebok.com',
            'password' => bcrypt('12345678'),
            'role' => 'user',
        ]);
    }
}
