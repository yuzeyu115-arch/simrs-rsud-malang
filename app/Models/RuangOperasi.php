<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuangOperasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ruang_operasi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_ruangan',
        'status',
        'kapasitas_bed',
        'catatan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

    public function jadwalOperasi()
    {
        return $this->hasMany(JadwalOperasi::class);
    }
}
