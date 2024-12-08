<?php

namespace App\Http\Controllers\Regulasi;

use App\Http\Controllers\Controller;
use App\Models\Barang\Barang;
use App\Models\Barang\KIR;
use App\Models\Ruangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\WithFileUploads;

class InventarisController extends Controller
{
    use WithFileUploads;
    public function ruangan()
    {
        return view('admin.regulasi.inventaris.ruangan');
    }

    public function insertBarang(Request $request)
    {
        try {
            $ruangan_id = $request->ruangan_id;
            $request->validate([
                'ruangan_id' => 'required',
                'nama_barang' => 'required|string',
                'kode_barang' => 'required|string',
                'sumber_dana' => 'required|string',
                'tahun_pengadaan' => 'required|integer|min:1000|max:5000',
                'seri_pubrik' => 'string',
                'ukuran' => 'string',
                'bahan' => 'string',
                'harga_barang' => 'required',
                'foto_barang' => 'required',
                'tahun_register' => 'required',
                'category' => 'required',
                'deskripsi' => 'required',
                'total_barang' => 'required',
                'baik' => 'required',
                'kurang_baik' => 'required',
                'rusak_berat' => 'required',
            ]);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function insertFotoBarang(Request $request, $id_barang)
    {
        try {
            $request->validate([
                'foto_barang' => 'required|image|mimes:png,jpg,jpeg|max:5064',
            ]);

            if ($request->hasFile('foto_barang')) {
                $foto_barang = $request->file('foto_barang');
                $foto_brg_fileName = $foto_barang->getClientOriginalName();
                $destinationPath = public_path('uploads/barang/');

                if (!file_exists($destinationPath . $foto_brg_fileName)) {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($foto_barang);
                    $image->scale(420, 300);
                    $image->save($destinationPath . $foto_brg_fileName, 1);
                }

                Barang::find($id_barang)->update(['foto_barang' => 'uploads/barang/' . $foto_brg_fileName]);
            }
            toastr()->success('Foto barang berhasil di upload!');
            return redirect()->route('inventaris.ruangan');
        } catch (\Throwable $th) {
            toastr()->error('Keselahan : ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // public function cetak_kir($kode_ruangan)
    // {
    //     try {
    //         $id_ruangan = Ruangan::where('kode_ruangan', $kode_ruangan)->latest()->get()->pluck('id')->first();

    //         if($id_ruangan){
    //             $data = [
    //                 'kir' => KIR::with(['barang', 'riwayat'])->where("ruangan_id", $id_ruangan)->latest()->get(),
    //                 'kir_one' => KIR::with(['siswa', 'ruangan', 'kepala_sekolah', 'pengelola', 'wali', 'setting', 'riwayat'])->where("ruangan_id", $id_ruangan)->latest()->get()->first(),
    //             ];

    //             $pdf = Pdf::loadView('admin.regulasi.inventaris.cetak_kir', $data);
    //             toastr()->success("Cetak Kartu Inventaris Ruangan berhasil.");
    //             return $pdf->download('Kartu-Inventaris-Ruangan.pdf');
    //         } else{
    //             toastr()->error("Tidak ada data barang terinput.");
    //         }
    //     } catch (\Throwable $th) {
    //         toastr()->error("Terjadi Kesalahan saat cetak kartu.");
    //         return redirect()->back()->withInput();
    //     }
    // }


    public function cetak_kir($kode_ruangan)
    {
        try {
            $id_ruangan = Ruangan::where('kode_ruangan', $kode_ruangan)->latest()->get()->pluck('id')->first();
            $data = [
                'kir' => KIR::with(['barang', 'riwayat'])->where("ruangan_id", $id_ruangan)->latest()->get(),
                'kir_one' => KIR::with(['siswa', 'ruangan', 'kepala_sekolah', 'pengelola', 'wali', 'setting', 'riwayat'])->where("ruangan_id", $id_ruangan)->latest()->get()->first(),
            ];
            if($data['kir']->isNotEmpty()){
                return view('admin.regulasi.inventaris.cetak_kir', $data);
            } else{
                toastr()->error("Data barang masih kosong.");
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            toastr()->error("Terjadi Kesalahan saat cetak kartu.");
            return redirect()->back()->withInput();
        }
    }
}
