<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'course_name',
        'multimedia_number',
        'session_number'
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function courseVersions()
    {
        return $this->hasMany(Version::class);
    }

    public $timestamps = false;
}
