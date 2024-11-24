<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\user\Admin as UserAdmin;

class Admin extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $page = "show";

    public function create(){
        $this->page = 'create';
    }

    public function render()
    {
        $data = [
            'admins' => UserAdmin::with(['user'])->paginate(10),
        ];
        return view('livewire.user.admin', $data);
    }
}
