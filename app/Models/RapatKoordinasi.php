<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RapatKoordinasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rapat_koordinasi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'judul_rapat',
        'waktu_pelaksanaan',
        'lokasi',
        'deskripsi',
        'dibuat_oleh',
    ];

    protected $casts = [
        'waktu_pelaksanaan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function peserta()
    {
        return $this->belongsToMany(User::class, 'peserta_rapat', 'rapat_id', 'user_id')->withPivot('status_kehadiran');
    }
}
