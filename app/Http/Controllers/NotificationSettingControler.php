<?php

namespace App\Http\Controllers;

use App\Models\NotificationSettings;
use Illuminate\Http\Request;

class NotificationSettingControler extends Controller
{

    public function save(Request $request)
    {
        $user = $request->user();

        $data = $request->only('options', 'status');

        if($user->notification_settings) {
            $user->notification_settings()->update($data);
        } else {
            $user->notification_settings()->create($data);
        }

        $user->refresh();

        return $this->buildJson(['notification_settings' => $user->notification_settings]);
    }

}
