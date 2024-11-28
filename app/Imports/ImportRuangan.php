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
                ['nama_ruangan' => $row['nama_ruangan'], 'lokasi' => $row['lokasi'], 'id_kelas' => null]
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
}