<?php

use App\Http\Controllers\Barang\KondisiBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryBarangController;
use App\Http\Controllers\InventoryBarangRuanganController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\Pengaduan\InventoryRuangKelasBarangController;
use App\Http\Controllers\Pengaduan\KerusakanUmumController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Regulasi\BarangPinjamController;
use App\Http\Controllers\Regulasi\PemeliharaanController;
use App\Http\Controllers\Regulasi\PeminjamanBarangController;
use App\Http\Controllers\RolePermission\Permission\AsignToModelController;
use App\Http\Controllers\RolePermission\Permission\AsignToRoleController;
use App\Http\Controllers\RolePermission\Permission\AsignToUserController;
use App\Http\Controllers\RolePermission\PermissionController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Tanggapan\TanggapanController;
use App\Http\Controllers\Umum\KerusakanController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\StafController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('user/siswa', SiswaController::class);
        Route::post('/reset/all/password/siswa', [SiswaController::class, 'reserAllPasswordUser'])->name('resetAllPasswordSiswa');
        //Import dan Export
        Route::get('download/template/import/siswa', [SiswaController::class, 'templateImport'])->name('siswa.templateImport');
        Route::get('import/siswa', [SiswaController::class, 'getImport'])->name('siswa.getImport');
        Route::post('import/siswa', [SiswaController::class, 'import'])->name('siswa.import');
        Route::delete('delete/selected/siswa', [SiswaController::class, 'siswaSelected'])->name('siswa.selected');

        // =================== Role Permission ========================
        Route::get('role', function () {
            return view('admin.role.index');
        })->name('role.index')->middleware('role:superadmin');

        Route::get('asignrole', function () {
            return view('admin.role.asign');
        })->name('asignrole.index')->middleware('role:superadmin');
        Route::resource('permission', PermissionController::class)->middleware('role:superadmin');
    });
    // ===================== Barang ============================
    Route::middleware(['role:admin|petugas|staf|superadmin'])->group(function () {
        Route::resource('barang', BarangController::class);
        Route::resource('barang/inventoryBarangModel/barang/inventory/kondisiBarang', KondisiBarangController::class);
        Route::resource('barang/inventoryBarangModel/barang/inventory', InventoryBarangController::class);
        Route::post('import/barang', [BarangController::class, 'importBarang'])->name('import.barang');
        Route::get('download/template/import/barang', [BarangController::class, 'templateImport'])->name('siswa.templateImport');
        // Regulasi
        Route::get('regulasi/pemeliharaan', [PemeliharaanController::class, 'index'])->name('pemeliharaan.index');
        Route::post('regulasi/pemeliharaan/create', [PemeliharaanController::class, 'store'])->name('pemeliharaan.store');
        Route::get('regulasi/pemeliharaan/create', [PemeliharaanController::class, 'create'])->name('pemeliharaan.create');
        Route::get('regulasi/pemeliharaan/{codepem}/edit', [PemeliharaanController::class, 'edit'])->name('pemeliharaan.edit');
        Route::post('regulasi/pemeliharaan/update/{idpem}', [PemeliharaanController::class, 'update'])->name('pemeliharaan.update');

        Route::post('create-new-kondisi-barang/new', [KondisiBarangController::class, 'store'])->name('create-kondisi-barang');

        Route::get('category', function () {
            return view('admin.category.index');
        })->name('category.index');

        Route::get('ruangan', function () {
            return view('admin.ruangan.index');
        })->name('ruangan.index');

        Route::post('ruangan/import', [RuanganController::class, "importRuangan"])->name('import.ruangan');

        Route::get('kelas', function () {
            return view('admin.kelas.index');
        })->name('kelas.index');
        Route::post('kelas/import', [KelasController::class, "importKelas"])->name('import.kelas');

        Route::get('sarana', function () {
            return view('admin.sarana.index');
        })->name('sarana.index');

        // Kerusakan
        Route::resource('kerusakan', KerusakanController::class);
        Route::resource('permission/asignToRole', AsignToRoleController::class)->middleware('role:superadmin');
        Route::resource('permission/asignToUser', AsignToUserController::class)->middleware('role:superadmin');

        // ======================== Barang Pinjam =========================
        Route::resource('peminjaman/barangPinjam', BarangPinjamController::class);
        Route::resource('peminjaman/barangPinjam/peminjaman/peminjamanBarang', PeminjamanBarangController::class);
    });

    Route::middleware(['role:admin|superadmin'])->group(function () {
        Route::resource('user/admin', AdminController::class);
        Route::get('user/staf', function () {
            return view('admin.staf.index');
        })->name('staf.index');
    });
});

Route::post('/upload', [UploadsController::class, 'store']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pengaduan/umum', KerusakanUmumController::class);
    Route::get('get/data/pengaduan', [KerusakanUmumController::class, 'getdataUser'])->name('get.data');

    Route::resource('tanggapan', TanggapanController::class);

    Route::resource('inventory/barangrk', InventoryRuangKelasBarangController::class);
    Route::post('inventory/barangrk/tanggapi', [TanggapanController::class, 'tanggapiBarangRK'])->name('barangrk.tanggapi');
});

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');


Route::get('/ujicoba', function () {
    return view('admin.ujicoba');
});

Route::get('/peminjaman/barang', [PeminjamanController::class, 'index'])->name('peminjaman.barang');
Route::get('/add', [PeminjamanController::class, 'add'])->name('create.peminjaman');
Route::post('/add', [PeminjamanController::class, 'store'])->name('createPeminjaman');
Route::post('/pengembalian/{token}', [PeminjamanController::class, 'pengembalian'])->name('pengembalian');
Route::post('/pengaduan/create', [PengaduanController::class, 'add'])->name('pengaduan.create');
