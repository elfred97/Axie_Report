<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($account_type, Request $request){
        if($account_type == 'scholars'){
            $search  = $request->search;
            $where = [];
            if ($search)
            array_push($where, ['reminders.title','LIKE','%'.$request->search.'%']);

            $notificationReminders = Notification::LEFTJOIN('reminders', 'reminders.id', '=', 'notification.notification_reminder_id')
                ->LEFTJOIN('scholars', 'notification.scholar_id', '=', 'scholars.id')
                ->SELECT('reminders.*','scholars.*')
                ->WHERE('reminders.title','LIKE','%'.$request->search.'%')
                ->WHERE([['notification.category', 2],['scholars.id',Auth::id()]]);
            
            return $notificationReminders->addSelect('notification.status as notif_status')->get();
        }
    }
}
