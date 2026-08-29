<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun admin (skip jika sudah ada, misal sudah dibuat manual sebelumnya)
        User::firstOrCreate(
            ['email' => 'admin@pengaduan.id'],
            [
                'name' => 'Admin',
                'password' => bcrypt('123456'),
                'role' => User::ROLE_ADMIN,
            ]
        );

        // Contoh akun petugas
        User::firstOrCreate(
            ['email' => 'petugas@pengaduan.id'],
            [
                'name' => 'Petugas',
                'password' => bcrypt('123456'),
                'role' => User::ROLE_PETUGAS,
            ]
        );

        // Contoh akun customer
        User::firstOrCreate(
            ['email' => 'customer@pengaduan.id'],
            [
                'name' => 'Customer',
                'password' => bcrypt('123456'),
                'role' => User::ROLE_CUSTOMER,
            ]
        );
    }
}
