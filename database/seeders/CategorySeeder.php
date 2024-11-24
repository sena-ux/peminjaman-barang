<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        return Category::firstOrCreate(
            ["name" => "Alat Lab Bahasa"],
            ["name"=> "Alat Lab Bahasa", "deskripsi"=> "Mencangkup semua barang di lab bahasa"]
        );
    }
}
