<?php

namespace App\Livewire\RolePermission;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;


class AsignRole extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $page = 'index', $user_id, $role_name, $paginate = 10, $asignrole_id, $search;
    public $listRole;

    public function mount()
    {
        $this->listRole = Role::latest()->get();
    }

    public function asign($id)
    {
        try {
            $user = User::find($id);
            $user->assignRole($this->role_name);
            toastr()->success('Model asign role updated successfully');
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan asign role data.');
        }
    }


    public function clear()
    {
        // $this->name = "";
        // $this->asignrole_id = "";
    }
    public function render()
    {
        return view('livewire.role-permission.asign-role', [
            'users' => $this->search ? User::where('role','!=', 'Super Admin')->orWhere('username', 'LIKE', "%{$this->search}%")->orWhere('email', "LIKE", "%{$this->search}%")->paginate(intval($this->paginate)) : User::where('role','!=', 'Super Admin')->orderBy('username')->paginate(intval($this->paginate)),
        ]);
    }
}
