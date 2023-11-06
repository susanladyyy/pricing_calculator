<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'university_id',
        'username',
        'email',
        'role_id',
        'password',
    ];

    protected $secured = [
        'password',
        'remember_token'
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function university(){
        return $this->belongsTo(University::class);
    }

    public function calculationHistories(){
        return $this->hasMany(CalculationHistory::class);
    }

    public function parameters() {
        return $this->hasMany(Parameter::class);
    }

    public function childParameters() {
        return $this->hasMany(ChildParameter::class);
    }

    public function histories() {
        return $this->hasMany(History::class);
    }
}
