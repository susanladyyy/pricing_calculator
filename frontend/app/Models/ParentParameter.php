<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_id',
    ];

    public function childParameters(){
        return $this->hasMany(ChildParameter::class);
    }

    public function parameter(){
        return $this->belongsTo(Parameter::class);
    }

    public $timestamps = false;
}
