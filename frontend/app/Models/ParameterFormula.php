<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterFormula extends Model
{
    use HasFactory;

    protected $table = 'parameter_formulas';

    protected $fillable = [
        'parameter_id',
        'formula',
        'formula_name',
    ];

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }

    public $timestamps = false;
}
