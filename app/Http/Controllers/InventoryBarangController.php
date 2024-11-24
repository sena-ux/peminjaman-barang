<?php

namespace App\Http\Controllers;

use App\Models\InventoryBarang;
use Illuminate\Http\Request;

class InventoryBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/barang/inventory/index');
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
    public function show(string $id, Request $request)
    {
        $orderby = $request->get('orderby');

        $inventoryQuery = InventoryBarang::with(['barang.amount', 'ruangan', 'barang.category'])->where('id_barang', intval($id));

        if ($orderby) {
            $inventoryQuery->where(function ($query) use ($orderby) {
                $query->whereHas('barang.category', function ($q) use ($orderby) {
                    $q->where('name', 'LIKE', "%{$orderby}%");
                });
                
                $query->orWhere('kondisi', 'LIKE', "%{$orderby}%");

                $query->orWhereHas('barang', function ($q) use ($orderby) {
                    $q->where('sumber_dana', 'LIKE', "%{$orderby}%")
                        ->orWhere('pengadaan', 'LIKE', "%{$orderby}%");
                });
            });
        }

        return $inventoryQuery->paginate(5);
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
