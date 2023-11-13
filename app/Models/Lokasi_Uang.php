<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi_Uang extends Model
{
    use HasFactory;
    protected $table = "lokasi_uangs";

    protected $fillable = [
        'id', 'nama', 'keterangan',
    ];
}
