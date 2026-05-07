<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananMenu extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_menu';

    protected $fillable = [
        'ruang',
        'kelas',
        'nama_pasien',
        'shift',
        'tanggal',
        'catatan',
    ];
}
