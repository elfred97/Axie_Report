<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlpPriceNotificationHistory extends Model
{
    protected $fillable = ['value', 'currency', 'sent_at'];

    public $timestamps = false;
}
