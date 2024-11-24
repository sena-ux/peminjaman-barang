<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $guarded = ["id_pengaduan"];
    protected $primaryKey = 'id_pengaduan';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id_barang');
    }

    public function pelapor()
    {
        return $this->belongsTo(Pelapor::class, 'id_pelapor', 'id_pelapor');
    }
    use HasFactory;
}
