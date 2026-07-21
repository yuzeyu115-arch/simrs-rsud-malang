<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemakaianOperasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pemakaian_operasi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'jadwal_operasi_id',
        'inventaris_id',
        'jumlah_dipakai',
        'dicatat_oleh',
    ];

    protected $casts = [
        'waktu_pencatatan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function jadwalOperasi()
    {
        return $this->belongsTo(JadwalOperasi::class);
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function dicatatOleh()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
