<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //
    public $table       = 'player';
	public $timestamps  = TRUE;
	protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'account_name',
        'ronin_address',
        'scholar_email',
        'market_place_email',
        'email_password',
        'date_started',
        'penalty',
        'scholar_share',
        'manager_share',
        'type',
		'status'
	];
}
