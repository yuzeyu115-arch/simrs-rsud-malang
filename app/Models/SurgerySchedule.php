<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgerySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'nomor_rm',
        'dokter_bedah_id',
        'dokter_anestesi_id',
        'ruang_id',
        'tanggal_operasi',
        'jam_mulai',
        'jenis_tindakan',
        'status',
    ];
}
