<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Siswa;
use App\Models\user\Admin;
use App\Models\user\Staff;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $data = [
            "siswa" => Siswa::all(),
            "siswaCount" => Siswa::count(),
            "adminCount" => Admin::count(),
            "stafCount" => Staff::count(),
            "pengaduanCount" => Pengaduan::where('status_pengaduan', '!', 'Selesai')->count(),
        ];
        flash()->success("Aplikasi ready!");
        return view("admin.home", $data);
    }

}
