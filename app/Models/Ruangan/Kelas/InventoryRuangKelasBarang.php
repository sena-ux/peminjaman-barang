<?php

namespace App\Models\Ruangan\Kelas;

use App\Models\Kelas;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryRuangKelasBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the barang that owns the InventoryRuangKelasBarang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangRK::class, 'id_barangrk', 'id');
    }

    /**
     * Get the kelas that owns the InventoryRuangKelasBarang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    /**
     * Get all of the tanggapan for the InventoryRuangKelasBarang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tanggapan(): HasMany
    {
        return $this->hasMany(Tanggapan::class, 'id', 'id_tanggapan');
    }

    /**
     * Get the user that owns the InventoryRuangKelasBarang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
