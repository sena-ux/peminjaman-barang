<?php

namespace App\Models;

use App\Models\Barang\KIR;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the kelas that owns the Ruangan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    /**
     * Get all of the kir for the Ruangan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kir(): HasMany
    {
        return $this->hasMany(KIR::class, 'ruangan_id', 'id');
    }
}
