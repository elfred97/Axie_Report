<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $reminders = Reminder::LEFTJOIN('type', 'reminders.type_id', '=', 'type.id')
                ->SELECT('reminders.*', 'type.name as type_name')
                ->paginate(15);

        return $this->buildJson(compact('reminders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, ['reminder_time' => 'date','recurrence' => 'in:0,1,2,3', 'title' => 'required']);

        $reminder = Reminder::create($request->all());

        return $this->buildJson(compact('reminder'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Reminder $reminder)
    {
        return  $this->buildJson(compact('reminder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Reminder $reminder)
    {
        $this->validate($request, ['reminder_time' => 'date','recurrence' => 'in:0,1,2,3', 'title' => 'required']);
        $reminder->update($request->all());

        return $this->buildJson(compact('reminder'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return $this->buildJson(['msg' => 'Reminder deleted successfully']);
    }
}
