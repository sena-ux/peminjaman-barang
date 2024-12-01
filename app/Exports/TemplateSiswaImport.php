<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateSiswaImport implements WithHeadings
{
    public function headings(): array
    {
        return ["Username", "Email", "Password", "Name", "NISN", "NIS", "No_hp", "Kelas", "Alamat"];
    }
}

