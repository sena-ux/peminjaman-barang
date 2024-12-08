<?php

namespace App\Livewire\Barang;

use App\Models\Barang\Barang;
use App\Models\Barang\Kondisi_Brg;
use App\Models\InventoryBarang as inventoryBarangModel;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryBarang extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $page = 'index', $paginate = 10, $dataBarang, $dataRuangan, $kondisi, $status;

    public $barang, $ruangan, $kode_barang, $kondisiData, $statusData, $date, $updated_at, $inv_brg_id, $jumlah_barang, $alatKebersihan, $inventoryBarang;
    public $kondisiBarang = [], $detail_kondisi;

    public function __construct()
    {
        $this->dataBarang = Barang::all();
        $this->dataRuangan = Ruangan::all();
        $this->kondisi = [
            ['name' => 'Bagus'],
            ['name' => 'Rusak'],
            ['name' => 'Layak Dipakai'],
            ['name' => 'Tidak Layak Dipakai'],
            ['name' => 'Rusak Parah'],
            ['name' => 'Baru'],
        ];
        $this->status = [
            ['name' => 'Tersedia'],
            ['name' => 'Tidak Tersedia'],
            ['name' => 'Hilang'],
            ['name' => 'Dipinjam'],
            ['name' => 'Habis'],
        ];
    }
    public function create()
    {
        $this->page = 'create';
    }

    public function back()
    {
        $this->page = 'index';
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'kode_barang' => 'unique:inventory_barangs',
                'barang' => 'required',
                'ruangan' => 'required',
            ]);
            $totalBarangDitambahkan = 0;
            if ($this->alatKebersihan == false) {
                for ($i = 1; $i <= intval($this->jumlah_barang); $i++) {
                    $inv_brg = inventoryBarangModel::create([
                        'id_barang' => $this->barang,
                        // 'kondisi' => $this->kondisiData,
                        'id_ruangan' => $this->ruangan,
                        'kode_barang' => $this->generateKodeBarang(),
                        'jumlah' => 1,
                        // 'status_barang' => $this->statusData,
                        'tanggal' => $this->date
                    ]);
                    $totalBarangDitambahkan += 1;
                }
            } else {
                inventoryBarangModel::create([
                    'id_barang' => $this->barang,
                    // 'kondisi' => $this->kondisiData,
                    'id_ruangan' => $this->ruangan,
                    'kode_barang' => $this->generateKodeBarang(),
                    'jumlah' => $this->jumlah_barang,
                    // 'status_barang' => $this->statusData,
                    'tanggal' => $this->date
                ]);
                $totalBarangDitambahkan = $this->jumlah_barang;
            }

            // $jumlahInventoryBarang = inventoryBarangModel::where('id_barang', $this->barang)->pluck("jumlah")->sum();
            // Barang::find($this->barang)->update(['total_barang' => $jumlahInventoryBarang]);

            $barang = Barang::find($this->barang);
            $barang->increment('total_barang', $totalBarangDitambahkan);

            DB::commit();

            toastr()->success('Inventory Barang New saved Successfully!');
            $this->clear();
            $this->page = 'create';
        } catch (\Throwable $th) {
            toastr()->error('Validation Error: ' . $th->getMessage());
            return redirect()->back()->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error('Validation Error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show($id_inv_brg)
    {
        $this->clear();
        $inv_brg = inventoryBarangModel::with(['barang', 'ruangan'])->find($id_inv_brg);
        $this->barang = $inv_brg->barang->nama_barang;
        $this->ruangan = $inv_brg->ruangan->nama_ruangan;
        $this->kode_barang = $inv_brg->kode_barang;
        $this->date = $inv_brg->tanggal;
        $this->updated_at = $inv_brg->updated_at;
        $this->inv_brg_id = $id_inv_brg;
        $this->jumlah_barang = $inv_brg->jumlah;
        $this->kondisiBarang = Kondisi_Brg::with(['inventory'])->where('inv_brg_id', $inv_brg->id)->latest()->get();
        $this->page = 'show';
    }

    public function deleteInventory($id)
    {
        try {
            $inventory = inventoryBarangModel::find($id);
            $kondisi = Kondisi_Brg::where('inv_brg_id', $id)->get();

            $jumlahBarangDihapus = $inventory->jumlah;

            if ($kondisi->isNotEmpty()) {
                foreach ($kondisi as $item) {
                    $item->delete();
                }
            }
            $inventory->delete();

            $barang = Barang::find($inventory->id_barang);
            if ($barang) {
                $barang->decrement('total_barang', $jumlahBarangDihapus);
            }

            toastr()->success("Deleted Inventory Barang Successfully.");
            $this->page = "index";
        } catch (\Throwable $th) {
            toastr()->error("Terjadi kesalahan saat delete Inventory Barang.");
            $this->page = 'index';
        }
    }

    public function edit($id)
    {
        $inventory = inventoryBarangModel::find($id);
        $this->inventoryBarang = $inventory;
        $this->page = 'edit';
        $this->barang = $inventory->id_barang;
        $this->ruangan = $inventory->id_ruangan;
        $this->date = $inventory->tanggal;
        $this->jumlah_barang = $inventory->jumlah;
    }

    public function update($id)
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'jumlah_barang' => 'required|numeric',
            ]);

            $inventory = inventoryBarangModel::find($id);
            $barangLama = Barang::find($inventory->id_barang);

            $totalSebelumDiupdate = $inventory->jumlah;

            // Update data inventory
            $inventory->update([
                'id_barang' => $this->barang,
                'id_ruangan' => $this->ruangan,
                'jumlah' => $this->jumlah_barang,
                'tanggal' => $this->date,
            ]);
            // Update total_barang di tabel Barang
            if ($barangLama->id != $this->barang) {
                // Kurangi total_barang dari barang lama
                $barangLama->decrement('total_barang', $totalSebelumDiupdate);

                // Tambahkan total_barang ke barang baru
                $barangBaru = Barang::find($this->barang);
                $barangBaru->increment('total_barang', $this->jumlah_barang);
            } else {
                $barangLama->decrement('total_barang', $totalSebelumDiupdate);
                // Jika ID barang sama, hanya perbarui jumlah
                $barangLama->increment('total_barang', $this->jumlah_barang);
            }

            DB::commit();

            toastr()->success('Inventory Barang New saved Successfully!');
            $this->clear();
            $this->show($id);
        } catch (\Throwable $th) {
            toastr()->error('Validation Error: ' . $th->getMessage());
            return redirect()->back()->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->error('Validation Error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            toastr()->error('Something went wrong: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function render()
    {
        return view('livewire.barang.inventory-barang', [
            'inventoryBarangs' => inventoryBarangModel::with(['barang', 'ruangan'])->paginate(intval($this->paginate)),
        ]);
    }


    public function clear()
    {
        $this->kondisiData = "";
        $this->statusData = "";
        $this->barang = "";
        $this->ruangan = "";
        $this->jumlah_barang = "";
        $this->kode_barang = "";
    }

    private function generateKodeBarang()
    {
        $prefix = 'BRG';
        $date = Carbon::now()->format('Ymd');
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 1;

        do {
            $randomString = substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
            // $kodeBarang = $prefix . '-' . uniqid() . $randomString;
            $kodeBarang = $prefix . '-' . substr(bin2hex(random_bytes(3)), 0, 3) . $randomString;
            $exists = inventoryBarangModel::where('kode_barang', $kodeBarang)->exists();
        } while ($exists);

        return $kodeBarang;
    }

    // ================= Kondisi Barang ====================
    public function deleteKondisi($kondisi_id)
    {
        $barang = Kondisi_Brg::find($kondisi_id);

        if ($barang->images) {
            if (file_exists(public_path('uploads/kondisiBarang/' . $barang->images))) {
                unlink(public_path('uploads/kondisiBarang/' . $barang->images));
            }
        }
        $barang->delete();

        $kondisi = Kondisi_Brg::where('inv_brg_id', $this->inv_brg_id)->latest()->first();
        inventoryBarangModel::find($this->inv_brg_id)->update(['status_barang' => $kondisi->status_barang ?? null, 'kondisi' => $kondisi->kondisi ?? null]);
        $this->kondisiBarang = Kondisi_Brg::with(['inventory'])->where('inv_brg_id', $this->inv_brg_id)->latest()->get();
        toastr()->success('Data berhasil dihapus.');
        $this->page = 'show';
    }

    public function showDetailKondisi($id)
    {
        $kondisi = Kondisi_Brg::find($id);
        $this->detail_kondisi = $kondisi->detail_kondisi;
        $this->page = 'showDetailKondisi';
    }
}
