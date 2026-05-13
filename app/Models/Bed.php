<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bed extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'bed';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'ruang_operasi_id',
        'kode_bed',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function ruangOperasi()
    {
        return $this->belongsTo(RuangOperasi::class);
    }

    public function jadwalOperasi()
    {
        return $this->hasMany(JadwalOperasi::class);
    }
}
