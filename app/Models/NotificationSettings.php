<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSettings extends Model
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
