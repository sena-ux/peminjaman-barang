<?php

namespace App\Livewire\Umum;

use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;

class Ruangan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $page = 'index', $paginate = 10 , $kelas;

    public $nama_ruangan, $lokasi, $kelas_id, $ruangan_id, $nama_kelas;

    public function __construct(){
        $this->kelas = Kelas::all();
    }

    public function store () {
        try {
            $this->validate([
                'nama_ruangan' => 'required|string|max:255',
            ]);
            \App\Models\Ruangan::create([
                'nama_ruangan' => $this->nama_ruangan,
                'lokasi' => $this->lokasi,
                'id_kelas' => $this->kelas_id,
            ]);
            toastr()->success('Data created successfully.');
            $this->clear();
            $this->page = 'create';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input ruangan baru.'. $th->getMessage());
            $this->page = 'create';
        }
    }

    public function show($id)
    {
        $data = \App\Models\Ruangan::with('kelas')->find($id);
        $this->nama_ruangan = $data->nama_ruangan;
        $this->lokasi = $data->lokasi;
        $this->kelas_id = $data->id_kelas;
        $this->ruangan_id = $id;
        $this->nama_kelas = $data->kelas->name;
        $this->page = 'show';
    }
    
    public function edit($id) {
        $data = \App\Models\Ruangan::with('kelas')->find($id);
        $this->nama_ruangan = $data->nama_ruangan;
        $this->lokasi = $data->lokasi;
        $this->kelas_id = $data->id_kelas;
        $this->ruangan_id = $id;
        $this->nama_kelas = $data->kelas->name;
        $this->page = 'edit';
    }

    public function update($id)
    {
        try {
            $this->validate([
                'nama_ruangan' => 'required|string|max:255',
            ]);
            \App\Models\Ruangan::find($id)->update([
                'nama_ruangan' => $this->nama_ruangan,
                'lokasi' => $this->lokasi,
                'id_kelas' => $this->kelas_id,
            ]);
            toastr()->success('Data updated successfully.');
            $this->clear();
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input data kelas.');
            $this->page = 'create';
        }
    }

    public function delete ($id){
        try {
            $this->clear();
            \App\Models\Ruangan::find($id)->delete();
            $this->page='index';
            toastr()->success('Data deleted successfully.');
            $this->clear();
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input data kelas.');
            $this->page = 'create';
        }
    }

    public function clear() {
        $this->nama_ruangan = "";
        $this->lokasi = "";
        $this->kelas_id = "";
    }
    public function render()
    {
        return view('livewire.umum.ruangan', [
            'ruangans' => \App\Models\Ruangan::with(['kelas'])->paginate(intval($this->paginate))
        ]);
    }
}
