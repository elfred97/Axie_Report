<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'account_name',
        'password',
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

    public function reports()
    {
        return $this->hasMany(Report::class,'ronin_address','ronin_address');
    }
}
