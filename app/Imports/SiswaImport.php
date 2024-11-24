<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class SiswaImport implements ToModel, WithHeadingRow, WithProgressBar
{
    use Importable;
    protected $userId;
    protected $kelasId;

    public function __construct($userId, $kelasId)
    {
        $this->userId = $userId;
        $this->kelasId = $kelasId;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Siswa([
            'user_id' => $this->userId,
            'name' =>  $row['name'],
            'nisn' =>  $row['nisn'],
            'nis' =>  $row['nis'],
            'no_hp' =>  $row['nohp'],
            'kelas_id'=> $this->kelasId,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'nisn' => 'required|min:10|max:11',
            'nis' => 'required|min:4',
            'no_hp' => 'required|min:9'
        ];
    }
}
