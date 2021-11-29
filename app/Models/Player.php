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
        'password',
        'scholar_share',
        'manager_share',
        'qr_code',
        'qr_code_date',
    ];

    public function scholar()
    {
        return $this->hasOneThrough(Scholar::class,PlayerScholarHistory::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class,'ronin_address','ronin_address');
    }

    public function histories()
    {
        return $this->hasMany(PlayerScholarHistory::class);
    }

    public function latestHistory()
    {
        $latest = $this->histories()->latest()->first();
        if(!$latest) {
            return new PlayerScholarHistory();
        }
    }
}
