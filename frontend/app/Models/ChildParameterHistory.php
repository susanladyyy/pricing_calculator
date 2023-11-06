<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildParameterHistory extends Model
{
    use HasFactory;

    public $fillable = [
        'parameter_history_id',
        'parameter_name',
        'parameter_cost',
        'parameter_number'
    ];

    public function parameterHistory() {
        return $this->belongsTo(ParameterHistory::class);
    }

    public $timestamps = false;
}
