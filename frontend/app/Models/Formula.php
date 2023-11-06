<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $table = 'formulas';

    protected $fillable = [
        'calculation_type_id',
        'version_id',
        'formula',
        'formula_name'
    ];

    public function calculationType(){
        return $this->belongsTo(CalculationType::class);
    }

    public function version(){
        return $this->belongsTo(Version::class);
    }

    public $timestamps = false;

}
