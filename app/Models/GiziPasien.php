<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiziPasien extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'gizi_pasien';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pasien_id',
        'jadwal_operasi_id',
        'tipe_diet',
        'menu_makanan',
        'ditentukan_oleh',
        'waktu_pemberian',
    ];

    protected $casts = [
        'waktu_pemberian' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function jadwalOperasi()
    {
        return $this->belongsTo(JadwalOperasi::class);
    }

    public function ditentukanOleh()
    {
        return $this->belongsTo(User::class, 'ditentukan_oleh');
    }
}
