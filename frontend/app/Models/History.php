<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'version_id',
    ];

    public function parameterHistories() {
        return $this->hasMany(ParameterHistory::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function historyDetails() {
        return $this->hasMany(HistoryDetail::class);
    }

    public function version() {
        return $this->belongsTo(Version::class);
    }
}
