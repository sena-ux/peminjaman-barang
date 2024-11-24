<?php

namespace App\Imports;

use App\Models\Kelas;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class KelasImport implements ToModel, WithProgressBar, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $kelasName = $row["kelas"];
        return Kelas::firstOrCreate(
            ['name' => $kelasName],
            [
                'name' => $kelasName,
                'description' => "Kelas di tahun pelajaran " . now()->format('Y'),
                'tahun_ajar' => now()->format('Y')
            ]
        );

    }
}
