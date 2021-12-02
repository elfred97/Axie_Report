<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    //
    public function index($account_type){
        if($account_type == 'scholars')
            return Notification::LEFTJOIN('reminders', 'notification.reminder_id', '=', 'reminders.id')->WHERE('notification.category', 3)->get();
    }
}
