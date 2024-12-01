<?php

namespace App\Http\Controllers\RolePermission\Permission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AsignToUserController extends Controller
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
        //
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
        $data = [
            'role' => User::find($id),
            'permissions' => Permission::all()->groupBy('group'),
        ];
        return view('admin.permission.asignToUser.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $role = User::findOrFail($id);

            // Ambil permissions dari request
            $permissions = $request->input('permissions', []);

            // Sinkronisasi permissions dengan role
            $role->syncPermissions($permissions);

            return redirect()->back()->with('success', 'Permissions updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error updating permissions: ' . $th->getMessage());
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
