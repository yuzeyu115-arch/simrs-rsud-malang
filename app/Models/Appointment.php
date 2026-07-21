<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

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

    protected $casts = [
        'tanggal_janji' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
