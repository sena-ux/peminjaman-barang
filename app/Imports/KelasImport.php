<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class KelasImport implements ToModel, WithProgressBar, WithHeadingRow, WithBatchInserts, WithSkipDuplicates, WithUpserts, WithValidation
{
    public $successCount = 0;
    public $errorCount = 0;
    public $errors = [];

    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $kelas = Kelas::updateOrCreate(
                ['name' => $row['nama_kelas']],
                [
                    'description' => $row['keterangan'],
                    'tahun_ajar' => $row['tahun_pelajaran'],
                ]
            );

            $ruangan = Ruangan::updateOrCreate(
                ['nama_ruangan' => $row['nama_kelas']],
                [
                    'lokasi' => $row['keterangan'],
                    'id_kelas' => $kelas->id,
                    'kode_ruangan' => $this->generateKode()
                ]
            );

            $this->successCount++;
            return $ruangan;
        } catch (\Throwable $e) {
            $this->errorCount++;
            $this->errors[] = [
                'row' => $row,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function uniqueBy()
    {
        return 'nama_kelas';
    }

    public function rules(): array
    {
        return [
            '*.nama_kelas' => 'required|string',
            '*.tahun_pelajaran' => 'required|numeric',
            '*.keterangan' => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nama_kelas.required' => 'Nama Ruangan wajib diisi.',
            '*.tahun_pelajaran.required' => 'Lokasi wajib diisi.',
            '*.tahun_pelajaran.numeric' => 'Tahun ajar harus numeric. Misalnya : 2024.',
        ];
    }

    public function onFailure(Failure $failure)
    {
        $this->errorCount++;
        $this->errors[] = [
            'row' => $failure->row(),
            'attribute' => $failure->attribute(),
            'error' => $failure->errors(),
        ];
    }

    private function generateKode()
    {
        $prefix = 'RG';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 1;

        do {
            $randomString = substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
            // $kodeBarang = $prefix . '-' . uniqid() . $randomString;
            $kode = $prefix . '-' . substr(bin2hex(random_bytes(3)), 0, 3) . $randomString;
            $exists = Ruangan::where('kode_ruangan', $kode)->exists();
        } while ($exists);

        return $kode;
    }
}
