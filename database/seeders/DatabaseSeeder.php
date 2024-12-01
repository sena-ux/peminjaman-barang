<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'siswa']);
        Role::create(['name' => 'staf']);
        Role::create(['name' => 'petugas']);
        Role::create(['name' => 'gurpeg']);

        $superadmin = User::create([
            "username"=> "Super Admin",
            "email"=> "superadmin@gmail.com",
            "password"=> bcrypt("superadmin"),
            "role" => "Super Admin"
        ]);

        $superadmin->assignRole("superadmin");


    }
}
