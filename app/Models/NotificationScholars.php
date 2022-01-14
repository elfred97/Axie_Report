<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationScholars extends Model
{
    public $table       = 'notification_scholars';
	public $timestamps  = TRUE;
	protected $fillable = [
		'player_id',
        'category',
        'status'
	];
}
