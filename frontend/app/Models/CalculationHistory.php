<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'calculation_id',
        'date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function calculation(){
        return $this->belongsTo(Calculation::class);
    }

    public $timestamps = false;
}
