<?php

namespace App\Livewire\Ruangan\Kelas;

use App\Models\Ruangan\Kelas\BarangRK;
use App\Models\Tanggapan;
use Auth;
use Livewire\Component;
use App\Models\Ruangan\Kelas\InventoryRuangKelasBarang as modelInventoryRKB;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class InventoryRuangKelasBarang extends Component
{
    use WithFileUploads;

    #[Validate('image|max:2024')]
    public $foto;

    #[Validate('required')]
    public $nama_barang;

    #[Validate('required')]
    public $kondisi;

    public $data;
    public $loading = false;
    public function render()
    {
        $this->data = modelInventoryRKB::all() ?? modelInventoryRKB::paginate(5);
        return view('livewire.ruangan.kelas.inventory-ruang-kelas-barang');
    }

    public function store()
    {
        $this->loading = true;
        $this->validate();
        try {
            $barang = BarangRK::where('nama_barang', $this->nama_barang)->get();
            if (!$barang->isEmpty()) {
                $fileName = 'inventory_barangRK_' . now()->format('Y-m-d_l_H-i-s') . '.' . $this->foto->getClientOriginalExtension();
                $filepath = $this->foto->storeAs('uploads/pengaduan/inventory/barangRK', $fileName, 'public');

                $barang_kelas = BarangRK::updateOrCreate(
                    ['nama_barang' => $this->nama_barang],
                    [
                        'foto' => $filepath,
                    ]
                );

                $inventory = modelInventoryRKB::create(
                    [
                        'id_barangrk' => $barang_kelas->id,
                        'id_kelas' => Auth::user()->siswa->kelas->id,
                        'amount' => 1,
                        'kondisi' => $this->kondisi,
                        'foto' => $filepath
                    ]
                );
                $tanggapan = Tanggapan::create(
                    [
                        'name' => 'BarangRK',
                        'message' => 'Inventory Barang Kelas',
                        'status' => 'Pending'
                    ],
                );
                $inventory->update(['id_tanggapan' => $tanggapan->id]);

                toastr()->success('Inventory BarangRK Successfully!');
                $this->loading = false;
                return redirect()->back();
            } else{
                toastr()->info('Data sudah tersedia!');
            }


        } catch (\Exception $e) {
            dd($e->getMessage(), $this->foto);
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
