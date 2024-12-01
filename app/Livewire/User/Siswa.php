<?php

namespace App\Livewire\User;

use App\Exports\TemplateSiswaImport;
use App\Models\Kelas;
use App\Models\Siswa as SiswaModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
class Siswa extends Component
{
    public $page = 'index', $siswa;

    public $username, $password, $password_confirmation, $name, $nisn, $nis, $no_hp, $kelas_id, $kelas, $alamat, $email;

    public function create(){
        $this->kelas = Kelas::orderBy('name')->latest()->get();
        $this->page = "create";
    }

    public function store(){
        try {
            $this->validate([
                'username' => 'required|regex:/^\S*$/|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|regex:/^\S*$/|confirmed',
                'name' => 'required|string',
                'nisn' => 'required|numeric|digits:10',
                'nis' => 'required|numeric',
                'kelas_id' => 'required',
                'alamat' => 'required|string',
            ]);

            $user = User::create([
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'siswa',
            ]);

            SiswaModel::create([
                'user_id' => $user->id,
                'name' => $this->name,
                'nisn' => $this->nisn,
                'nis' => $this->nis,
                'no_hp' => $this->no_hp,
                'kelas_id' => $this->kelas_id,
                'alamat' => $this->alamat,
            ]);

            $user->assignRole('siswa');
            toastr()->success("Siswa created successfully.");
        } catch (\Throwable $th) {
            toastr()->error("Terjadi kesalahan saat create new siswa...". $th->getMessage());
        }
    }

    public function show($id) {
        $this->siswa = SiswaModel::with(['user', 'kelas'])->find($id);
        $this->page = 'show';
    }

    public function edit($id){
        $this->kelas = Kelas::orderBy('name')->latest()->get();
        $this->siswa = SiswaModel::with(['user', 'kelas'])->find($id);
        $this->name = $this->siswa->name;
        $this->nisn = $this->siswa->nisn;
        $this->nis = $this->siswa->nis;
        $this->no_hp = $this->siswa->no_hp;
        $this->alamat = $this->siswa->alamat;
        $this->kelas_id = $this->siswa->kelas_id;
        $this->email = $this->siswa->user->email;
        $this->username = $this->siswa->user->username;
        $this->page = 'edit';

    }

    public function delete($id){
        try {
            User::find($id)->delete();
            toastr()->success('Siswa deleted successfully.');
            return redirect()->route('siswa.index');
        } catch (\Throwable $th) {
            toastr()->error("Terjadi kesalahan saat delete siswa.");
        }
    }

    public function clear(){
        $this->name ='';
        $this->kelas_id ='';
        $this->nisn ='';
        $this->nis ='';
        $this->username ='';
        $this->email ='';
        $this->password ='';
        $this->password_confirmation ='';
        $this->no_hp ='';
        $this->alamat ='';
        $this->email ='';
    }

    public function update($id) {
        try {
            $siswa = SiswaModel::with(['user', 'kelas'])->find($id);
            $this->validate([
                'username' => "required|regex:/^\S*$/|unique:users,username,$siswa->user_id",
                'email' => "required|email|unique:users,email,$siswa->user_id",
                'name' => 'required|string',
                'nisn' => 'required|numeric|digits:10',
                'nis' => 'required|numeric',
                'kelas_id' => 'required|exists:kelas,id',
                'alamat' => 'required|string',
                'no_hp' => 'nullable|string|max:15',
            ]);
            User::find($siswa->user_id)->update([
                'username' => $this->username,
                'email' => $this->email,
            ]);

            SiswaModel::find($id)->update([
                'name' => $this->name,
                'nisn' => $this->nisn,
                'nis' => $this->nis,
                'no_hp' => $this->no_hp,
                'kelas_id' => $this->kelas_id,
                'alamat' => $this->alamat,
            ]);
            
            toastr()->success("Siswa updated successfully.");
            $this->page = 'index';
        } catch (\Throwable $th) {
            toastr()->error("Terjadi kesalahan saat update new siswa...". $th->getMessage());
        }
    }

    public function downloadTemplate(){
        try {
            toastr()->success('Template import kelas berhasil di download.');
            $this->page = "import";
            return Excel::download(new TemplateSiswaImport, 'TemplateSiswaImport.xlsx');
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kelasahan saat download template import kelas.');
            $this->page = "import";
        }
    }

    public function render()
    {
        return view('livewire.user.siswa', [
            'siswas' => SiswaModel::with(['user', 'kelas'])->latest()->get()
        ]);
    }
}
