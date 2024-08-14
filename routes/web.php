<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;

Route::get('/', [PeminjamanController::class, 'index'])->name('home');
Route::get('/add', [PeminjamanController::class, 'add'])->name('create.peminjaman');
Route::post('/add', [PeminjamanController::class, 'store'])->name('createPeminjaman');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);
Route::post('/pengembalian/{token}', [PeminjamanController::class, 'pengembalian'])->name('pengembalian');
