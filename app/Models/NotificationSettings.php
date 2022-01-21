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

    // public function user()
    // {
    //     return $this->hasOne(User::class,'id','model_id')->where('model','App\Models\User');
	// }

    // public function scholar()
    // {
    //     return $this->hasOne(User::class,'id','model_id')->where('model','App\Models\Scholar');
    // }
}
