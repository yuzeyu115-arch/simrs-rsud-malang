<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FastLogistic extends Model
{
    use HasFactory;

    protected $table = 'fast_logistics';

    protected $fillable = [
        'total_bius_tersedia',
        'jumlah_cairan_infus',
        'jumlah_alat_bedah_steril',
        'terakhir_dicek',
    ];
}
