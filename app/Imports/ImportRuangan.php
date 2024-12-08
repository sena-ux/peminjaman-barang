<?php

namespace App\Imports;

use App\Models\Ruangan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ImportRuangan implements ToModel, WithBatchInserts, WithHeadingRow, WithSkipDuplicates, WithUpserts, WithValidation
{
    public $successCount = 0;
    public $errorCount = 0;
    public $errors = [];

    public function model(array $row)
    {
        try {
            $ruangan = Ruangan::updateOrCreate(
                ['nama_ruangan' => $row['nama_ruangan']],
                ['nama_ruangan' => $row['nama_ruangan'], 'lokasi' => $row['lokasi'], 'id_kelas' => null, 'kode_ruangan' => $this->generateKode()]
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
        return 'nama_ruangan';
    }

    public function rules(): array
    {
        return [
            '*.nama_ruangan' => 'required|string',
            '*.lokasi' => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nama_ruangan.required' => 'Nama Ruangan wajib diisi.',
            '*.lokasi.required' => 'Lokasi wajib diisi.'
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