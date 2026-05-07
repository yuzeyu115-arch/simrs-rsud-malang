<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMakan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_makan';

    protected $fillable = [
        'nama',
        'jam_pesan',
        'jam_kirim',
        'jam_lapor',
        'shift',
    ];
}
