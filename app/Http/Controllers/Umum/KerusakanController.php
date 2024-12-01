<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Models\Umum\Kerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KerusakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kerusakan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.kerusakan.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'tingkat_kerusakan' => 'required|string',
                'detail_kerusakan' => 'required',
            ]);
            $validated['id_pelapor'] = Auth::user()->id;
            Kerusakan::create($validated);
            toastr()->success("Kerusakan created successfully.");
            return redirect()->route('kerusakan.index');
        } catch (\Throwable $th) {
            toastr()->error("Terjadi kesalahan saat insert kerusakan. " . $th->getMessage());
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
        return view("admin.kerusakan.edit", [
            'kerusakan' => Kerusakan::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'tingkat_kerusakan' => 'required|string',
                'detail_kerusakan' => 'required',
            ]);

            Kerusakan::find($id)->update($validated);
            toastr()->success("Kerusakan created successfully.");
            return redirect()->route('kerusakan.index');
        } catch (\Throwable $th) {
            toastr()->error("Terjadi kesalahan saat insert kerusakan. " . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
