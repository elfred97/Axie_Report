<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'account_name',
        'ronin_address',
        'market_place_email',
        'penalty',
        'scholar_share',
        'manager_share'
    ];

    public function scholar()
    {
        return $this->hasOneThrough(Scholar::class,PlayerScholarHistory::class);
    }
}
