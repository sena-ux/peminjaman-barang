<?php

namespace Database\Seeders;

use App\Models\Amount;
use App\Models\Barang;
use App\Models\Category;
use App\Models\InventoryBarang;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ["name" => "Alat Lab Bahasa"],
            ["name" => "Alat Lab Bahasa", "deskripsi" => "Mencangkup semua barang di lab bahasa"],
        );

        $amount = Amount::create([
            'total' => 10,
            'tersedia' => 5,
            'rusak' => 5,
        ]);

        $barang = Barang::firstOrCreate(
            ['nama_barang' => 'Komputer'],
            [
                'nama_barang' => 'Komputer',
                'deskripsi' => 'Komputer lab bahasa',
                'id_category' => $category->id,
                'id_amount' => $amount->id,
            ],
        );

        $ruangan = Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab Bahasa'],
            ['nama_ruangan' => 'Lab Bahasa', 'lokasi' => 'Lab Bahasa SMAN 2 Amlapura'],
        );

        for ($i = 1; $i <= intval($amount->tersedia); $i++) {
            $inventory = InventoryBarang::create([
                'status_barang' => 'tersedia',
                'id_barang' => $barang->id,
                'id_ruangan' => $ruangan->id,
                'kode_barang' => $this->generateKodeBarang()
            ]);
        }
        for ($i = 1; $i <= intval($amount->rusak); $i++) {
            $inventory = InventoryBarang::create([
                'status_barang' => 'tersedia',
                'id_barang' => $barang->id,
                'id_ruangan' => $ruangan->id,
                'kode_barang' => $this->generateKodeBarang()
            ]);
        }


    }

    private function generateKodeBarang()
    {
        $prefix = 'BRG';
        $date = Carbon::now()->format('Ymd');

        do {
            // Generate random number dengan 6 digit
            $randomNumber = random_int(100000, 999999);

            // Gabungkan menjadi kode barang lengkap
            $kodeBarang = $prefix . '-' . $date . '-' . $randomNumber;

            // Cek apakah kode barang sudah ada di database
            $exists = InventoryBarang::where('kode_barang', $kodeBarang)->exists();
        } while ($exists);

        return $kodeBarang;
    }
}
