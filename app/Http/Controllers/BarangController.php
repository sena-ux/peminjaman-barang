<?php

namespace App\Http\Controllers;

use App\DataTables\BarangDataTable;
use App\Exports\TemplateImportDataBarang;
use App\Exports\TemplateSiswaImport;
use App\Imports\ImportDataBarang;
use App\Models\Amount;
use App\Models\Barang;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BarangDataTable $dataTable)
    {
        return $dataTable->render('admin/barang/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'categorys' => Category::all()
        ];
        return view('admin.barang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:barangs,nama_barang',
                'sumber_dana' => 'required',
                'tahun_pengadaan' => 'required',
                'category' => 'required',
                'foto_barang' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            ]);

            if ($request->hasFile('foto_barang')) {
                $foto_barang = $request->file('foto_barang');
                $foto_barangName = time() . '_' . $foto_barang->getClientOriginalName();
                $fotoBarangPath = $foto_barang->move(public_path('uploads/barang'), $foto_barangName);

                $optimizerChain = OptimizerChainFactory::create();
                $optimizerChain->optimize($fotoBarangPath);

                $foto_barang_path = 'uploads/barang/' . $foto_barangName;

                Barang::updateOrCreate(['nama_barang' => $request->name],[
                    'nama_barang' => $request->name,
                    'sumber_dana' => $request->sumber_dana,
                    'deskripsi' => $request->deskripsi,
                    'harga' => $request->harga_barang ?? 0,
                    'tahun_pengadaan' => $request->tahun_pengadaan,
                    'foto_barang' => $foto_barang_path,
                    'total_barang' => $request->total_barang ?? 0,
                    'id_category' => $request->category,
                ]);
            }
            toastr()->success('Barang new created successfully!');
            return redirect()->back();
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

    public function templateImport()
    {
        return Excel::download(new TemplateImportDataBarang, 'template_import_barang.xlsx');
    }

    public function importBarang(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $dataGagal = 0;
            $dataSukses = 0;
            $failedItemsString = '';

            try {
                $import = new ImportDataBarang($dataGagal, $dataSukses, $failedItemsString);
                $import->import($file);
                return response()->json([
                    'data' => 'Users imported successfully.',
                    'success_count' => $dataSukses,
                    'failed_count' => $dataGagal,
                    'failedItemsString' => $failedItemsString,
                ], 201);
            } catch (\Exception $ex) {
                return response()->json(['data' => 'Error: ' . $ex->getMessage()], 400);
            }
        }

        return response()->json(['data' => 'No file received'], 400);
    }
}
