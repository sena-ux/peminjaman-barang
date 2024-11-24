<?php

namespace App\Http\Controllers\Tanggapan;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Pengaduan\Tanggapan\Penanggap;
use App\Models\Ruangan\Kelas\InventoryRuangKelasBarang;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TanggapanController extends Controller
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        try {
            if($request->hasFile("file")) {
                $file = $request->file("file");
                $filename = time() .".". $file->getClientOriginalExtension();
                $file->move(public_path('uploads/tanggapan'), $filename);
                
                $tanggapan = Tanggapan::create([
                    'name'=> $request->input('name'),
                    'message'=> $request->input('message'),
                    'status'=> $request->input('status'),
                    'foto_tanggapan'=> $filename,
                    'penanggap_id'=> Auth::user()->id,
                    'pengaduan_id' => $request->input('pengaduan_id'),
                ]);

                Pengaduan::where('id_pengaduan', $request->input('pengaduan_id'))->update(['id_tanggapan' => $tanggapan->id, 'status_pengaduan' => $request->input('status')]);

                return response()->json([
                    'title' => "Success",
                    'status' => 'Success',
                    'message' => 'File uploaded successfully'
                ], 200);
            } else{
                return response()->json([
                    'title' => "Error",
                    'status' => 'Error',
                    'message' => 'No file uploaded'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'title' => "Error",
                'status' => 'Error',
                'message' => 'File upload failed: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tanggapan $tanggapan)
    {
        //
    }

    public function tanggapiBarangRK(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        try {
            if($request->hasFile("file")) {
                $file = $request->file("file");
                $filename = time() .".". $file->getClientOriginalExtension();
                $filepath = $file->move(public_path('uploads/tanggapan'), $filename);

                $penanggap = Penanggap::updateOrCreate(['user_id' => Auth::user()->id]);
                
                $tanggapan = Tanggapan::create([
                    'name'=> $request->input('name'),
                    'message'=> $request->input('message'),
                    'status'=> $request->input('status'),
                    'key' => $request->input('key'),
                    'foto_tanggapan'=> $filepath,
                    'penanggap_id'=> $penanggap->id,
                    'inventoryBRK_id' => $request->input('inventory_id'),
                ]);

                InventoryRuangKelasBarang::where('id', $request->input('inventory_id'))
                ->update([
                    'id_tanggapan' => $tanggapan->id, 
                    'status_pengaduan' => $request->input('status')
                ]);

                return response()->json([
                    'title' => "Success",
                    'status' => 'Success',
                    'message' => 'File uploaded successfully'
                ], 200);
            } else{
                return response()->json([
                    'title' => "Error",
                    'status' => 'Error',
                    'message' => 'No file uploaded'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'title' => "Error",
                'status' => 'Error',
                'message' => 'File upload failed: ' . $th->getMessage()
            ], 500);
        }
    }
}
