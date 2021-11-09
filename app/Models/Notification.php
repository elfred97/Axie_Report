<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    public $table       = 'notification';
	public $timestamps  = TRUE;
	protected $fillable = [
		'id',
		'account_name',
        'gained_slp_today',
        'penalty',
	];
}
