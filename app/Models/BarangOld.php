<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BarangOld extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Get all of the inventoryBarang for the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventoryBarang(): HasMany
    {
        return $this->hasMany(InventoryBarang::class, 'id_barang', 'id');
    }

    /**
     * Get the amount that owns the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function amount(): BelongsTo
    // {
    //     return $this->belongsTo(Amount::class, 'id_amount', 'id');
    // }

    /**
     * Get the category that owns the Barang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }
}
