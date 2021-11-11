<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerScholarHistory extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'scholar_id',
        'player_id',
        'status',        
    ];

}
