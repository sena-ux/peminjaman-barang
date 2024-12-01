<?php

namespace App\Livewire\Umum;

use App\Models\Umum\Kerusakan as KerusakanModel;
use Livewire\Component;

class Kerusakan extends Component
{
    public $page = "index", $kerusakan;

    public function show($id) {
        $this->kerusakan = KerusakanModel::find($id);
        $this->page = "show";
    }
    public function edit($id) {
        $this->kerusakan = KerusakanModel::find($id);
        $this->page = "edit";
    }
    public function deleteKerusakan($id){
        try {
            $kerusakan = KerusakanModel::find($id)->delete();
            toastr()->success('Kerusakan Deleted Successfully.');
            return redirect()->route('kerusakan.index');
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat delete kerusakan.');
        }
    }
    public function render()
    {
        return view('livewire.umum.kerusakan', [
            'kerusakans' => KerusakanModel::with(['user'])->latest()->get(),
        ]);
    }
}
