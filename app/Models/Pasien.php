<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pasien';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'no_rekam_medis',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalOperasi()
    {
        return $this->hasMany(JadwalOperasi::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}
