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
            array_push($where, ['title','LIKE','%'.$request->search.'%']);

            return Notification::LEFTJOIN('reminders', 'reminders.id', '=', 'notification.reminder_id')
                ->LEFTJOIN('scholars', 'scholars.id', '=', 'notification.account_name')
                ->WHERE('title','LIKE','%'.$request->search.'%')
                ->WHERE([['notification.category', 4]])
                ->get();
        }
    }
}
