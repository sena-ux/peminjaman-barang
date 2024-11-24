<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Siswa extends Model
{
    use HasFactory, HasRoles;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa() {
        return $this->hasOne(Siswa::class,'user_id');
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
}
