<?php

namespace App\Http\Controllers;

use App\Models\NotificationSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingControler extends Controller
{

    public function save(Request $request)
    {
        $options = $request->options;
        $type_admin = Auth::user()->type;
        $userNotificationSettings = NotificationSettings::UPDATEORCREATE(
            [ 'type' => $type_admin ],
                [
                    'options' => $request->options
                ]
        );

        return $this->buildJson(['notification_settings' => $userNotificationSettings]);
    }

    public function get()
    {
        $type_admin = Auth::user()->type;
        $userNotificationSettings = NotificationSettings::where('type',$type_admin)->select('options','type')->first();
        return $this->buildJson(['notification_settings' => $userNotificationSettings]);
    }

    public function getAllNotificationSettings(){
        return NotificationSettings::select('type','options','created_at')->with('type')->get();
    }

}
