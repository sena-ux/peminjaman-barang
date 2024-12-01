<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use App\Models\Barang\Kondisi_Brg;
use App\Models\InventoryBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class KondisiBarangController extends Controller
{
    public function __construct()
    {
        $data = [
            'kondisi' => [
                ['name' => 'Bagus'],
                ['name' => 'Rusak'],
                ['name' => 'Layak Dipakai'],
                ['name' => 'Tidak Layak Dipakai'],
                ['name' => 'Rusak Parah'],
                ['name' => 'Baru'],
            ],
            'status' => [
                ['name' => 'Tersedia'],
                ['name' => 'Tidak Tersedia'],
                ['name' => 'Hilang'],
                ['name' => 'Dipinjam'],
                ['name' => 'Habis'],
            ]
        ];
        View::share($data);
    }
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
    public function create(Request $request)
    {
        $data= [
            'inventory' => InventoryBarang::with(['barang', 'barang.category', 'ruangan'])->find($request->kv),
        ];
        return view('admin.barang.kondisiBarang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'kondisi' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'detail_kondisi' => 'required|string'
            ]);
            Kondisi_Brg::create([
                'inv_brg_id' => $request->inv_brg_id,
                'date' => $request->date,
                'kondisi' => $request->kondisi,
                'status_barang' => $request->status,
                'detail_kondisi' => $request->detail_kondisi,
            ]);

            InventoryBarang::find($request->inv_brg_id)->update(['status_barang' => $request->status, 'kondisi' => $request->kondisi]);
            toastr()->success('Kondisi Barang new created successfully!');
            return redirect()->route('inventory.index');
        } catch (\Throwable $th) {
            toastr()->error('Validation Error: ' . $th->getMessage());
            return redirect()->back()->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error('Validation Error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.barang.kondisiBarang.create', [
            'inv_barang' => InventoryBarang::with(['barang', 'ruangan'])->find($id),
            'kondisiBarangs' => Kondisi_Brg::with(['inventory'])->where('inv_brg_id', $id)->latest()->get(),
            'kondisi' => [
                ['name' => 'Bagus'],
                ['name' => 'Rusak'],
                ['name' => 'Layak Dipakai'],
                ['name' => 'Tidak Layak Dipakai'],
                ['name' => 'Rusak Parah'],
                ['name' => 'Baru'],
            ],
            'status' => [
                ['name' => 'Tersedia'],
                ['name' => 'Tidak Tersedia'],
                ['name' => 'Hilang'],
                ['name' => 'Dipinjam'],
                ['name' => 'Habis'],
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'kondisiBarang' => Kondisi_Brg::find($id),
        ];
        return view('admin.barang.kondisiBarang.edit', $data);
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
        $kondisi = Kondisi_Brg::find($id);
        $inv_brg_id = $kondisi->inv_brg_id;
        $kondisi->delete();
        toastr()->success('Data berhasil dihapus.');
        return redirect()->route('kondisiBarang.show', $inv_brg_id);
    }
}
