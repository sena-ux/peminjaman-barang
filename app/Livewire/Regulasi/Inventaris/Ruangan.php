<?php

namespace App\Livewire\Regulasi\Inventaris;

use App\Models\Barang\Barang;
use App\Models\Barang\KIR;
use App\Models\Category;
use App\Models\Gurpeg;
use App\Models\Ruangan as RuanganModel;
use App\Models\Siswa;
use App\Models\Umum\RiwayatKIR;
use App\Models\Umum\Setting;
use App\Models\user\Staff;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class Ruangan extends Component
{
    public $page = 'index', $insertBarangPage = 'hide', $duplikat = 'false';

    public $id_Ruangan, $ruangan;

    public $ruangan_id, $nama_barang, $kode_barang, $sumber_dana,
    $tahun_pengadaan, $seri_pubrik, $ukuran, $bahan, $harga_barang,
    $tahun_register, $category, $deskripsi, $total_barang, $baik,
    $kurang_baik, $rusak_berat, $satuan, $barang_id, $kode_barang_search, $foto_barang;

    public function clear()
    {
        $this->insertBarangPage = 'hide';
        $this->duplikat = 'false';
        // $this->ruangan_id ="";
        // $this->nama_barang ="";
        // $this->kode_barang ="";
        // $this->sumber_dana ="";
        // $this->tahun_pengadaan ="";
        // $this->tahun_register ="";
        // $this->seri_pubrik ="";
        // $this->ukuran ="";
        // $this->bahan ="";
        // $this->harga_barang ="";
        // $this->category ="";
        // $this->deskripsi ="";
        // $this->total_barang ="";
        // $this->baik ="";
        // $this->kurang_baik ="";
        // $this->rusak_berat ="";
        // $this->satuan ="";
        // $this->barang_id ="";
        // $this->kode_barang_search ="";
        // $this->foto_barang ="";
    }
    public function render()
    {
        $data = [
            'ruangans' => RuanganModel::with(['kelas', 'kir'])->latest()->get(),
        ];
        return view('livewire.regulasi.inventaris.ruangan', $data);
    }

    public function insertBarang($id_Ruangan)
    {
        $this->ruangan = RuanganModel::find($id_Ruangan);
        $this->id_Ruangan = $id_Ruangan;
        $this->page = 'insertBarang';
    }

    public function insertBarangToRuangan()
    {
        try {
            $this->validate([
                'nama_barang' => 'required|string',
                'kode_barang' => 'required|string|min:5|max:255',
                'sumber_dana' => 'required|string',
                'tahun_pengadaan' => 'required|integer|min:1000|max:5000',
                'seri_pubrik' => 'nullable|string',
                'ukuran' => 'nullable|string',
                'bahan' => 'nullable|string',
                'harga_barang' => 'nullable|numeric',
                'tahun_register' => 'nullable|integer|min:1000|max:5000',
                'category' => 'nullable|string',
                'total_barang' => 'required|integer',
                'baik' => 'nullable|integer',
                'kurang_baik' => 'nullable|integer',
                'rusak_berat' => 'nullable|integer',
            ]);

            $totalBarang = intval($this->total_barang);
            $baik = intval($this->baik ?? 0);
            $kurangBaik = intval($this->kurang_baik ?? 0);
            $rusakBerat = intval($this->rusak_berat ?? 0);

            if ($totalBarang != ($baik + $kurangBaik + $rusakBerat)) {
                toastr()->error('Jumlah total barang tidak sinkron.');
                return;
            }

            $ruangan = RuanganModel::with('kelas')->find($this->id_Ruangan);
            if (!$ruangan) {
                toastr()->error('Ruangan tidak ditemukan.');
                return;
            }

            $category = Category::firstOrCreate(['name' => $this->category]);

            $ketuaKelas = Siswa::where([
                'kelas_id' => $ruangan->kelas_id,
                'status' => 'ketua kelas',
            ])->first();

            $kepalaSekolah = Staff::where('jenis_staff', 'kepala sekolah')->first();
            $pengelolaBDM = Staff::where('jenis_staff', 'pengelola bdm')->first();
            $waliKelas = Staff::where([
                'jenis_staff' => 'wali kelas',
                'wali_kelas' => $ruangan->kelas_id,
            ])->first();

            $setting = Setting::where('status', true)->first();

            $barang = Barang::updateOrCreate(
                ['kode_barang' => $this->kode_barang],
                [
                    'nama_barang' => $this->nama_barang,
                    'harga' => $this->harga_barang,
                    'sumber_dana' => $this->sumber_dana,
                    'no_seri_pubrik' => $this->seri_pubrik,
                    'ukuran' => $this->ukuran,
                    'bahan' => $this->bahan,
                    'kode_barang' => $this->kode_barang,
                    'tahun_pengadaan' => $this->tahun_pengadaan,
                    'tahun_register' => $this->tahun_register,
                    'satuan' => $this->satuan,
                    'deskripsi' => $this->deskripsi,
                    'id_category' => $category->id,
                    'merk' => $this->merk,
                ]
            );

            if ($this->duplikat == "update") {
                Barang::find($barang->id)->decrement('total_barang', $totalBarang)
                    ->increment('total_barang', $totalBarang);
            } else {
                Barang::find($barang->id)
                    ->increment('total_barang', $totalBarang);
            }

            $kir = KIR::create([
                'barang_id' => $barang->id,
                'siswa_id' => $ketuaKelas->id ?? null,
                'ruangan_id' => $ruangan->id,
                'kepala_sekolah_id' => $kepalaSekolah->id ?? null,
                'pengelola_id' => $pengelolaBDM->id ?? null,
                'wali_id' => $waliKelas->id ?? null,
                'setting_id' => $setting->id,
                'jumlah_barang' => $totalBarang,
                'kode_kir' => $this->generateKode(),
            ]);

            $riwayat = RiwayatKIR::create([
                'kondisi' => $baik > 0 ? 'bagus' : ($kurangBaik > 0 ? 'kurang bagus' : 'rusak berat'),
                'status' => $totalBarang > 0 ? 'tersedia' : 'tidak tersedia',
                'jumlah' => $totalBarang,
                'bagus' => $baik,
                'kurang_bagus' => $kurangBaik,
                'rusak_berat' => $rusakBerat,
                'kir_id' => $kir->id,
                'date' => now()->toDateString(),
            ]);

            $kir->update(['riwayat_id' => $riwayat->id]);
            $this->barang_id = $barang->id;

            $this->foto_barang = $barang->foto_barang;

            toastr()->success('Barang telah ditambahkan ke ruangan. Silakan periksa perubahan.');
            if ($barang->foto_barang) {
                $this->page = 'index';
            } else {
                $this->page = "insertImageForNewBarang";
            }
        } catch (\Throwable $th) {
            toastr()->error('Kesalahan: ' . $th->getMessage());
        }

    }

    public function searchBarang()
    {
        if ($this->kode_barang_search) {
            $barang = Barang::with('category')->where('kode_barang', $this->kode_barang_search)->latest()->get()->first();
            if ($barang) {
                $kir = KIR::with(['riwayat'])->where('barang_id', $barang->id)->latest()->get()->first();
                if ($kir) {
                    $this->duplikat = "true";
                    $this->total_barang = $kir->riwayat->jumlah;
                    $this->baik = $kir->riwayat->bagus;
                    $this->kurang_baik = $kir->riwayat->kurang_bagus;
                    $this->rusak_berat = $kir->riwayat->rusak_berat;
                } else {
                    $this->duplikat = "create";
                }
                toastr()->success('Data barang telah di temukan...');
                $this->nama_barang = $barang->nama_barang;
                $this->kode_barang = $barang->kode_barang;
                $this->sumber_dana = $barang->sumber_dana;
                $this->tahun_pengadaan = $barang->tahun_pengadaan;
                $this->seri_pubrik = $barang->no_seri_pubrik;
                $this->ukuran = $barang->ukuran;
                $this->satuan = $barang->satuan;
                $this->bahan = $barang->bahan;
                $this->harga_barang = intval($barang->harga);
                $this->tahun_register = $barang->tahun_register;
                $this->category = $barang->category->name;
                $this->deskripsi = $barang->deskripsi;
                $this->insertBarangPage = 'show';
            } else {
                toastr()->info('Data barang tidak ditemukan...');
                $this->insertBarangPage = 'show';
                $this->duplikat = "create";
                $this->kode_barang = $this->kode_barang_search;
            }
        } else {
            toastr()->error('Kode barang tidak boleh kosong!');
        }
    }

    public function cetak_kartu($id)
    {
        try {
            $data = [
                'kir' => KIR::with(['barang', 'riwayat'])->where("ruangan_id", $id)->latest()->get(),
                'kir_one' => KIR::with(['siswa', 'ruangan', 'kepala_sekolah', 'pengelola', 'wali', 'setting', 'riwayat'])->where("ruangan_id", $id)->latest()->get()->first(),
            ];

            $pdf = Pdf::loadView('admin.regulasi.inventaris.cetak_kir', $data);
            return $pdf->download('Kartu-Inventaris-Ruangan.pdf');
            // toastr()->success("Cetak Kartu Inventaris Ruangan berhasil.");
        } catch (\Throwable $th) {
            toastr()->error("Kesalahan : " . $th->getMessage());
        }
    }

    public function update()
    {
        $this->insertBarangPage = 'show';
        $this->duplikat = "update";
    }

    private function generateKode()
    {
        $prefix = 'KIR';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 1;

        do {
            $randomString = substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
            // $kodeBarang = $prefix . '-' . uniqid() . $randomString;
            $kodeBarang = $prefix . '-' . substr(bin2hex(random_bytes(3)), 0, 3) . $randomString;
            $exists = KIR::where('kode_kir', $kodeBarang)->exists();
        } while ($exists);

        return $kodeBarang;
    }


}
