<?php

namespace App\Livewire\Regulasi;

use App\Models\Peminjaman;
use App\Models\Siswa;
use Livewire\Component;

class PeminjamanBarang extends Component
{
    public $page = "index";
    public function render()
    {
        $data = [
            'siswas' => $this->siswas = Siswa::with(['user', 'kelas'])->latest()->get(),
            'peminjamans' => Peminjaman::with(['barang','user'])->latest()->get(),
            'peminjamansBK' => Peminjaman::with(['barang','user'])->where('status_pengembalian', false)->latest()->get(),
            'peminjamansSK' => Peminjaman::with(['barang','user'])->where('status_pengembalian', true)->latest()->get(),
        ];
        return view('livewire.regulasi.peminjaman-barang', $data);
    }
}
