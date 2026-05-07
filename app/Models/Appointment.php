<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'nomor_rm',
        'tanggal_janji',
        'jam_janji',
        'poliklinik',
        'dokter_tujuan',
        'jenis',
        'prioritas',
        'status',
        'catatan',
    ];
}
