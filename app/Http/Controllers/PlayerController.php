<?php
namespace App\Http\Controllers;

use DB;
use File;
use Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\reportModel as ReportModel;
use App\Models\Player;
use App\Imports\PlayerImport;

class PlayerController extends Controller
{
    public function getPlayers(Request $request){
        $where = [];
        if ($request->type)
            array_push($where, ['type', '=', $request->type]);
        return Player::
            SELECT(
                '*',
                DB::RAW('CONCAT(first_name, " ", last_name) as player_name')
            )
            ->WHERE($where)
            ->PAGINATE($request->per_page);
    }

    public function saveScholar(Request $request){
        // dd($request->id);
        $validator = Validator::make(
			$request->all(),
			[
				'ronin_address'    => 'required',
                'first_name'    => 'required',
				'last_name'     => 'required',
                'account_name' => 'required',
				'scholar_email' => 'required|email',
                'market_place_email'    => 'required|email',
                'email_password'    => 'required',
                'date_started'    => 'required',
			]
		);

		if ($validator->fails())
			return response()->json($validator->errors(), 422);

		try {
            $scholar = Player::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'ronin_address'      => $request->ronin_address,
                    'account_name'       => $request->account_name,
                    'first_name'         => $request->first_name,
                    'middle_name'        => $request->middle_name,
                    'last_name'          => $request->last_name,
                    'scholar_email'      => $request->scholar_email,
                    'market_place_email' => $request->market_place_email,
                    'email_password'     => $request->email_password,
                    'date_started'       => $request->date_started,
                    'type'               => $request->type,
                    'status'             => $request->status,
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
    public function deleteScholar(Request $request){
        $id = isset($request->id) ? $request->id : NULL;
        $scholar = Player::WHERE('id', $id)->FIRST();

        if(empty($scholar))
            return response()->json(['message' => 'Invalid Reference Key'], 422);
        try{
            if ($scholar->DELETE())
				return response()->json(['message' => 'Scholar Removed'], 200);
			else
				return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }
    public function importScholar(Request $request){
        Excel::import(new PlayerImport, $request->file);
        return "File Uploaded";
    }
}
