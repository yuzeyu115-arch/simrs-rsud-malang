<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPemesanan extends Model
{
    use HasFactory;

    protected $table = 'laporan_pemesanan';

    protected $fillable = [
        'nama',
        'jam_pesan',
        'jam_kirim',
        'jam_lapor',
        'status',
    ];
}
