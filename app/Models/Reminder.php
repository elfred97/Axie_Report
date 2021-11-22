<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{

    const RECURRENCE_ONCE = 0;
    const RECURRENCE_MONTHLY = 1;
    const RECURRENCE_WEEKLY = 2;
    const RECURRENCE_DAILY = 3;

    protected $fillable = ['reminder_time', 'recurrence', 'title', 'description', 'type_id', 'status'];

}
