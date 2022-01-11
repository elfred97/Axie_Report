<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    //
    public $table       = 'report';
	public $timestamps  = TRUE;
	protected $fillable = [
		'ronin_address',
		'name',
        'batch',
        'average_per_day',
        'unclaimed',
        'claimed',
        'total_slp',
        'gained_slp_today',
        'last_claim_days',
        'last_claim_date',
        'claimable_on',
        'compensation',
        'number_of_senior',
        'thirty_percent',
        'forty_percent',
        'manager_share',
        'scholar_share',
        'manager_slp',
        'scholar_slp',
        'mmr',
        'rank',
        'import_id'
	];

    public static function getReport(){
        $report = DB::table('report')->SELECT('*')->ORDERBY('id', 'ASC')->GET();

        return $report;
    }

    public function players(){
        return $this->belongsTo(Player::class,'ronin_address','ronin_address');
    }

    public function scopeWhereDateBetween($query,$fieldName,$fromDate,$todate)
    {
        return $query->whereDate($fieldName,'>=',$fromDate)->whereDate($fieldName,'<=',$todate);
    }
}
