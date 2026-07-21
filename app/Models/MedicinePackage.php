<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'jenis_obat',
        'total_paket',
        'preoperatif',
        'intraoperatif',
        'postoperatif',
    ];
}
