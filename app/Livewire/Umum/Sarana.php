<?php

namespace App\Livewire\Umum;

use App\Models\Sarana as SaranaModel;
use Livewire\Component;
use Livewire\WithPagination;

class Sarana extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';

    public $page = "index", $paginate;
    public $nama_sarana, $lokasi, $keterangan, $sarana_id;

    public function store(){
        try {
            $validated = $this->validate([
                'nama_sarana' => 'required|string|max:255',
                'lokasi' => 'required|string',
                'keterangan' => 'string'
            ]);

            SaranaModel::create($validated);
            toastr()->success('Sarana created successfully.');
            $this->clear();
            $this->page = 'create';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input data Sarana.');
            $this->page = 'create';
        }
    }

    public function show($id){
        $data = SaranaModel::find($id);
        $this->nama_sarana = $data->nama_sarana;
        $this->lokasi = $data->lokasi;
        $this->keterangan = $data->keterangan;
        $this->sarana_id = $id;
        $this->page = 'show';
    }

    public function edit($id){
        $data = SaranaModel::find($id);
        $this->nama_sarana = $data->nama_sarana;
        $this->lokasi = $data->lokasi;
        $this->keterangan = $data->keterangan;
        $this->sarana_id = $id;
        $this->page = 'edit';
    }

    public function update($id){
        try {
            $validated = $this->validate([
                'nama_sarana' => 'required|string|max:255',
                'lokasi' => 'required|string',
                'keterangan' => 'string'
            ]);

            SaranaModel::find($id)->update($validated);
            toastr()->success('Sarana updated successfully.');
            $this->clear();
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input data Sarana.');
            $this->page = 'create';
        }
    }

    public function delete ($id) {
        try {
            SaranaModel::find($id)->delete();
            toastr()->success('Sarana deleted successfully.');
            $this->clear();
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input data Sarana.');
            $this->page = 'index';
        }
    }

    public function clear() {
        $this->nama_sarana = "";
        $this->lokasi = "";
        $this->keterangan = "";
    }
    public function render()
    {
        return view('livewire.umum.sarana', [
            'saranas' => SaranaModel::paginate(intval($this->paginate)),
        ]);
    }
}
