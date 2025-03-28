<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangPerkuliahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ruang',
        'kapasitas_ruang',
        'lokasi',
        'fakultas_id',
    ];
}
