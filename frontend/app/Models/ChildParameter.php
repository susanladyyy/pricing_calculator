<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_id',
        'user_id',
        'parameter_name',
        'parameter_cost',
        'parameter_number',
    ];

    public function parameter(){
        return $this->belongsTo(Parameter::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;
}
