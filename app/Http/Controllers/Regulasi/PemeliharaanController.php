<?php

namespace App\Http\Controllers\Regulasi;

use App\Http\Controllers\Controller;
use App\Models\InventoryBarang;
use App\Models\Regulasi\Pemeliharaan;
use App\Models\Sarana;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    public function index()
    {
        return view('admin.regulasi.pemeliharaan.index');
    }

    public function create()
    {
        $data = [
            'sarana' => Sarana::all(),
        ];
        return view('admin.regulasi.pemeliharaan.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'sarana_id' => 'required|string',
                'kode_barang' => '',
                'jenis_pemeliharaan' => 'required|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date',
                'biaya' => 'required|string|max:255',
                'sumber_dana' => 'required|string|max:255',
                'penanggung_jawab' => 'required|string',
                'kondisi_sebelum' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'kondisi_sesudah' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'dokumen_pendukung' => 'required|string',
            ]);

            $uploadPath = 'uploads/regulasi/pemeliharaan';

            if ($request->hasFile('kondisi_sebelum')) {
                $fotoSebelum = $request->file('kondisi_sebelum');
                $fotoSebelumName = time() . '_sebelum_' . $fotoSebelum->getClientOriginalName();
                $fotoSebelum->move(public_path($uploadPath), $fotoSebelumName);
                $validatedData['kondisi_sebelum'] = $uploadPath . $fotoSebelumName;
            }

            if ($request->hasFile('kondisi_sesudah')) {
                $fotoSesudah = $request->file('kondisi_sesudah');
                $fotoSesudahName = time() . '_sesudah_' . $fotoSesudah->getClientOriginalName();
                $fotoSesudah->move(public_path($uploadPath), $fotoSesudahName);
                $validatedData['kondisi_sesudah'] = $uploadPath . $fotoSesudahName;
            }
            $validatedData['kode_pemeliharaan'] = $this->generateKode();

            Pemeliharaan::create($validatedData);

            toastr()->success('Pemeliharaan berhasil dibuat!');
            return redirect()->route('pemeliharaan.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error('Kesalahan Validasi: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($codepem)
    {
        $data = [
            'pem' => Pemeliharaan::with(['sarana'])->where('kode_pemeliharaan', $codepem)->get()->first(),
            'sarana' => Sarana::all(),
        ];
        return view('admin.regulasi.pemeliharaan.edit', $data);
    }

    public function update(Request $request , $idpem)
    {
        try {
            $validatedData = $request->validate([
                'sarana_id' => 'required|string',
                'kode_barang' => '',
                'jenis_pemeliharaan' => 'required|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date',
                'biaya' => 'required|string|max:255',
                'sumber_dana' => 'required|string|max:255',
                'penanggung_jawab' => 'required|string',
                'kondisi_sebelum' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'kondisi_sesudah' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'dokumen_pendukung' => 'required|string',
            ]);

            $uploadPath = 'uploads/regulasi/pemeliharaan';

            $data_pem = Pemeliharaan::find($idpem);

            if ($request->hasFile('kondisi_sebelum')) {
                if (file_exists(public_path($data_pem->kondisi_sebelum))) {
                    unlink(public_path($data_pem->kondisi_sebelum));
                }
                $fotoSebelum = $request->file('kondisi_sebelum');
                $fotoSebelumName = time() . '_sebelum_' . $fotoSebelum->getClientOriginalName();
                $validatedData['kondisi_sebelum'] = $fotoSebelum->move(public_path($uploadPath), $fotoSebelumName);
            }

            if ($request->hasFile('kondisi_sesudah')) {
                if (file_exists(public_path($data_pem->kondisi_sesudah))) {
                    unlink(public_path($data_pem->kondisi_sesudah));
                }
                $fotoSesudah = $request->file('kondisi_sesudah');
                $fotoSesudahName = time() . '_sesudah_' . $fotoSesudah->getClientOriginalName();
                $validatedData['kondisi_sesudah'] = $fotoSesudah->move(public_path($uploadPath), $fotoSesudahName);
            }
            $validatedData['kode_pemeliharaan'] = $data_pem->kode_pemeliharaan;
            $validatedData['status'] = 'Validasi';
            $validatedData['keterangan'] = 'Kembali validasi data.';

            $data_pem->update($validatedData);

            toastr()->success('Pemeliharaan berhasil di-Update!');
            return redirect()->route('pemeliharaan.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error('Kesalahan saat update data.');
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            toastr()->error('Terjadi kesalahan saat update data.');
            return redirect()->back()->withInput();
        }
    }

    private function generateKode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = 4;

        do {
            $kodepmlh = substr(str_shuffle($characters), 0, $length);
            $exists = Pemeliharaan::where('kode_pemeliharaan', $kodepmlh)->exists();
        } while ($exists);

        return $kodepmlh;
    }
}
