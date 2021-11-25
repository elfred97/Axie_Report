<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['player_id', 'scholar_id', 'total_slp', 'status', 'txn_id'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function scholar()
    {
        return $this->belongsTo(Scholar::class);
    }
}
