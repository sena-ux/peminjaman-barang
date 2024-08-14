<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    protected $service;

    public function index()
    {
        $peminjaman = Peminjaman::with('user')->where('status_pengembalian', 'belum dikembalikan')->get();

        $data = [
            'peminjaman' => $peminjaman,
            'barang' => Barang::get(),
        ];

        return view('Peminjaman.index', $data);
    }

    public function add(Request $request)
    {
        $data = [
            'siswa' => User::where('role', 'siswa')->get(),
            'barang' => Barang::get(),
        ];
        return view("Peminjaman.add_peminjaman", $data);
    }

    public function store(Request $request)
    {
        $validatedData  = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'nama_barang' => 'required|array',
            'tanggal_pinjam' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        
        $data = [
            'user_id' => $request->input('name'),
            'token' => $request->input('_token'),
            'nama_barang' => implode(', ', $request->input('nama_barang')),
            'tanggal_pinjam' => $request->input('tanggal_pinjam'),
            'keperluan' => $request->input('keperluan'),
            'status_pengembalian' => 'belum dikembalikan',
        ];

        Peminjaman::create($data);

        return redirect()->route('home')->with('success', 'Peminjaman berhasil di simpan successful!');
    }

    public function pengembalian($token, Request $request)
    {
        $request->validate([
            'barang_yang_dikembalikan' => 'required|array',
        ]);

        $data = [
            'barang_yang_dikembalikan' => implode(', ', $request->input('barang_yang_dikembalikan')),
            'status_pengembalian' => 'sudah dikembalikan'
        ];

        $peminjaman = Peminjaman::where('token', $token)->firstOrFail()->update($data);

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan!');
    }

}
