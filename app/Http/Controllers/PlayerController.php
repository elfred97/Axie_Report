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
use App\Models\Payroll;
use App\Imports\PlayerImport;
use App\Models\PlayerScholarHistory;
use App\Models\Scholar;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    public function getPlayers(Request $request){
        $where = [];
        $queryRequest   = array_slice($request->all(), 3);

        if ($request->type)
            array_push($where, ['type_id', '=', $request->type]);
        if ($request->search)
            array_push($where, ['players.account_name', 'like', '%'.$request->search.'%']);

            $field          = ($queryRequest) ? str_replace("_field","",explode('|', $request->sort)[0]) : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';
        
        return Player::
            SELECT(
                'players.*',
                DB::RAW('CONCAT(s.first_name, " ", s.last_name) as player_name'),
                't.name as type_name',
                's.status'
            )
            ->LEFTJOIN('player_scholar_histories as psh', 'players.id', '=', 'psh.player_id')
            ->LEFTJOIN('scholars as s', 's.id', '=', 'psh.scholar_id')
            ->LEFTJOIN('type as t', 't.id', '=', 's.type_id')
            ->WHERE($where)
            ->ORDERBY($field,$direction)
            ->PAGINATE($request->per_page);
    }
    public function getAllPlayers(){
        return Player::doesnthave('histories')->get();
    }

    public function getListOfPlayers(){
        return Player::GET();
    }

    public function savePlayer(Request $request){
        // dd($request->all());
        $ruleAccountName = isset($request->id) ? (Player::findOrFail($request->id)->account_name == $request->account_name ? 'required' : 'required|unique:players') : 'required|unique:players';
        $validator = Validator::make(
            $request->all(),
			[
                'ronin_address'      => 'required|regex:/^ronin:([a-z0-9-]{40})$/',
                'account_name'       => $ruleAccountName,// /^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/
                'market_place_email' => 'required|email',
            ]
        );
        $where = [
            'ronin_address'      => filter_var($request->ronin_address,FILTER_SANITIZE_STRING),
            'account_name'       => filter_var(preg_replace('/\s+/', '', $request->account_name),FILTER_SANITIZE_STRING),
            'scholar_email'      => filter_var($request->scholar_email,FILTER_SANITIZE_EMAIL),
            'market_place_email' => filter_var($request->market_place_email,FILTER_SANITIZE_EMAIL),
            'password'           => filter_var($request->email_password,FILTER_SANITIZE_STRING),
        ];
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
            
        try {
            $player = Player::UPDATEORCREATE(
                [ 'id' => $request->id ],
                $where
            );

            if($player)
                return response()->json(['message' => 'Player Informations is saved'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function deletePlayer(Request $request){
        $id = isset($request->id) ? $request->id : NULL;
        $player = Player::WHERE('id', $id)->FIRST();

        // $history = PlayerScholarHistory::UPDATE(['player_id' => NULL, 'scholar_id' => NULL]);

        $history = PlayerScholarHistory::WHERE('player_id', $id)->FIRST();
        if(!empty($history))
            $history->DELETE();

        $payroll = Payroll::where('player_id', $id)->FIRST();

        if(!empty($payroll))
            $payroll->DELETE();
        
        if(empty($player))
            return response()->json(['message' => 'Invalid Reference Key'], 422);
        try{
            if ($player->DELETE())
				return response()->json(['message' => 'Axie Account Removed'], 200);
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
        $file_extension = $file->getClientOriginalExtension();
        $file_name      = substr($request->account_name,1).'.'.$file_extension;
        $path           = 'qr_codes/'.$file_name;
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
