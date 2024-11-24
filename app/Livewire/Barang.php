<?php

namespace App\Livewire;

use App\DataTables\BarangDataTable;
use Livewire\Component;

class Barang extends Component
{
    public $barang;

    public function mount() {
        $this->barang = (new BarangDataTable)->html();
    }
    public function render()
    {
        return view('livewire.barang', [
            'barangTable' => $this->barang,
        ]);
    }
}
