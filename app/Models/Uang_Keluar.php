<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uang_Keluar extends Model
{
    use HasFactory;
    protected $table = "uang_keluars";

    protected $fillable = [
        'id_lokasi_uang', 'created_by', 'jumlah', 'keterangan', 'file',
    ];

    public function Lokasi_Uang() {
        return $this->hasOne(Lokasi_Uang::class,'id','id_lokasi_uang');
    }
}
