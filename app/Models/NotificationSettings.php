<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSettings extends Model
{
    //
    public $table       = 'notification_settings';
    public $timestamps  = TRUE;
    protected $fillable = [
        'options',
        'type',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function type()
    {
        return $this->hasOne(Type::class,'id','type')->select('id','name');
	}
}
