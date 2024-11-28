<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateImportDataBarang implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [
            ['Sapu Lidi', 'sapu lidi', 'sssdsdsdsdssdsdsd', 'Alat Kerbersihan', 'Kelas XII 2', '01-07-04', '10.000', 'Dana Bos', '', "", "", "","","","","","Ketentuan Pengsisian Kolom Kondisi:"],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","",""],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","",""],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","","Kolom Wajib diisi: "],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","","1. Nama_barang"],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","","2. Jenis = Alat Kebersihan, Elektronika, atau yang lain"],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","","3. Jika Kode_barang kosong maka aplikasi akan generate kode secara acak"],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","","4. Ruangan, misal = XII 1, Lab Bahasa, Lab Komputer"],
            ['', '', '', '', '', '', '', '', '', "", "","","", "","","","5. Tanggal Pengadaan"],
        ];
    }

    public function headings(): array
    {
        return ["Nama_barang", "harga", "sumber_dana", "foto_barang", "total_barang", "tahun_pengadaan", "deskripsi"];
    }
}
