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
            $username = Auth::user()->username;
            $scholar = Scholar::where('username', $username)->FIRST();
            $search  = $request->search;
            $where = [];
            if ($search)
            array_push($where, ['title','LIKE','%'.$request->search.'%']);

            return Notification::LEFTJOIN('reminders', 'reminders.id', '=', 'notification.reminder_id')
                ->WHERE('title','LIKE','%'.$request->search.'%')
                ->WHERE('id','!=',null)
                ->WHERE([['notification.category', 3], ['reminders.type_id', $scholar->type_id]])
                ->orWhere([['notification.category', 3], ['reminders.type_id', NULL]])
                ->get();
        }
    }
}
