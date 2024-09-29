<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/peminjaman/barang', [PeminjamanController::class, 'index'])->name('peminjaman.barang');
Route::get('/add', [PeminjamanController::class, 'add'])->name('create.peminjaman');
Route::post('/add', [PeminjamanController::class, 'store'])->name('createPeminjaman');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'register'])->name('login');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/pengembalian/{token}', [PeminjamanController::class, 'pengembalian'])->name('pengembalian');
Route::post('/pengaduan/create', [PengaduanController::class, 'add'])->name('pengaduan.create');
