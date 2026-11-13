<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin atau staff sesuai kebutuhan (contoh: admin)
        User::create([
            'name' => 'Vincent',
            'email' => 'vincent@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin', // Ubah menjadi 'staff' jika ingin role staff
        ]);
    }
}