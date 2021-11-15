<?php

namespace App\Http\Controllers;

use App\Models\NotificationSettings;
use Illuminate\Http\Request;

class NotificationSettingControler extends Controller
{

    public function save(Request $request)
    {
        $user = $request->user();
        $user->load('notification_settings');

        $data = $request->only('options', 'status');
        $data['model_id'] = $user->id;
        $data['model'] = get_class($user);

        if ($user->notification_settings) {
            $user->notification_settings()->update($data);
        } else {
            $user->notification_settings()->create($data);
        }

        $user->refresh();

        return $this->buildJson(['notification_settings' => $user->notification_settings]);
    }

    public function get(Request $request)
    {
        $user = $request->user();
        $user->load('notification_settings');

        $notification_settings = $user->notification_settings;
        return $this->buildJson(compact('notification_settings'));
    }

}
