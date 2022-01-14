<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Scholar;
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

            return Notification::LEFTJOIN('reminders', 'reminders.id', '=', 'notification.notification_reminder_id')
                ->LEFTJOIN('scholars', 'notification.scholar_id', '=', 'scholars.id')
                ->WHERE('reminders.title','LIKE','%'.$request->search.'%')
                ->WHERE([['notification.category', 2],['scholars.id',Auth::id()]])
                ->get();
        }
    }
}
