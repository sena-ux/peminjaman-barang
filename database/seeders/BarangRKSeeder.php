<?php

namespace Database\Seeders;

use App\Models\Ruangan\Kelas\BarangRK;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangRKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangRK::create([
            'nama_barang' => 'Proyektor',
            'foto' => 'https://i0.wp.com/blog.dimensidata.com/wp-content/uploads/2015/08/Review-Proyektor-Infokus-IN2124_2.jpg'
        ]);
        BarangRK::create([
            'nama_barang' => 'Kabel VGA',
            'foto' => 'https://th.bing.com/th/id/OIP.TPzJQ_W8LsccrU5iik-MswHaFL?rs=1&pid=ImgDetMain'
        ]);
        BarangRK::create([
            'nama_barang' => 'Kabel HDMI',
            'foto' => 'https://www.simplynuc.com/wp-content/uploads/2015/08/CABLE-mHDMI-to-HDMI.jpg'
        ]);
        BarangRK::create([
            'nama_barang' => 'Layar Proyektor',
            'foto' => 'https://d3au0sjxgpdyfv.cloudfront.net/a-80725685-281ky95rpzbh6554.jpeg'
        ]);
    }
}
