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
use Livewire\Component;

class Ruangan extends Component
{
    public $page = 'index';

    public $id_Ruangan, $ruangan;

    public $ruangan_id, $nama_barang, $kode_barang, $sumber_dana,
    $tahun_pengadaan, $seri_pubrik, $ukuran, $bahan, $harga_barang,
    $tahun_register, $category, $deskripsi, $total_barang, $baik,
    $kurang_baik, $rusak_berat, $satuan;

    public function render()
    {
        $data = [
            'ruangans' => \App\Models\Ruangan::with(['kelas'])->latest()->get(),
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
                'kode_barang' => 'required|string',
                'sumber_dana' => 'required|string',
                'tahun_pengadaan' => 'required|integer|min:1000|max:5000',
                'seri_pubrik' => 'string',
                'ukuran' => 'string',
                'bahan' => 'string',
                'harga_barang' => '',
                'tahun_register' => 'integer|min:1000|max:5000',
                'category' => 'string',
                'total_barang' => 'required|integer',
                'baik' => 'integer',
                'kurang_baik' => 'integer',
                'rusak_berat' => 'integer',
            ]);

            $validasi = false;

            if (intval($this->total_barang) != (intval($this->baik) + intval($this->kurang_baik) + intval($this->rusak_berat))) {
                toastr()->error('Jumlah total barang tidak sinkron.');
                $validasi = false;
            } else {
                $validasi = true;
            }

            if ($validasi) {
                $ruangan = RuanganModel::with('kelas')->find($this->id_Ruangan);
                $category = Category::createOrFirst(
                    ['name' => $this->category]
                );

                $ketuaKelas = Siswa::where([
                    'kelas_id' => $ruangan->kelas_id,
                    'status' => 'ketua kelas',
                ])->first();

                $kepalaSekolah = Staff::where('jenis_staff', 'kepala sekolah')->first();

                $pengelolaBDM = Staff::where('jenis_staff', 'pengelola bdm')->first();

                $waliKelas = Staff::where([
                    'jenis_staff' => 'wali kelas',
                    'wali_kelas' => $ruangan->kelas_id
                ])->first();

                $setting = Setting::where('status', true)->first();


                $barang = Barang::create([
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
                ]);

                Barang::where('kode_barang', $this->kode_barang)
                    ->increment('total_barang', $this->total_barang);

                $kir = KIR::create([
                    'barang_id' => $barang->id,
                    'siswa_id' => $ketuaKelas->id ?? null,
                    'ruangan_id' => $ruangan->id,
                    'kepala_sekolah_id' => $kepalaSekolah->id ?? null,
                    'pengelola_id' => $pengelolaBDM->id ?? null,
                    'wali_id' => $waliKelas->id ?? null,
                    'setting_id' => $setting->id,
                    'jumlah_barang' => $this->total_barang,
                ]);

                RiwayatKIR::create([
                    'kondisi' => ($this->kurang_baik ? 'bagus' : 'no kondisi'),
                    'status' => ($this->total_barang ? 'tersedia' : 'no status'),
                    'jumlah' => $this->total_barang,
                    'bagus' => $this->baik,
                    'kurang_bagus' => $this->kurang_baik,
                    'rusak_berat' => $this->rusak_berat,
                    'date' => now()->toDateString(),
                ]);

                $riwayat = RiwayatKIR::where('kir_id', $kir->id)->latest()->first();

                KIR::find($kir->id)->update([
                    'riwayat_id' => $riwayat->id,
                ]);
            }
            toastr()->success('Barang telah di tambahkan ke ruangan silahkan periksa perubahan.');
            $this->page = "index";
        } catch (\Throwable $th) {
            toastr()->error('Kesalahan : ' . $th->getMessage());
        }
    }
}
