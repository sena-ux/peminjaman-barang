<?php

namespace App\Imports;

use App\Models\Amount;
use App\Models\Barang;
use App\Models\Category;
use App\Models\InventoryBarang;
use App\Models\Log as LogApliksi;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithValidation;
use Str;

class ImportDataBarang implements ToModel, WithBatchInserts, WithHeadingRow, WithProgressBar
{
    use Importable;

    public function batchSize(): int
    {
        return 100;
    }

    public $dataGagal;
    public $dataSukses;
    public $failedItemsString;

    public function __construct(&$dataGagal, &$dataSukses, &$failedItemsString)
    {
        $this->dataGagal = &$dataGagal;
        $this->dataSukses = &$dataSukses;
        $this->failedItemsString = &$failedItemsString;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            if($row['kode_barang']) {
                if ($row['nama_barang'] || $row['jenis'] || $row['ruangan']) {
                    if (intval($row['bagus'] + $row['rusak'] + $row['habis'] + $row['hilang'] + $row['baru'] + $row['dipinjam']) >= 1) {
                        $category = Category::firstOrCreate(
                            ["name" => $row['jenis']],
                            ["name" => $row['jenis'], "deskripsi" => $row['deskripsi']]
                        );

                        $ruangan = Ruangan::firstOrCreate(
                            ['nama_ruangan' => $row['ruangan']],
                            [
                                'nama_ruangan' => $row['ruangan'],
                                'lokasi' => $row['ruangan']
                            ],
                        );

                        $barang = Barang::updateOrCreate(
                            ['nama_barang' => $row['nama_barang']],
                            [
                                'nama_barang' => $row['nama_barang'],
                                'deskripsi' => $row['deskripsi'],
                                'harga' => $row['harga'],
                                'sumber_dana' => $row['sumber_dana'],
                                'pengadaan' => $row['tgl_pengadaan'],
                                'id_category' => $category->id,
                            ],
                        );

                        $amount = Amount::updateOrCreate(
                            ['id_barang' => $barang->id],
                            [
                                'total' => intval($row['bagus'] + $row['rusak'] + $row['habis'] + $row['hilang'] + $row['baru'] + $row['dipinjam']) ?? 0,
                                'bagus' => $row['bagus'] ?? 0,
                                'rusak' => $row['rusak'] ?? 0,
                                'habis' => $row['habis'] ?? 0,
                                'hilang' => $row['hilang'] ?? 0,
                                'baru' => $row['baru'] ?? 0,
                                'dipinjam' => $row['dipinjam'] ?? 0,
                            ]
                        );

                        $barang->update(['id_amount' => $amount->id]);

                        $this->saveInventoryByCondition($row, $barang, $ruangan, 'bagus');
                        $this->saveInventoryByCondition($row, $barang, $ruangan, 'rusak');
                        $this->saveInventoryByCondition($row, $barang, $ruangan, 'habis');
                        $this->saveInventoryByCondition($row, $barang, $ruangan, 'hilang');
                        $this->saveInventoryByCondition($row, $barang, $ruangan, 'baru');
                        $this->saveInventoryByCondition($row, $barang, $ruangan, 'dipinjam');
                        $this->dataSukses++;
                    } else {
                        $this->failedItemsString .= ($this->failedItemsString ? ', ' : '') . ($row['nama_barang'] ?? 'Barang Tidak Dikenal');
                        $this->dataGagal++;
                    }
                }
            } else {
                $barang = Barang::where('nama_barang', $row['nama_barang'])->get();
                if ($barang->isEmpty()) {
                    if ($row['nama_barang'] || $row['jenis'] || $row['ruangan']) {
                        if (intval($row['bagus'] + $row['rusak'] + $row['habis'] + $row['hilang'] + $row['baru'] + $row['dipinjam']) >= 1) {
                            $category = Category::firstOrCreate(
                                ["name" => $row['jenis']],
                                ["name" => $row['jenis'], "deskripsi" => $row['deskripsi']]
                            );
    
                            $ruangan = Ruangan::firstOrCreate(
                                ['nama_ruangan' => $row['ruangan']],
                                [
                                    'nama_ruangan' => $row['ruangan'],
                                    'lokasi' => $row['ruangan']
                                ],
                            );
    
                            $barang = Barang::updateOrCreate(
                                ['nama_barang' => $row['nama_barang']],
                                [
                                    'nama_barang' => $row['nama_barang'],
                                    'deskripsi' => $row['deskripsi'],
                                    'harga' => $row['harga'],
                                    'sumber_dana' => $row['sumber_dana'],
                                    'pengadaan' => $row['tgl_pengadaan'],
                                    'id_category' => $category->id,
                                ],
                            );
    
                            $amount = Amount::updateOrCreate(
                                ['id_barang' => $barang->id],
                                [
                                    'total' => intval($row['bagus'] + $row['rusak'] + $row['habis'] + $row['hilang'] + $row['baru'] + $row['dipinjam']) ?? 0,
                                    'bagus' => $row['bagus'] ?? 0,
                                    'rusak' => $row['rusak'] ?? 0,
                                    'habis' => $row['habis'] ?? 0,
                                    'hilang' => $row['hilang'] ?? 0,
                                    'baru' => $row['baru'] ?? 0,
                                    'dipinjam' => $row['dipinjam'] ?? 0,
                                ]
                            );
    
                            $barang->update(['id_amount' => $amount->id]);
    
                            $this->saveInventoryByCondition($row, $barang, $ruangan, 'bagus');
                            $this->saveInventoryByCondition($row, $barang, $ruangan, 'rusak');
                            $this->saveInventoryByCondition($row, $barang, $ruangan, 'habis');
                            $this->saveInventoryByCondition($row, $barang, $ruangan, 'hilang');
                            $this->saveInventoryByCondition($row, $barang, $ruangan, 'baru');
                            $this->saveInventoryByCondition($row, $barang, $ruangan, 'dipinjam');
                            $this->dataSukses++;
                        } else {
                            $this->failedItemsString .= ($this->failedItemsString ? ', ' : '') . ($row['nama_barang'] ?? 'Barang Tidak Dikenal');
                            $this->dataGagal++;
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            \Log::error("Terjadi kesalahan: " . $th->getMessage());
        }
    }

    private function generateKodeBarang()
    {
        $prefix = 'BRG';
        $date = Carbon::now()->format('Ymd');

        do {
            $randomNumber = random_int(100000, 999999);
            $kodeBarang = $prefix . '-' . $date . '-' . $randomNumber;
            $exists = InventoryBarang::where('kode_barang', $kodeBarang)->exists();
        } while ($exists);

        return $kodeBarang;
    }

    private function saveInventoryByCondition($row, $barang, $ruangan, $condition)
    {
        $conditionCount = intval($row[$condition] ?? 0);
        for ($i = 1; $i <= $conditionCount; $i++) {
            $kode_barang = ($row['kode_barang'] == "" || $row['kode_barang'] == "-") ? $this->generateKodeBarang() : $row['kode_barang'] . "-" . $condition . "-" . $i;
            InventoryBarang::updateOrCreate(
                ['kode_barang' => $kode_barang, 'id_barang' => $barang->id],
                [
                    'kondisi' => $condition,
                    'id_barang' => $barang->id,
                    'id_ruangan' => $ruangan->id,
                    'kode_barang' => $kode_barang,
                ]
            );
        }

    }

    // public function rules(): array
    // {
    //     return [
    //         'nama_barang' => 'required',
    //         'jenis' => 'required',
    //         'ruangan' => 'required',
    //         'total_barang' => 'required|integer|min:1',
    //         'harga' => 'required|numeric|min:0',
    //         'sumber_dana' => 'nullable',
    //         'tgl_pengadaan' => 'nullable|date',
    //         'kondisi' => 'required|string|in:bagus,rusak,habis,hilang,baru,dipinjam',
    //     ];
    // }
}
