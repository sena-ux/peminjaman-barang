<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateSiswaImport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Alex_username', 'alex@gmail.com', 'password', 'Alex lakmiartini(nama Lengkap)', '7898675676', '2345', '098876765654', 'XII 2'],
        ];
    }

    public function headings(): array
    {
        return ["Username", "Email", "Password", "Name", "NISN", "NIS", "NoHP", "Kelas"];
    }
}

