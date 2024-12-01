<?php

namespace App\Livewire\Regulasi;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;

class BarangPinjam extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = 'index';
    
    // peminjaman
    public $nama_barang;
    public $siswas, $peminjamans, $paginate= 10, $search;

    public function __construct()
    {
    }
    
    public function peminjaman() {
        if ($this->siswas) {
            $this->siswas = Siswa::with(['user','kelas'])
            ->where('name', ' %LIKE%', $this->search)
            ->orWhere('nisn', '%LIKE%', $this->search)
            ->orWhereHas('kelas', function($query) {
                $query->where('name', '%LIKE%', $this->search);
            })
            ->latest()->get();
        } else{
            $this->siswas = Siswa::with(['user', 'kelas'])->latest()->get();
        }
        $this->peminjamans = Peminjaman::with(['kelas','user'])->latest()->get();
        $this->page = 'peminjaman';
    }

    public function pinjamBarang($id){

    }

    public function render()
    {
        return view('livewire.regulasi.barang-pinjam', [
            'barangs' => Barang::whereHas('category', function ($query) {
                $query->where('name', 'Barang Pinjam');
            })->where('nama_barang', '%LIKE%', $this->nama_barang)->get()
        ]);
    }
}
