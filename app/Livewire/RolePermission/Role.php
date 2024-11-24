<?php

namespace App\Livewire\RolePermission;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $page = 'index', $name, $guard_name = "web", $paginate = 10, $role_id;

    public function store () {
        try {
            $validated = $this->validate([
                'name' => 'required|string|unique:roles',
                'guard_name' => 'required|string',
            ]);

            RoleModel::create($validated);
            toastr()->success('Role created successfully');
            $this->clear();
            $this->page = 'create';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat membuat role baru.');
        }
    }

    public function show($id){
        $data = RoleModel::find($id);
        $this->name = $data->name;
        $this->guard_name = $data->guard_name;
        $this->role_id = $id;
        $this->page = 'show';
    }

    public function edit($id){
        $data = RoleModel::find($id);
        $this->name = $data->name;
        $this->guard_name = $data->guard_name;
        $this->role_id = $id;
        $this->page = 'edit';
    }

    public function update ($id) {
        try {
            $validated = $this->validate([
                'name' => 'required|string|unique:roles',
                'guard_name' => 'required|string',
            ]);

            RoleModel::find($id)->update($validated);
            toastr()->success('Role updated successfully');
            $this->page = 'show';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan update data.');
        }
    }

    public function delete ($id) {
        try {
            RoleModel::find($id)->delete();
            toastr()->success('Role deleted successfully');
            $this->clear();
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan delete data.');
        }
    }

    public function clear(){
        $this->name = "";
        $this->role_id = "";
    }
    public function render()
    {
        return view('livewire.role-permission.role', [
            'roles' => RoleModel::where('name', '!=', 'superadmin')->paginate($this->paginate),
        ]);
    }
}
