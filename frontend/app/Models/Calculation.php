<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_id',
        'calculation_type_id',
        'result',
        'status',
    ];

    public function calculationType()
    {
        return $this->belongsTo(CalculationType::class);
    }

    public function courseVersion()
    {
        return $this->belongsTo(Version::class);
    }
    
    public $timestamps = false;
}
