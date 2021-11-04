<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSettingsModel extends Model
{
    //
    public $table       = 'notification_settings';
	public $timestamps  = TRUE;
	protected $fillable = [		
        'username',
        'options',
        'status',        
	];
}
