<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgerySchedule extends Model
{
    use HasFactory;

    protected $table = 'surgery_schedules';

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
        'waktu_pelaksanaan',
        'finalized_at',
        'finalized_by',
        'catatan_finalisasi',
    ];

    protected $casts = [
        'tanggal_operasi' => 'date',
        'waktu_pelaksanaan' => 'datetime',
        'finalized_at' => 'datetime',
    ];

    // Relationships
    public function dokterBedah()
    {
        return $this->belongsTo(\Illuminate\Database\Eloquent\Model::class, 'dokter_bedah_id')
            ->setTable('dokter_bedah');
    }

    public function dokterAnestesi()
    {
        return $this->belongsTo(\Illuminate\Database\Eloquent\Model::class, 'dokter_anestesi_id')
            ->setTable('dokter_anestesi');
    }

    public function operatingRoom()
    {
        return $this->belongsTo(OperatingRoom::class, 'ruang_id');
    }
}
