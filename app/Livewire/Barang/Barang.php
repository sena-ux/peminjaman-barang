<?php

namespace App\Livewire\Barang;

use App\Models\Barang\Barang as BarangModel;
use App\Models\Category;
use Livewire\Component;
class Barang extends Component
{
    public $page = "index", $barang, $id_barang, $categorys;

    public function show($id) {
        $this->clear();
        $this->barang = BarangModel::find($id);
        $this->categorys = Category::all();
        $this->page = "show";
    }

    public function edit($id) {
        $this->clear();
        $this->barang = BarangModel::find($id);
        $this->categorys = Category::all();
        $this->page = "edit";
    }

    public function deleteBarang($id) {
        $barang = BarangModel::find($id);
        if (file_exists(public_path($barang->foto_barang))) {
            unlink(public_path($barang->foto_barang));
        }
        $barang->delete();
        toastr()->success('Barang deleted successfully.');
        return redirect()->route('barang.index');
    }

    public function clear(){
        $this->barang = "";
    }

    public function render()
    {
        return view('livewire.barang.barang', [
            'barangs' => BarangModel::with(['category'])->latest()->get(),
        ]);
    }
}
