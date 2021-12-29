<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleLogs extends Model
{
    public $table       = 'battle_logs';
	public $timestamps  = TRUE;
	protected $fillable = [
        'ronin_address',
        'account_name',
        'last_claim_date',
        'claimable_on',
        'total_slp',
        'mmr',
        'rank',
        'draw_total',
        'lose_total',
        'win_total',
        'total_matches',
        'win_rate',
        'ronin_slp',
        'raw_total',
        'in_game_slp',
        'lifetime_slp'
	];
}
