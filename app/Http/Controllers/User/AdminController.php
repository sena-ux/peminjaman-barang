<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\user\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'admins' => Admin::with(['user'])->latest()->get(),
        ];
        return view('admin.admin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:users,email',
                'username' => 'required|string|unique:users,username|min:4|regex:/^\S*$/',
                'password' => 'required|min:8|confirmed',
            ]);

            $user = User::create([
                'email' => $request->post('email'),
                'username' => $request->post('username'),
                'password' => $request->post('password'),
                'role' => 'admin',
            ]);
            $user->assignRole('admin');
            Admin::create([
                'user_id' => $user->id,
                'name' => $request->post('name'),
                'alamat' => $request->post('alamat') ?? NULL,
                'no_hp' => $request->post('no_hp') ?? NULL,
                'gender' => $request->post('gender') ?? NULL,
            ]);
            toastr()->success('Data has been saved successfully!');
            return redirect()->route('admin.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'admin' => Admin::with(['user'])->find($id),
        ];
        toastr()->success('Edit admin dengan username ' . $data['admin']->user->username);
        return view('admin.admin.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'admin' => Admin::with(['user'])->find($id),
        ];
        toastr()->success('Edit admin dengan username ' . $data['admin']->user->username);
        return view('admin.admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:users,email,' . $id,
                'username' => 'required|string|unique:users,username,' . $id . '|min:4|regex:/^\S*$/',
                'alamat' => 'nullable|string',
                'no_hp' => 'nullable|numeric',
                'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            ]);
        
            $user = User::with('admin')->findOrFail($id);
            $user->email = $request->email;
            $user->username = $request->username;
            $user->save();
        
            $admin = $user->admin;
            $admin->name = $request->name ?? $admin->name;
            $admin->alamat = $request->alamat ?? $admin->alamat;
            $admin->no_hp = $request->no_hp ?? $admin->no_hp;
            $admin->gender = $request->gender ?? $admin->gender;
            $admin->save();
        
            toastr()->success('Data has been updated successfully!');
            return redirect()->route('admin.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error('Validation Error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        toastr()->success('Delete admin successfully!');
        return redirect()->route('admin.index');
    }
}
