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
        'category',
		'reminder_id',
        'status',
		'admin_id'
	];
}
