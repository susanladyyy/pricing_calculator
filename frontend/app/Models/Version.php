<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;

    protected $table = 'versions';

    protected $fillable = [
        'id',
        'course_id',
        'course_version',
        'multimedia_number',
        'session_number'
    ];

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function detail()
    {
        return $this->belongsTo(HistoryDetail::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function calculations()
    {
        return $this->hasMany(Calculation::class);
    }

    public function parameters()
    {
        return $this->hasMany(Formula::class);
    }

    public function formulas()
    {
        return $this->hasMany(Formula::class);
    }

    public function parameterHistory()
    {
        return $this->belongsTo(ParameterHistory::class);
    }
}
