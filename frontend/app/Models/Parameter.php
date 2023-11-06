<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'version_id',
        'parameter_type_id',
        'calculation_type_id',
        'parameter_name',
        'parameter_content',
        'user_id',
    ];

    public function courseVersion()
    {
        return $this->belongsTo(Version::class);
    }

    public function parameterType()
    {
        return $this->belongsTo(ParameterType::class);
    }

    public function calculationType()
    {
        return $this->belongsTo(CalculationType::class);
    }

    public function childParameters()
    {
        return $this->hasMany(ChildParameter::class);
    }

    public function parameterFormula()
    {
        return $this->hasOne(ParameterFormula::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;
}
