<?php

namespace App\Http\Controllers;

use App\DataTables\SiswaDataTable;
use App\Exports\SiswaExport;
use App\Exports\TemplateSiswaImport;
use App\Imports\ImportDataSiswa;
use App\Imports\KelasImport;
use App\Imports\SiswaImport;
use App\Imports\UsersImport;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SiswaDataTable $dataTable)
    {
        return view('admin.siswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:5|regex:/^\S*$/u|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'name' => 'required|min:5',
                'nisn' => 'required|min:10|unique:siswas,nisn',
                'nis' => 'required|min:4|unique:siswas,nis',
                'kelas' => 'required',
                'no_hp' => 'required|min:5',
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'title' => 'Error',
                    'message' => $validator->errors()->first(),
                    'status' => 422,
                ], 422);
            }

            $kelas = Kelas::firstOrCreate(
                ['name' => $request->kelas],
                [
                    'name' => $request->kelas,
                    'description' => "Kelas di tahun pelajaran " . now()->format('Y'),
                    'tahun_ajar' => now()->format('Y')
                ]
            );

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => "siswa",
            ]);
            Siswa::create([
                'user_id' => $user->id,
                'name' => $request->username,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'no_hp' => $request->no_hp,
                'kelas_id' => $kelas->id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Siswa created successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'title' => 'Error',
                'message' => $th->getMessage(),
                'status' => 422,
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'title' => 'Success!',
            'message' => 'Berhasil load data!',
            'data' => Siswa::with(['user', 'kelas'])->where('user_id', $id)->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json([
            'title' => 'Success!',
            'message' => 'Berhasil load data!',
            'data' => Siswa::with(['user', 'kelas'])->where('user_id', $id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $dataFormUpdate = [];
            $dataOldSiswa = Siswa::with(['user', 'kelas'])->where('user_id', $id)->first();
            $fieldsToCheck = [['name', 'nisn', 'nis', 'no_hp'], ['kelas'], ['username', 'email']];
            foreach ($request->all() as $key => $valueRequest) {
                if (in_array($key, $fieldsToCheck[0])) {
                    $valueOldSiswa = $dataOldSiswa->$key;
                    if ($valueRequest != $valueOldSiswa) {
                        $dataFormUpdate[$key] = $valueRequest;
                    }
                } else if (in_array($key, $fieldsToCheck[1])) {
                    $valueOldSiswa = $dataOldSiswa->kelas->name;
                    if ($valueRequest != $valueOldSiswa) {
                        $dataFormUpdate[$key] = $valueRequest;
                    }
                } else if (in_array($key, $fieldsToCheck[2])) {
                    $valueOldSiswa = $dataOldSiswa->user->$key;
                    if ($valueRequest != $valueOldSiswa) {
                        $dataFormUpdate[$key] = $valueRequest;
                    }
                }
            }
            if (empty($dataFormUpdate)) {
                return response()->json(['status' => 'error', 'message' => "Tidak ada yang perlu di Update.", 'data' => $dataFormUpdate]);
            }

            $rules = [
                'username' => ['required', 'min:5', 'regex:/^\S*$/u', Rule::unique('users')->ignore($dataOldSiswa->user->id)],
                'email' => ['required', 'email', Rule::unique('users')->ignore($dataOldSiswa->user->id)],
                'name' => 'required|min:5',
                'nisn' => ['required', 'min:10', Rule::unique('siswas')->ignore($dataOldSiswa->id)],
                'nis' => ['required', 'min:4', Rule::unique('siswas')->ignore($dataOldSiswa->id)],
                'kelas' => 'required',
                'no_hp' => 'required|min:5',
            ];
            $validator = Validator::make($dataFormUpdate, array_intersect_key($rules, $dataFormUpdate));

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
            }

            Log::info($dataFormUpdate);
            if (array_intersect_key(array_flip($fieldsToCheck[0]), $dataFormUpdate)) {
                $siswa = Siswa::where('user_id', $id)->update([
                    'name' => isset($dataFormUpdate['name']) ? $dataFormUpdate['name'] : $dataOldSiswa->name,
                    'nisn' => isset($dataFormUpdate['nisn']) ? $dataFormUpdate['nisn'] : $dataOldSiswa->nisn,
                    'nis' => isset($dataFormUpdate['nis']) ? $dataFormUpdate['nis'] : $dataOldSiswa->nis,
                    'no_hp' => isset($dataFormUpdate['no_hp']) ? $dataFormUpdate['no_hp'] : $dataOldSiswa->no_hp,
                ]);
            }
            if (array_intersect_key(array_flip($fieldsToCheck[1]), $dataFormUpdate)) {
                $kelas = Kelas::firstOrCreate(
                    ['name' => $dataFormUpdate['kelas']],
                    [
                        'name' => $dataFormUpdate['kelas'],
                        'description' => "Kelas di tahun pelajaran " . now()->format('Y'),
                        'tahun_ajar' => now()->format('Y')
                    ]
                );
                Siswa::where('user_id', $id)->update(['kelas_id' => $kelas->id]);
            }
            if (array_intersect_key(array_flip($fieldsToCheck[2]), $dataFormUpdate)) {
                $user = User::where('id', $id)->update([
                    'username' => isset($dataFormUpdate['username']) ? $dataFormUpdate['username'] : $dataOldSiswa->user->username,
                    'email' => isset($dataFormUpdate['email']) ? $dataFormUpdate['email'] : $dataOldSiswa->user->email,
                ]);
            }

            return response()->json([
                'title' => 'Update Success!',
                'message' => 'Siswa Updated successfully',
                'status' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 422,
                'title' => 'Error',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Siswa::where('user_id', $id)->delete();
        User::where('id', $id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Siswa deleted successfully!']);
    }

    public function reserAllPasswordUser(Request $request)
    {
        $newPassword = $request->input('newPassword');
        $users = User::where('role' , 'siswa')->get();

        foreach ($users as $user) {
            $user->update(['password' => bcrypt($newPassword)]);
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Reset Password Berhasil!',
            ],
            200,
        );
    }

    public function getImport()
    {
        return view('admin/ujicoba');
    }
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            try {
                Excel::import(new ImportDataSiswa, $file);
                // return response()->json(['data' => 'Users imported successfully.'], 201);
                toastr()->success("Siswa imported successfully.");
                return redirect()->route('siswa.index');
            } catch (\Exception $ex) {
                // return response()->json(['data' => 'Error: ' . $ex->getMessage()], 400);
                toastr()->error("Terjadi kesalahan saat import siswa.". $ex->getMessage());
                return redirect()->back()->withInput();
            }
        }

        return response()->json(['data' => 'No file received'], 400);
    }


    public function templateImport()
    {
        return Excel::download(new TemplateSiswaImport, 'template_import_siswa.xlsx');
    }

    public function siswaSelected(Request $request){
        Siswa::whereIn('user_id', $request->ids)->delete();
        User::whereIn('id', $request->ids)->delete();

        return response()->json(['status' => 'success', 'message' => 'Siswa deleted successfully!']);
    }
}
