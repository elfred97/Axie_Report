<?php
namespace App\Http\Controllers;

use App\Models\Type;
use DB;
use Auth;
use File;
use Storage;
use Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\report as ReportModel;
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
                's.*',
                DB::RAW('CONCAT(s.first_name, " ", s.last_name) as player_name')
            )
            ->LEFTJOIN('player_scholar_histories as psh', 'players.id', '=', 'psh.player_id')
            ->LEFTJOIN('scholars as s', 's.id', '=', 'psh.scholar_id')
            ->WHERE($where)
            ->PAGINATE($request->per_page);
    }
    public function getAllPlayers(){
        return Player::GET();
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
    public function import(Request $request){
        Excel::import(new PlayerImport, $request->file);
        return "File Uploaded";
    }


    public function getPenaltyCount($type_id = null)
    {
        $type = $type_id ? Type::findOrNew($type_id)->name :'All';
        if(!$type) {
            return $this->buildErrorJson('Type not found!');
        }

        $penalty_counts = Player::select('players.penalty', DB::raw('count(*) as total'))
            ->groupBy('players.penalty')
            ->leftJoin('player_scholar_histories as psh', 'players.id', '=', 'psh.player_id')
            ->leftJoin('scholars as s', 's.id', '=', 'psh.scholar_id')
            ->when($type_id, function ($q) use ($type_id) {
                $q->whereRaw('s.type_id='.(int) $type_id);
            })->get();

        return $this->buildJson(['penalties' => $penalty_counts, 'type' => $type]);
    }

    public function getLowestMMR(Request $request)
    {
        $type_id = $request->type_id;
        $year = $request->year;
        $month = $request->month;

        $type = $type_id ? Type::findOrNew($type_id)->name : 'All';

//        $player_counts = Player::query()
        $player_counts = DB::table('players')
            ->select(DB::raw('count(*) as total'))
            ->leftJoin('player_scholar_histories as psh', 'players.id', '=', 'psh.player_id')
            ->leftJoin('scholars as s', 's.id', '=', 'psh.scholar_id')
            ->leftJoin('report as r', 'r.name', '=', 'players.account_name')
            ->where('mmr','<', 800)
            ->when($type_id, function ($q) use ($type_id) {
                $q->whereRaw('s.type_id=' . (int)$type_id);
            })
            ->when($year, function ($q) use ($year) {
                $q->whereYear('r.created_at', '=', $year);
            })
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('r.created_at', '=', $month);
            })
            ->groupBy('players.account_name')
            ->get()
            ->count();


        return $this->buildJson(['lowest_mmr_counts' => $player_counts]);
    }

    public function uploadQR(Request $request){
        $file           = $request->file;
        $username       = explode(":",$request->ronin_address)[1];
        $file_extension = $file->getClientOriginalExtension();
        $file_name      = $username.'.'.$file_extension;
        $path           = 'qr_codes/'.$file_name;
        // $save = Storage::put($path, file_get_contents($request->file));

        $save = Storage::disk('public')->put($path, file_get_contents($file));

        if($save)
            try {
                $user = Player::UPDATEORCREATE(
                    [ 'account_name' => $request->account_name ],
                    [
                        'qr_code'   => $path,
                        'qr_code_date'=> Carbon::now(),                        
                    ]
                );
                if($user)
                    return response()->json(['message' => 'QR Code Uploaded'], 200);
                else
                    return response()->json(['message' => 'There was a problem processing your request'], 500);
            }
            catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
    }
}
