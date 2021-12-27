<?php

namespace App\Http\Controllers\Scholars;

use App\Http\Controllers\Controller;
use DB;
use Auth;
use File;
use Excel;
use Carbon\Carbon;
use App\Models\Report;
use App\Models\Player;
use App\Models\Notification;
use App\Models\Scholar;
use App\Models\Payroll;
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
        $queryRequest   = array_slice($request->all(), 3);
        $type  = $request->type;
        $where = [];

        if ($request->search)
            array_push($where, ['scholars.first_name', 'like', '%'.$request->search.'%']);

        $field          = ($queryRequest) ? explode('|', $request->sort)[0] : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';

        return Scholar::LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'players.id', '=', 'history.player_id')
            ->LEFTJOIN('type', 'type.id', '=', 'scholars.type_id')
            ->SELECT(
                'scholars.*',
                DB::RAW('CONCAT(scholars.first_name, " ", scholars.last_name) as scholar_name'),
                'players.account_name',
                'type.name as type'
            )
            ->where($where)
            ->orWhere('scholars.last_name', 'like', '%'.$request->search.'%')
            ->when($type, function ($q) use ($type) {
                $q->whereRaw('scholars.type_id=' . (int)$type);
            })
            ->ORDERBY($field,$direction)
            ->PAGINATE($request->per_page);
    }
    public function save(Request $request){
        $ruleUsername = isset($request->id) ? (Scholar::findOrFail($request->id)->username == $request->username ? 'required' : 'required|unique:scholars') : 'required|unique:scholars';
        $ruleEmail = isset($request->id) ? (Scholar::findOrFail($request->id)->email == $request->email ? 'required' : 'required|unique:scholars') : 'required|unique:scholars';
        $validator = Validator::make(
            $request->all(),
            [
                'username'     => $ruleUsername,
                'first_name'   => 'required',
                'last_name'    => 'required',
                'email'        => $ruleEmail,
                'date_started' => 'required',
                'type_id'      => 'required',
                'account_name' => 'required'
            ]
        );

        if($validator->fails())
            return response()->json($validator->errors(), 422);

        try {
            $where = [
                'username'     => filter_var($request->username,FILTER_SANITIZE_STRING),
                'password' => bcrypt('!2E4p@$$w0rDD'),
                'first_name'   => filter_var($request->first_name,FILTER_SANITIZE_STRING),
                'middle_name'  => filter_var($request->middle_name,FILTER_SANITIZE_STRING),
                'last_name'    => filter_var($request->last_name,FILTER_SANITIZE_STRING),
                'email'        => filter_var($request->email,FILTER_SANITIZE_EMAIL),
                'date_started' => date('Y-m-d H:i:s' , strtotime($request->date_started)),
                'type_id'      => $request->type_id,
                'status'       => $request->status,
            ];

            if($request->account_name)
                $player = Player::WHERE('account_name', $request->account_name)->FIRST();
            
            if($request->email_password){
                $where = (array)$where;
                $where['password'] = bcrypt(filter_var($request->email_password,FILTER_SANITIZE_STRING));
            }
            
            $scholar = Scholar::UPDATEORCREATE(
                ['id' => $request->id],
                $where
            );

            $history = PlayerScholarHistory::UPDATEORCREATE(
                ['scholar_id' => $scholar->id],
                [
                    'player_id'  => (!empty($player)) ? $player->id : NULL,
                    'scholar_id' => $scholar->id,
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

    public function getImport(Request $request){
        $username = Auth::user()->username;
        $date     = $request->date;
        
        $queryRequest = array_slice($request->all(), 3);
        $where        = [];

        $from = Carbon::parse('01-01-2020');
        $to   = Carbon::now();
        // $whereBetween = [];
        
        $field     = ($queryRequest) ? explode('|', $request->sort)[0] : 'created_at';
        $direction = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';
            
        array_push($where, ['scholars.username', '=', $username]);

        if ($date){
            $from = Carbon::parse($request->date[0]);
            $to   = Carbon::parse($request->date[1]);

            return Scholar:: LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'history.player_id', '=', 'players.id')
            ->LEFTJOIN('report', 'report.name', '=', 'players.account_name')
            ->WHERE($where)
            ->whereBetween('report.created_at', [$from, $to])
            ->ORDERBY('report.batch', 'desc')
            ->PAGINATE(15);
        }
        
        else{
            return Scholar:: LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'history.player_id', '=', 'players.id')
            ->LEFTJOIN('report', 'report.name', '=', 'players.account_name')
            ->WHERE($where)
            ->ORDERBY('report.batch', 'desc')
            ->PAGINATE(15);
        }
    }

    public function getScholarReport(){
        $username = Auth::user()->username;
        return Scholar:: LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'history.player_id', '=', 'players.id')
            ->LEFTJOIN('report', 'report.name', '=', 'players.account_name')
            ->WHERE('scholars.username', $username)
            ->ORDERBY('scholars.id', 'desc')
            ->GET();
    }

    // public function getScholarInformation(){
    //     $username = Auth::user()->username;

    //     return Scholar:: LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
    //         ->LEFTJOIN('players', 'history.player_id', '=', 'players.id')
    //         ->LEFTJOIN('type', 'type.id', '=', 'scholars.type_id')
    //         ->SELECT('scholars.*', 'players.*', 'type.name as type_name')
    //         ->WHERE('scholars.username', $username)
    //         ->FIRST();
    // }

    public function updateRoninWallet(Request $request){
        $username = Auth::user()->username;

        try {
            $scholar = Scholar::UPDATEORCREATE(
                ['username' => $username],
                [                    
                    'ronin_wallet'       => $request->ronin_wallet,
                ]
            );            

            if($scholar)
                return response()->json(['message' => 'Ronin Wallet is saved'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function getScholarGraph(Request $request){
        $username =  Auth::user()->username;
        if(isset($request->date)){
            $from = Carbon::parse(strtotime($request->date[0]));
            $to   = Carbon::parse(strtotime($request->date[1]));
            return Report::LEFTJOIN('players', 'report.name', '=', 'players.account_name')
            ->LEFTJOIN('player_scholar_histories as history', 'players.id', '=', 'history.player_id')
            ->LEFTJOIN('scholars', 'history.scholar_id', '=', 'scholars.id')
            ->SELECT(
                'report.*'                
            )
            ->WHERE('scholars.username', $username)
            ->whereBetween('report.created_at', [$from, $to])
            ->GET();
        }
        else{
            return Report::LEFTJOIN('players', 'report.name', '=', 'players.account_name')
            ->LEFTJOIN('player_scholar_histories as history', 'players.id', '=', 'history.player_id')
            ->LEFTJOIN('scholars', 'history.scholar_id', '=', 'scholars.id')
            ->SELECT(
                'report.*'                
            )
            ->WHERE('scholars.username', $username)
            ->GET();
        }
    }

    public function delete(Request $request){
        $id = isset($request->id) ? $request->id : NULL;
        $scholar = Scholar::WHERE('id', $id)->FIRST();

        if(empty($scholar))
            return response()->json(['message' => 'Invalid Reference Key'], 422);
        try{
            $history = PlayerScholarHistory::WHERE('scholar_id', $id)->FIRST();
            $payroll = Payroll::WHERE('scholar_id', $id)->FIRST();

            if(!empty($history))
                $history->DELETE();

            if(!empty($payroll))
                $payroll->DELETE();

            if ($scholar->DELETE())
				return response()->json(['message' => 'Scholar Removed'], 200);
			else
				return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function getScholarNotification(){
        $username = Auth::user()->username;
        return Notification::LEFTJOIN('players', 'notification.account_name', '=', 'players.account_name')
            ->LEFTJOIN('player_scholar_histories as history', 'history.player_id', '=', 'players.id')
            ->LEFTJOIN('scholars', 'history.scholar_id','=', 'scholars.id')
            ->SELECT(
                'notification.*',
                DB::RAW('CONCAT(scholars.first_name, " ", scholars.last_name) as scholar_name'),
                'players.*'
            )
        ->WHERE([['scholars.username', $username], ['notification.category', '!=', 3],['notification.status_scholar', '=', 1]])
        ->GET();

    }

    public function changeStatusNotification(){
        try {
            $username = Auth::user()->username;
            $notif = DB::table('notification')->where('account_name',$username)->where('status_scholar', '=', 1)->update(array('status_scholar' => 2));
            if($notif)
                return response()->json(['message' => 'Notification has been read!'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }
}
