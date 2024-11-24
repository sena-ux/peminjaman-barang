<?php

namespace App\Models\Barang;

use App\Models\InventoryBarang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;

class Kondisi_Brg extends Model
{
    // use InteractsWithMedia;
    use HasFactory;
    protected $guarded = [];

    // public function registerMediaCollections(): void
    // {
    //     $this->addMediaCollection('images')
    //         ->useDisk('kondisiBarang');
    // }

    /**
     * Get the inventory that owns the Kondisi_Brg
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(InventoryBarang::class, 'inv_brg_id', 'id');
    }
}
