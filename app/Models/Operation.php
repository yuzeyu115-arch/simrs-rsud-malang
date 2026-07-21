<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $table = 'operations';

    protected $fillable = [
        'patient_name',
        'room_id',
        'operation_type',
        'operation_date',
        'start_time',
        'end_time',
        'dpjp_id',
        'surgeon_id',
        'anesthesiologist_id',
        'status',
    ];
}
