<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditInventaris extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'audit_inventaris';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'inventaris_id',
        'jenis_aktivitas',
        'jumlah',
        'keterangan',
        'diaudit_oleh',
    ];

    protected $casts = [
        'waktu_audit' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function diauditOleh()
    {
        return $this->belongsTo(User::class, 'diaudit_oleh');
    }
}
