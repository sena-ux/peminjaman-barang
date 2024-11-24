<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Siswa::with(['siswa', 'kelas'])->select("user.username", "user.email", "user.password","name","nisn", "nis", "no_hp", "kelas")->get();
    }

    public function headings(): array
    {
        return ["Username", "Email", "Password", "Name", "NISN", "NIS", "NO HP", "Kelas"];
    }
}
