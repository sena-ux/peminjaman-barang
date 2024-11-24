<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\user\Admin;
use Flasher\Toastr\Laravel\Facade\Toastr;
use Illuminate\Http\Request;

class StafController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [

        ];
        return view('admin.admin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin.show');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|regex:/^\S*$/',
            'password' => 'required|confirmed|min:8|max:20',
        ]); 
        $user = User::create($request->all());
        $request['user_id'] = $user->id;
        Admin::create($request->all());
        toastr()->success('Create admin has successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            "admin" => Admin::with('user')->find($id),
        ];
        return view('admin.admin.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            "admin" => Admin::with('user')->find($id),
        ];
        return view('admin.admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|regex:/^\S*$/',
            'password' => 'required|confirmed|min:8|max:20',
        ]);
        Admin::find($id)->with('user')->update($request->all());
        toastr()->success('Update admin has successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        toastr()->success('Delete admin has successfully');
    }
}
