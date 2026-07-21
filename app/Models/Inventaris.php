<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventaris extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'inventaris';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_barang',
        'kategori',
        'stok_saat_ini',
        'satuan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function pemakaianOperasi()
    {
        return $this->hasMany(PemakaianOperasi::class);
    }

    public function auditInventaris()
    {
        return $this->hasMany(AuditInventaris::class);
    }
}
