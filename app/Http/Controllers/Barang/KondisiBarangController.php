<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use App\Models\Barang\Kondisi_Brg;
use App\Models\InventoryBarang;
use Illuminate\Http\Request;

class KondisiBarangController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'kondisi' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // $kondisi = Kondisi_Brg::where('kondisi', $request->kondisi)->get();
            // $statusBarang = Kondisi_Brg::where('status_barang', $request->status)->get();
            // if ($kondisi->isEmpty() && $statusBarang->isEmpty()) {
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $imagesName = time() . '_' . $images->getClientOriginalName();
                $images->move(public_path('uploads/kondisiBarang'), $imagesName);

                Kondisi_Brg::create([
                    'inv_brg_id' => $request->inv_brg_id,
                    'date' => $request->date,
                    'kondisi' => $request->kondisi,
                    'status_barang' => $request->status,
                    'images' => $imagesName
                ]);

                InventoryBarang::find($request->inv_brg_id)->update(['status' => $request->status_barang, 'kondisi' => $request->kondisi]);

                toastr()->success('Barang new created successfully!');
                return redirect()->route('inventory.index');
            }
            // } 
            // if($kondisi->isNotEmpty()){
            //     toastr()->error('Kondisi ' . $request->kondisi . ' sudah terinput sebelumnya.');
            //     return redirect()->back();
            // }
            // if($statusBarang->isNotEmpty()){
            //     toastr()->error('Status Barang ' . $request->status . ' sudah terinput sebelumnya.');
            //     return redirect()->back();
            // }

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
