<?php

namespace App\Livewire\Regulasi;

use App\Models\Ruangan;
use Livewire\Component;

class Inventaris extends Component
{
    public $page = 'index';

    public function render()
    {
        return view('livewire.regulasi.inventaris');
    }
}
