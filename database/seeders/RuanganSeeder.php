<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruangan = Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab Bahasa'],
            ['nama_ruangan'=> 'Lab Bahasa', 'lokasi'=> 'Lab Bahasa SMAN 2 Amlapura'],
        );

        return $ruangan;
    }
}
