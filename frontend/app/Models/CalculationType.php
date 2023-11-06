<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'calculation_type_name',
    ];

    public function parameters(){
        return $this->hasMany(Parameter::class);
    }

    public function calculationType() {
        return $this->belongsTo(ParameterHistory::class);
    }

    public function historyDetail() {
        return $this->belongsTo(HistoryDetail::class);
    }

    public $timestamps = false;
}
