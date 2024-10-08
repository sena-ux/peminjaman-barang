<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => "Sena Pernata",
            'email' => "sena@gmail.com",
            'password' => "password",
            'alamat' => "Br. Dinas Bias",
            'nisn' => "123456789",
            'nis' => "4985",
            'kelas' => "XII 1",
            'telp' => "089271743683",
            'role' => "siswa",
        ]);

        Barang::create([
            'nama_barang' => 'Laptop ASUZ'
        ]);

        Barang::create([
            'nama_barang' => 'Charger Laptop ASUZ'
        ]);
    }
}
