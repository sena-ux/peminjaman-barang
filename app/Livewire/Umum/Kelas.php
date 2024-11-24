<?php

namespace App\Livewire\Umum;

use Livewire\Component;
use Livewire\WithPagination;

class Kelas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $page = 'index', $paginate;
    public $name, $description, $tahun_ajar, $id_kelas;

    public function store()
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
                'description' => 'string',
                'tahun_ajar' => 'string',
            ]);

            \App\Models\Kelas::create($validated);
            toastr()->success('Data created successfully.');
            $this->clear();
            $this->page = 'create';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input data kelas.');
            $this->page = 'create';
        }
    }

    public function show($id)
    {
        $data = \App\Models\Kelas::find($id);
        $this->name = $data->name;
        $this->description = $data->description;
        $this->tahun_ajar = $data->tahun_ajar;
        $this->id_kelas = $id;
        $this->page = 'show';
    }

    public function edit($id) {
        $data = \App\Models\Kelas::find($id);
        $this->name = $data->name;
        $this->description = $data->description;
        $this->tahun_ajar = $data->tahun_ajar;
        $this->id_kelas = $id;
        $this->page = 'edit';
    }

    public function update($id)
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
                'description' => 'string',
                'tahun_ajar' => 'string',
            ]);
            \App\Models\Kelas::find($id)->update($validated);
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
            \App\Models\Kelas::find($id)->delete();
            $this->page='index';
            toastr()->success('Data deleted successfully.');
            $this->clear();
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input data kelas.');
            $this->page = 'create';
        }
    }

    public function clear()
    {
        $this->name = "";
        $this->tahun_ajar = "";
        $this->description = "";
        $this->id_kelas = "";
    }
    public function render()
    {
        return view('livewire.umum.kelas', [
            'kelass' => \App\Models\Kelas::paginate(intval($this->paginate)),
        ]);
    }
}
