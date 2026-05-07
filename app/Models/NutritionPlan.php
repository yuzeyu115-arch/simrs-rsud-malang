<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionPlan extends Model
{
    use HasFactory;

    protected $table = 'nutrition_plans';

    protected $fillable = [
        'patient_name',
        'room_id',
        'diet_type',
        'schedule_time',
        'notes',
        'status',
    ];
}
