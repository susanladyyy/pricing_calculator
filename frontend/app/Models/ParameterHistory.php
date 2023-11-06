<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterHistory extends Model
{
    use HasFactory;

    public $fillable = [
        'version_id',
        'history_id',
        'parameter_type_id',
        'calculation_type_id',
        'parameter_id',
        'parameter_name',
        'parameter_content'
    ];

    public function history() {
        return $this->belongsTo(History::class);
    }
    
    public function versions () {
        return $this->hasMany(Version::class);
    }

    public function parameterTypes() {
        return $this->hasMany(ParameterType::class);
    }

    public function calculationTypes() {
        return $this->hasMany(CalculationType::class);
    }

    public function childParameterHistories() {
        return $this->hasMany(ChildParameterHistory::class);
    }

    public $timestamps = false;
}
