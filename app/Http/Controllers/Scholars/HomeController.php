<?php

namespace App\Http\Controllers\Scholars;

use App\Http\Controllers\Controller;
use DB;
use File;
use Excel;
use App\Models\Player;
use App\Models\Scholar;
use Illuminate\Http\Request;
use App\Imports\ScholarImport;
use App\Models\PlayerScholarHistory;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('main');
    }

    public function import(Request $request){
        Excel::import(new ScholarImport, $request->file);
        return "File Uploaded";
    }

    public function getScholars(Request $request){
        return Scholar::LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'players.id', '=', 'history.player_id')
            ->LEFTJOIN('type', 'type.id', '=', 'scholars.type_id')
            ->SELECT(
                'scholars.*',
                DB::RAW('CONCAT(scholars.first_name, " ", scholars.last_name) as scholar_name'),
                'players.account_name',
                'type.name as type'
            )
            ->PAGINATE($request->per_page);
    }
    public function save(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'username'     => 'required',
                'first_name'   => 'required',
                'last_name'    => 'required',
                'email'        => 'required',
                'date_started' => 'required',
                'type_id'      => 'required',
                'status'       => 'required',
            ]
        );

        if($validator->fails())
            return response()->json($validator->errors(), 422);

        try {
            $scholar = Scholar::UPDATEORCREATE(
                ['id' => $request->id],
                [
                    'username'     => $request->username,
                    'first_name'   => $request->first_name,
                    'middle_name'  => $request->middle_name,
                    'last_name'    => $request->last_name,
                    'email'        => $request->email,
                    'date_started' => date('Y-m-d H:i:s' , strtotime($request->date_started)),
                    'type_id'      => $request->type_id,
                    'status'       => $request->status,
                ]
            );
            $player = Player::WHERE('account_name', $request->account_name)->FIRST();
            $history = PlayerScholarHistory::UPDATEORCREATE(
                ['scholar_id' => $request->id],
                [
                    'player_id' => $player->id
                ]
            );

            if($scholar)
                return response()->json(['message' => 'Scholar Informations is saved'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }
}
