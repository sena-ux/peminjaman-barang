<?php

namespace App\Livewire\Umum;

use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $page = "index", $paginate;
    public $name, $deskripsi, $id_category;

    public function store(){
        try {
            $validated = $this->validate([
                'name' => 'required|max:255',
                'deskripsi' => 'string',
            ]);
            \App\Models\Category::create($validated);
            toastr()->success('Category created successfully.');
            $this->clear();
            $this->page = 'create';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input category.');
            $this->page = 'create';
        }
    }

    public function show($id) {
        $data = \App\Models\Category::find($id);
        $this->name = $data->name;
        $this->deskripsi = $data->deskripsi;
        $this->id_category = $id;
        $this->page = "show";
    }

    public function edit($id) {
        $data = \App\Models\Category::find($id);
        $this->name = $data->name;
        $this->deskripsi = $data->deskripsi;
        $this->id_category = $id;
        $this->page = "edit";
    }

    public function update ($id){
        try {
            $validated = $this->validate([
                'name' => 'required|max:255',
                'deskripsi' => 'string',
            ]);
            \App\Models\Category::find($id)->update($validated);
            toastr()->success('Category updated successfully.');
            $this->clear();
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input category.');
            $this->page = 'edit';
        }
    }

    public function delete ($id) {
        try {
            \App\Models\Category::find($id)->delete();
            $this->clear();
            toastr()->success('Category created successfully.');
            $this->clear();
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat input category.');
            $this->page = 'index';
        }
    }

    public function clear(){
        $this->name = "";
        $this->deskripsi = "";
        $this->id_category = "";
    }
    public function render()
    {
        return view('livewire.umum.category', [
            'categorys' => \App\Models\Category::latest()->get(),
        ]);
    }
}
