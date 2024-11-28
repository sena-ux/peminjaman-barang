<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateKelasImport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['', '', ''],
        ];
    }

    public function headings(): array
    {
        return ["Nama_kelas", "Tahun_Pelajaran", "Keterangan"];
    }
}
