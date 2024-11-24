<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    protected $guarded = ["id_pelapor"];

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
    use HasFactory;
}
