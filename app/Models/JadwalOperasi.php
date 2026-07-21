<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalOperasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jadwal_operasi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pasien_id',
        'ruang_operasi_id',
        'bed_id',
        'jenis_operasi',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'catatan',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function ruangOperasi()
    {
        return $this->belongsTo(RuangOperasi::class);
    }

    public function timOperasi()
    {
        return $this->belongsToMany(User::class, 'tim_operasi', 'jadwal_operasi_id', 'user_id')->withPivot('peran');
    }

    public function pemakaianOperasi()
    {
        return $this->hasMany(PemakaianOperasi::class);
    }

}
