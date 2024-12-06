<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\user\Admin;
use App\Models\user\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Staf extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page = 'index';
    public $gender, $email, $username, $no_hp, $alamat, $nip, $jenis_staf, $instansi = 'SMAN 2 Amlapura', $name, $password, $password_confirmation, $wali_kelas;
    public $idstaf, $iduser;
    public $paginate = 10;
    public function create()
    {
        $this->page = 'create';
    }
    public function update($id)
    {
        $this->clear();
        $this->page = 'update';
        $staf = Staff::with(['user'])->findOrFail($id);
        $this->gender = $staf->gender;
        $this->email = $staf->user->email;
        $this->username = $staf->user->username;
        $this->no_hp = $staf->no_hp;
        $this->alamat = $staf->alamat;
        $this->nip = $staf->nip;
        $this->jenis_staf = $staf->jenis_staff;
        $this->instansi = $staf->instansi;
        $this->name = $staf->name;
        $this->iduser = $staf->user->id;
        $this->idstaf = $id;
    }
    public function show($id)
    {
        $this->clear();
        $this->page = 'show';
        $staf = Staff::with(['user'])->findOrFail($id);
        $this->gender = $staf->gender;
        $this->email = $staf->user->email;
        $this->username = $staf->user->username;
        $this->no_hp = $staf->no_hp;
        $this->alamat = $staf->alamat;
        $this->nip = $staf->nip;
        $this->jenis_staf = $staf->jenis_staff;
        $this->instansi = $staf->instansi;
        $this->name = $staf->name;
        $this->idstaf = $id;
    }

    public function store()
    {
        try {
            $this->validate([
                'email' => 'required|email|unique:users,email',
                'username' => 'required|string|unique:users,username|min:4',
                'password' => 'required|confirmed|min:8',
                'jenis_staf' => 'required|string',
                'name' => 'required|string',
            ]);
            $user = User::create([
                'email' => $this->email,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'role' => 'staf',
            ]);
            $user->assignRole('staf');
            Staff::create([
                'user_id' => $user->id,
                'name' => $this->name,
                'jenis_staff' => Str::lower($this->jenis_staf),
                'wali_kelas' => $this->wali_kelas ?? null,
                'instansi' => $this->instansi,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                'nip' => $this->nip,
                'gender' => $this->gender,
            ]);

            toastr()->success('Staf created succesfully!');
            $this->page = 'index';
            $this->clear();
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error($e->getMessage());
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
        }
    }
    public function edit()
    {
        try {
            $this->validate([
                'email' => 'required|email|unique:users,email,' . $this->iduser,
                'username' => 'required|string|unique:users,username,' . $this->iduser . '|min:4|regex:/^\S*$/',
                'jenis_staf' => 'required|string',
                'name' => 'required|string',
            ]);
            $staf = Staff::with(['user'])->find($this->idstaf);
            $user = $staf->user;
            $user->email = $this->email;
            $user->username = $this->username;
            $user->save();

            $staf->name = $this->name ?? $staf->name;
            $staf->jenis_staff = $this->jenis_staf ?? $staf->jenis_staf;
            $staf->instansi = $this->instansi ?? $staf->instansi;
            $staf->no_hp = $this->no_hp ?? $staf->no_hp;
            $staf->alamat = $this->alamat ?? $staf->alamat;
            $staf->nip = $this->nip ?? $staf->nip;
            $staf->gender = $this->gender ?? $staf->gender;
            $staf->save();

            toastr()->success('Staf updated succesfully!');
            $this->page = 'index';
            $this->clear();
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error($e->getMessage());
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
        }
    }
    public function clear()
    {
        $this->email = "";
        $this->password = "";
        $this->password_confirmation = "";
        $this->gender = "";
        $this->jenis_staf = "";
        $this->instansi = "";
        $this->alamat = "";
        $this->username = "";
        $this->nip = "";
        $this->name = "";
        $this->no_hp = "";
    }

    public function delete($id)
    {
        $this->clear();
        User::find($id)->delete();
        toastr()->success('Staf deleted successfully!');
        $this->page = 'index';
        return redirect()->route('staf.index');
    }
    public function back()
    {
        $this->page = 'index';
    }
    public function render()
    {
        return view('livewire.user.staf', [
            'stafs' => Staff::with(['user'])->paginate(intval($this->paginate))
        ]);
    }
}
