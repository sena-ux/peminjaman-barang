<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\Barang\Kondisi_Brg;
use App\Models\InventoryBarang as inventoryBarangModel;
use App\Models\Ruangan;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryBarang extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $page = 'index', $paginate = 10, $dataBarang, $dataRuangan, $kondisi, $status;

    public $barang, $ruangan, $kode_barang, $kondisiData, $statusData, $date, $updated_at, $inv_brg_id, $jumlah_barang;
    public $kondisiBarang = [];

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
        try {
            $kode_barang = $this->kode_barang ?? $this->generateKodeBarang();
            $this->validate([
                'kode_barang' => 'unique:inventory_barangs',
                'barang' => 'required',
                'ruangan' => 'required',
            ]);
            $inv_brg = inventoryBarangModel::createOrFirst(['id_barang' => $this->barang], [
                // 'kondisi' => $this->kondisiData,
                'id_barang' => $this->barang,
                'id_ruangan' => $this->ruangan,
                'kode_barang' => $kode_barang,
                'jumlah' => $this->jumlah_barang,
                // 'status_barang' => $this->statusData,
                'tanggal' => now()->toDateString()
            ]);

            // Kondisi_Brg::create([
            //     'inv_brg_id' => $inv_brg->id,
            //     'date' => $this->date,
            //     'status_barang' => $inv_brg->id,
            //     'kondisi' => $inv_brg->id,
            // ]);
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
            $kodeBarang = $prefix . '-' . uniqid() . $randomString;
            $exists = inventoryBarangModel::where('kode_barang', $kodeBarang)->exists();
        } while ($exists);

        return $kodeBarang;
    }

    // ================= Kondisi Barang ====================
    public function deleteKondisi($kondisi_id)
    {
        $barang = Kondisi_Brg::find($kondisi_id);

        if ($barang) {
            if (file_exists(public_path('uploads/kondisiBarang/' . $barang->images))) {
                unlink(public_path('uploads/kondisiBarang/' . $barang->images));
            }

            $barang->delete();
            $this->kondisiBarang = Kondisi_Brg::all();
            toastr()->success('Data berhasil dihapus.');
        }
        $this->page = 'show';
    }
}
