<?php

namespace App\Http\Controllers\Regulasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;

class InventarisController extends Controller
{
    use WithFileUploads;
    public function ruangan(){
        return view('admin.regulasi.inventaris.ruangan');
    }

    public function insertBarang(Request $request){
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
}
