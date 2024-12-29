<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Lokal Cimenyan',
            'username' => 'admincimenyan',
            'email' => 'admincimenyan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Admincimenyan2025!'),
            'role' => 'adminLokal',
            'kd_lokal' => 'P0001',
            'kd_penduduk' => 4,
            'remember_token' => Str::random(10),
        ]);
    }
}
