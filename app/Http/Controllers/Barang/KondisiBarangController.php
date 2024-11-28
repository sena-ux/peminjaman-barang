<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use App\Models\Barang\Kondisi_Brg;
use App\Models\InventoryBarang;
use Illuminate\Http\Request;
use Spatie\Image\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class KondisiBarangController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'kondisi' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            ]);

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $imagesName = time() . '_' . $images->getClientOriginalName();
                $path = 'uploads/kondisiBarang/';
                $imagePath =  $images->move(public_path($path), $imagesName);

                // Image::load($imagePath)
                //     ->width(250)
                //     ->height(250)
                //     ->optimize()
                //     ->save($imagePath);

                // Optimalkan gambar
                $optimizerChain = OptimizerChainFactory::create();
                $optimizerChain->optimize($imagePath);

                $imagePath = $path . '/' . $imagesName;

                Kondisi_Brg::create([
                    'inv_brg_id' => $request->inv_brg_id,
                    'date' => $request->date,
                    'kondisi' => $request->kondisi,
                    'status_barang' => $request->status,
                    'keterangan' => $request->keterangan,
                    'images' => $imagePath,
                ]);

                InventoryBarang::find($request->inv_brg_id)->update(['status_barang' => $request->status, 'kondisi' => $request->kondisi]);
                toastr()->success('Barang new created successfully!');
                return redirect()->route('inventory.index');
            }

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
}
