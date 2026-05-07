<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InpatientBed extends Model
{
    use HasFactory;

    protected $fillable = [
        'gedung',
        'lantai',
        'ruangan',
        'no_bed',
        'jenis_kamar',
        'status',
        'nama_pasien',
    ];
}
