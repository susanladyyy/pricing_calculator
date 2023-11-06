<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_name',
        'university_address',
        'logo_path',
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public $timestamps = false;
}
