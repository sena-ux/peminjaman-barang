<?php

namespace App\Http\Controllers\Pengaduan;

use App\DataTables\Ruangan\Kelas\InventoryRuangKelasBarangDataTable;
use App\Http\Controllers\Controller;
use App\Models\Pelapor;
use App\Models\Pengaduan\Tanggapan\Penanggap;
use App\Models\Ruangan\Kelas\BarangRK;
use App\Models\Ruangan\Kelas\InventoryRuangKelasBarang;
use App\Models\Tanggapan;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryRuangKelasBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InventoryRuangKelasBarangDataTable $dataTable)
    {
        return $dataTable->render('pengaduan.ruangan.inventory.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'message' => 'Data berhasil di load!',
            'status' => 'success',
            'data' => BarangRK::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric',
                'kondisi' => 'required',
                'nama_barang' => 'required',
                'kode_barang' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'title' => 'Error',
                    'message' => $validator->errors()->first(),
                    'status' => 422,
                ], 422);
            }
            $userKelas = Auth::user()->siswa->kelas;

            $barang = InventoryRuangKelasBarang::where(['id_barangrk' => $request->input('nama_barang'), 'id_kelas' => $userKelas->id, 'kondisi' => $request->kondisi])->get();
            if ($barang->isEmpty()) {
                if ($request->hasFile('file')) {
                    $file = $request->file("file");
                    $filename = "InventoryBarangRK" . time() . "." . $file->getClientOriginalExtension();
                    $filepath = 'uploads/inventory/barang/kelas' . $filename;

                    $inventory = InventoryRuangKelasBarang::updateOrCreate(
                        ['id_barangrk' => $request->input('nama_barang')],
                        [
                            'id_barangrk' => $request->input('nama_barang'),
                            'id_kelas' => $userKelas->id,
                            'user_id' => Auth::user()->id,
                            'kode_barang' => $request->input('kode_barang'),
                            'amount' => $request->input('amount'),
                            'kondisi' => $request->input('kondisi'),
                            'status' => 'Pending',
                            'foto' => $filepath
                        ]
                    );
                    $tanggapan = Tanggapan::updateOrCreate(
                        ['inventoryBRK_id' => $inventory->id],
                        [
                            'name' => 'BarangRK',
                            'message' => 'Inventory Barang Kelas',
                            'status' => 'Pending'
                        ],
                    );
                    $inventory->update(['id_tanggapan' => $tanggapan->id]);

                    $file->move(public_path('uploads/inventory/barang/kelas'), $filename);

                    return response()->json([
                        'title' => "Kondisi barang di kelas $userKelas->name behasil dilaporkan!",
                        'message' => "Silahkan menunggu perbaikan untuk hal tersebut, Terima Kasih sudah melakukan penginputan data kelas.",
                        'status' => 'success'
                    ], 200);

                }
            } else{
                return response()->json([
                    'status' => 'info',
                    'message' => 'Anda hanya diperbolehkan menginputkan kondisi barang di kelas sekali untuk 1 barang!',
                    'title' => 'Sudah melakukan penginputan',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 422,
                'title' => 'Error',
                // 'message' => $e->getMessage(),
                'message' => 'Terjadi Kesalahan saat input data keserver!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'message' => 'Data berhasil di load!',
            'status' => 'success',
            'data' => InventoryRuangKelasBarang::with('barang', 'kelas', 'tanggapan')->where('id_barangrk',$id)->first(),
        ], 200);
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
