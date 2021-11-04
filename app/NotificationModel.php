<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
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
