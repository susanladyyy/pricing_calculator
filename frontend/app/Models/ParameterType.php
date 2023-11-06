<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterType extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_type_name'
    ];

    public function parameters() {
        return $this->hasMany(Parameter::class);
    }

    public function parameterHistory() {
        return $this->belongsTo(ParameterHistory::class);
    }

    public $timestamps = false;
}
