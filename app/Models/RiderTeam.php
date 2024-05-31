<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id', 
        'rider_id', 
        'team_id'
    ];
}