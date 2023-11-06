<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'history_id',
        'version_id',
        'calculation_type_id',
        'result'
    ];

    public function history() {
        return $this->belongsTo(History::class);
    }

    public function versions(){
        return $this->hasMany(Version::class);
    }

    public function calculationTypes() {
        return $this->hasMany(CalculationType::class);
    }

    public $timestamps = false;
}
