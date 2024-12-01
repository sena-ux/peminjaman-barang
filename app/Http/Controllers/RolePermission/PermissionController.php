<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.permission.index');
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

    // ========================= Asign Role Permission =====================
    public function asignRole()
    {
        $this->roles = Role::latest()->get();
        $this->page = "asignRole";
    }

    public function asignRolePermission($id)
    {
        try {
            $this->role = Role::find($id);
            $this->permissionsAll = Permission::all();
            $this->page = "asignRolePermission";
            toastr()->success('Data load success.');
        } catch (\Throwable $th) {
            toastr()->error("terjadi kesalahan" . $th->getMessage());
        }
    }

    public function asignRolePermissionStore(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            // Ambil permissions dari request
            $permissions = $request->input('permissions', []);

            // Sinkronisasi permissions dengan role
            $role->syncPermissions($permissions);

            return redirect()->back()->with('success', 'Permissions updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error updating permissions: ' . $th->getMessage());
        }
    }
}
