<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_obat';

    protected $fillable = [
        'nama_obat',
        'jenis_obat',
        'stok_obat',
        'kandungan_obat',
        'tanggal_kadaluwarsa',
        'tanggal_pembelian',
        'harga_obat',
        'status',
    ];
}
