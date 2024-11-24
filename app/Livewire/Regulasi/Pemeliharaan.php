<?php

namespace App\Livewire\Regulasi;

use App\Models\InventoryBarang;
use App\Models\Regulasi\Pemeliharaan as pms;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use PHPUnit\Framework\Constraint\IsEmpty;

class Pemeliharaan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $page = 'index';

    public $paginate = 10, $kode_barang, $inv_barang, $data_pemeliharaan;
    public $status = [
        [
            'name' => 'Validasi',
            'keterangan' => 'Hanya boleh di edit oleh Petugas.',
        ],
        [
            'name' => 'Error',
            'keterangan' => 'Hanya boleh di edit oleh Petugas, Kepala Sekolah, Staf Administrasi, dan Admin.',
        ],
        [
            'name' => 'Batal',
            'keterangan' => 'Hanya boleh di edit oleh Petugas, Kepala Sekolah, Staf Administrasi, dan Admin.',
        ],
        [
            'name' => 'Verifikasi',
            'keterangan' => 'Hanya boleh di edit oleh Staf Administrasi dan Kepala Sekolah.',
        ],
        [
            'name' => 'Verifikasi Sukses',
            'keterangan' => 'Hanya boleh di edit oleh Staf Administrasi dan Kepala Sekolah.',
        ],
        [
            'name' => 'Disetujui',
            'keterangan' => 'Hanya boleh di edit oleh Kepala Sekolah.',
        ],
        [
            'name' => 'Tidak Disetujui',
            'keterangan' => 'Hanya boleh di edit oleh Kepala Sekolah.',
        ],
        [
            'name' => 'Realisasi',
            'keterangan' => 'Hanya boleh di edit oleh Staf Administrasi dan Kepala Sekolah.',
        ],
        [
            'name' => 'Pending',
            'keterangan' => 'Hanya boleh di edit oleh Petugas, Staf Administrasi.',
        ],
        [
            'name' => 'Dalam Pengerjaan',
            'keterangan' => 'Hanya boleh di edit oleh Petugas, Kepala Sekolah, Staf Administrasi, dan Admin.',
        ],
        [
            'name' => 'Selesai',
            'keterangan' => 'Hanya boleh di edit oleh Petugas, Kepala Sekolah, Staf Administrasi, dan Admin.',
        ],
    ];

    public $status_update, $keterangan;

    public function updateStatus($id)
    {
        try {
            $validated = $this->validate([
                'status_update' => 'required|string|max:255',
                'keterangan' => 'string',
            ]);
            pms::find($id)->update([
                'status' => $validated['status_update'],
                'keterangan' => $validated['keterangan'],
            ]);
            toastr()->success('Status pemeliharaan updated successfully.');
            $this->data_pemeliharaan = pms::with(['sarana'])->find($id);
            $this->page = 'show';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat update status.');
        }
    }

    public function mount()
    {
        $this->inv_barang = InventoryBarang::with('barang')->get();
    }

    public function show($id)
    {
        $this->data_pemeliharaan = pms::with(['sarana'])->find($id);
        $this->status_update = $this->data_pemeliharaan->status;
        $this->keterangan = $this->data_pemeliharaan->keterangan;
        $this->page = 'show';
    }

    public function redirectToCreate()
    {
        if ($this->kode_barang) {
            return redirect()->route('pemeliharaan.create', $this->kode_barang);
        }
        toastr()->error('Kode Barang harus dipilih!');
    }

    public function create()
    {
        $kode = InventoryBarang::where('kode_barang', $this->kode_barang)->get();
        if ($kode->isEmpty()) {
            toastr()->error('Kode barang tidak ditemukan/tidak valid.');
            $this->page = 'index';
        } else {
            $this->page = 'create';
        }
    }

    public function delete ($id) {
        try {
            $pemeliharaan = pms::find($id);
            if(file_exists(public_path($pemeliharaan->kondisi_sebelum))){
                unlink(public_path($pemeliharaan->kondisi_sebelum));
            }
            if(file_exists(public_path($pemeliharaan->kondisi_sesudah))){
                unlink(public_path($pemeliharaan->kondisi_sesudah));
            }
            $pemeliharaan->delete();
            toastr()->success('Pemeliharaan deleted successfully.');
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat delete pemeliharaan');
        }
    }

    public function render()
    {
        return view('livewire.regulasi.pemeliharaan', [
            'pms' => pms::with(['sarana'])->paginate(intval($this->paginate))
        ]);
    }

    private function generateKode()
    {
        $prefix = 'pmlh';
        $date = Carbon::now()->format('Ymd');
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = 2;

        do {
            $randomString = substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
            $kodepmlh = $prefix . '-' . uniqid() . $randomString;
            $exists = Pemeliharaan::where('kode_pemeliharaan', $kodepmlh)->exists();
        } while ($exists);

        return $kodepmlh;
    }
}
