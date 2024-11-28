<?php

namespace App\Http\Controllers;

use App\Imports\ImportRuangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RuanganController extends Controller
{
    public function importRuangan(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);
    
            $import = new ImportRuangan();
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
    
            return redirect()->route('ruangan.index');
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat import data ruangan. ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
