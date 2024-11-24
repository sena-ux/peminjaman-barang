<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class ImportDataSiswa implements ToModel, WithHeadingRow, WithProgressBar
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kelas = Kelas::firstOrCreate(
            ['name' => $row['kelas']],
            [
                'name' => $row['kelas'],
                'description' => "Kelas di tahun pelajaran " . now()->format('Y'),
                'tahun_ajar' => now()->format('Y')
            ]
        );

        $user = User::firstOrCreate([
            "username"=> $row["username"],
            "email"=> $row["email"],
            "password"=> bcrypt($row["password"]),
        ]);

        $siswa = Siswa::firstOrCreate([
            'user_id' => $user->id,
            'name' =>  $row['name'],
            'nisn' =>  $row['nisn'],
            'nis' =>  $row['nis'],
            'no_hp' =>  $row['nohp'],
            'kelas_id'=> $kelas->id,
        ]);

        return $user->assignRole('siswa');
    }
}
