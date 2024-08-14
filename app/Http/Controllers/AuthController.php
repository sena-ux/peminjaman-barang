<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register()
    {
        return view("auth/register");
    }

    public function store(Request $request)
    {
        $validatedData  = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string|max:255',
            'nisn' => 'required|numeric|unique:users,nisn',
            'nis' => 'required|numeric',
            'kelas' => 'required|string|max:10',
            'telp' => 'required|numeric',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        User::create($request->all());

        return redirect()->route('create.peminjaman')->with('success', 'Registration successful!');
    }
}
