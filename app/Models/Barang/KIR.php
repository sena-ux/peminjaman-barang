<?php

namespace App\Models\Barang;

use App\Models\Ruangan;
use App\Models\Siswa;
use App\Models\Umum\RiwayatKIR;
use App\Models\Umum\Setting;
use App\Models\user\Staff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KIR extends Model
{
    protected $guarded = [];

    /**
     * Get the barang that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    /**
     * Get the siswa that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    /**
     * Get the ruangan that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id');
    }

    /**
     * Get the kepala_sekolah that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kepala_sekolah(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'kepala_sekolah_id', 'id');
    }

    /**
     * Get the pengelola that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengelola(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'pengelola_id', 'id');
    }

    /**
     * Get the wali that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wali(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'wali_id', 'id');
    }

    /**
     * Get the setting that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class, 'setting_id', 'id');
    }

    /**
     * Get the riwayat that owns the KIR
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function riwayat(): BelongsTo
    {
        return $this->belongsTo(RiwayatKIR::class, 'riwayat_id', 'id');
    }
}
