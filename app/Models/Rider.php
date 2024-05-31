<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'nationality'
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'rider_team')->withPivot('season_id')->withTimestamps();
    }
}