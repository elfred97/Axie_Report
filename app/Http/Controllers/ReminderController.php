<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make(
			$request->all(),
			[
				'reminder_time'    => 'date',
				'recurrence'  => 'in:0,1,2,3',
				'title'   => 'required'
			]
		);

		if ($validator->fails())
			return response()->json($validator->errors(), 422);

        try {
            $user = Reminder::CREATE([
                'reminder_time' => $request->reminder_time,
                'recurrence' => $request->recurrence,
                'title' => filter_var($request->title,FILTER_SANITIZE_STRING),
                'description' => $request->description,
                'type_id' => $request->type_id,
                'status' => $request->status,
            ]);
            if($user)
                return response()->json(['message' => 'User Informations is saved'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // $this->validate($request, ['reminder_time' => 'date','recurrence' => 'in:0,1,2,3', 'title' => 'required']);

        // $reminder = Reminder::create($request->all());

        // return $this->buildJson(compact('reminder'));
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
