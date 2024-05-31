<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'year'
        ];

    public function races()
    {
        return $this->hasMany(Race::class);
    }

    public function riderTeams()
    {
        return $this->hasMany(RiderTeam::class);
    }
}