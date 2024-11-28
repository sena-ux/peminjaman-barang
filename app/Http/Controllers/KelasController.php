<?php

namespace App\Http\Controllers;

use App\Imports\KelasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function importKelas(Request $request) {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);
    
            $import = new KelasImport();
            Excel::import($import, $request->file);
    
            // Tampilkan pesan berhasil dan gagal
            $successCount = $import->successCount;
            $errorCount = $import->errorCount;
            $errors = $import->errors;
    
            toastr()->success("Data berhasil diimpor: $successCount. Data gagal: $errorCount.");
    
            // Jika ada error, simpan untuk ditampilkan
            if ($errorCount > 0) {
                session()->flash('import_errors', $errors);
            }
    
            return redirect()->route('kelas.index');
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat import data ruangan. ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
