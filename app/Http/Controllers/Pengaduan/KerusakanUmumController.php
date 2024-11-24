<?php

namespace App\Http\Controllers\Pengaduan;

use App\DataTables\KerusakanUmumDataTable;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pelapor;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KerusakanUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KerusakanUmumDataTable $dataTable)
    {
        $data = [
            'user'=> User::all(),
            'barang'=> Barang::all(),
        ];
        return $dataTable->render('pengaduan.index', $data);
    }

    public function getdataUser() {
        $data = [
            'user'=> User::all(),
            'barang'=> Barang::all(),
        ];
        return $data;
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
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);

                $pelapor = Pelapor::updateOrCreate(['user_id' => Auth::user()->id]);
                
                Pengaduan::create([
                    'nama_barang'=> $request->input('barang'),
                    'id_pelapor' => $pelapor->id,
                    'tanggal_pengaduan'=> now(),
                    'status_pengaduan'=> 'Pending',
                    'title'=> $request->input('title'),
                    'message'=> $request->input('message'),
                    'deskripsi'=> $request->input('deskripsi'),
                    'foto_kerusakan'=> $filename,
                ]);
                return response()->json([
                    'title' => "Success",
                    'status' => 'Success',
                    'message' => 'File uploaded successfully'
                ], 200);
            } else {
                return response()->json([
                    'title' => "Error",
                    'status' => 'Error',
                    'message' => 'No file uploaded'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'title' => "Error",
                'status' => 'Error',
                'message' => 'File upload failed: ' . $e->getMessage()
            ], 500);
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
            'data' => Pengaduan::where('id_pengaduan', $id)->get(),
        ]);
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
}
