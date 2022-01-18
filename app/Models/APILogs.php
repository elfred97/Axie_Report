<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class APILogs extends Model
{
    public $table       = 'api_logs';
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
        'average_per_day',
        'gained_slp_today',
        'last_claim_days',
        'thirty_percent',
        'forty_percent',
        'manager_share',
        'scholar_share',
        'manager_slp',
        'scholar_slp',
        'claimed',
        'raw_total',
        'unclaimed',
        'lifetime_slp'
	];
}
