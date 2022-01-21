<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationSettingControler extends Controller
{

    public function save(Request $request)
    {
        $user = $request->user();
        $user->load('customization_settings');

        $data = $request->only('options');

        if ($user->customization_settings) {
            $user->customization_settings()->update($data);
        } else {
            $user->customization_settings()->create($data);
        }

        $user->refresh();

        return $this->buildJson(['notification_settings' => $user->customization_settings]);
    }

    public function get(Request $request)
    {
        $user = $request->user();
        $user->load('customization_settings');

        $notification_settings = $user->customization_settings;
        return $this->buildJson(compact('notification_settings'));
    }

}
