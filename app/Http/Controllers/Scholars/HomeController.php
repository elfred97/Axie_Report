<?php

namespace App\Http\Controllers\Scholars;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
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
use App\Imports\HistoryImport;
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

    public function import_history(Request $request){
        Excel::import(new HistoryImport, $request->file);
        return "File Uploaded";
    }

    public function import(Request $request){
        Excel::import(new ScholarImport, $request->file);
        return "File Uploaded";
    }

    public function getScholars(Request $request){
        $queryRequest   = array_slice($request->all(), 3);
        $type  = $request->type;
        $status  = $request->status;
        $where = [];

        if ($request->search)
        array_push($where, [DB::RAW("CONCAT(scholars.first_name,' ',scholars.last_name)"), 'LIKE', '%'.$request->search.'%']);

        $field          = ($queryRequest) ? explode('|', $request->sort)[0] : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';

        return Scholar::LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'players.id', '=', 'history.player_id')
            ->LEFTJOIN('type', 'type.id', '=', 'scholars.type_id')
            ->SELECT(
                'scholars.*',
                DB::RAW('CONCAT(scholars.first_name, " ", scholars.last_name) as scholar_name'),
                'type.name as type'
            )
            ->with('accounts')
            ->where($where)
            ->when($type, function ($q) use ($type) {
                $q->whereRaw('scholars.type_id=' . (int)$type);
            })
            ->when($status, function ($q) use ($status) {
                $q->where('scholars.status','=',$status);
            })
            ->distinct('scholars.email')
            ->ORDERBY($field,$direction)
            ->PAGINATE($request->per_page);
    }
    public function save(Request $request){
        $ruleUsername = isset($request->id) ? (Scholar::findOrFail($request->id)->username == filter_var($request->username,FILTER_SANITIZE_STRING) ? 'required' : 'required|unique:scholars') : 'required';
        $ruleEmail = isset($request->id) ? (Scholar::findOrFail($request->id)->email == filter_var($request->email,FILTER_SANITIZE_EMAIL) ? 'required' : 'required|unique:scholars') : 'required';
        $validator = Validator::make(
            $request->all(),
            [
                'username'     => $ruleUsername,
                'first_name'   => 'required',
                'last_name'    => 'required',
                'email'        => $ruleEmail,
                'date_started' => 'required',
                'type_id'      => 'required',
                'status'      => 'required',
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

            if(isset($request->email_password)){
                $where = (array)$where;
                $where['password'] = bcrypt(filter_var($request->email_password,FILTER_SANITIZE_STRING));
            }
            
            $scholar = Scholar::UPDATEORCREATE(
                ['id' => $request->id],
                $where
            );

            if(str_contains($request->account_name,",")){
                $playerAccounts = explode(",",$request->account_name);
                $playerIDS = array();
                foreach($playerAccounts as $playerAcc){
                    $player = Player::WHERE('account_name', $playerAcc)->FIRST();
                    $playerHistory = PlayerScholarHistory::WHERE('player_id', $player->id)->WHERE('scholar_id', isset($request->id) ? $request->id : $scholar->id)->where('status',1)->FIRST();

                    if(empty($playerHistory)){
                        array_push($playerIDS,$player->id);
                        PlayerScholarHistory::CREATE(
                            [
                                'player_id'  => $player->id,
                                'scholar_id' => isset($request->id) ? $request->id : $scholar->id
                            ]
                        );
                    }
                    else{
                        array_push($playerIDS,$player->id);
                    }
                }
                PlayerScholarHistory::WHERENOTIN('player_id',$playerIDS)->WHERE('scholar_id', $request->id)->UPDATE(['status' => 0]);
            }    
            else{
                $player = Player::WHERE('account_name', $request->account_name)->FIRST();

                $playerHistories = PlayerScholarHistory::WHERE('scholar_id', $request->id)->WHERE('player_id',$player->id)->WHERE('status',1)->count();
                $countScholarAccounts = PlayerScholarHistory::WHERE('scholar_id', $request->id)->WHERE('status',1)->count();

                if($playerHistories == 0 && $countScholarAccounts > 0){
                    PlayerScholarHistory::WHERE('scholar_id', $request->id)->UPDATE(['status' => 0]);
                    PlayerScholarHistory::CREATE(
                        [
                            'player_id'  => $player->id,
                            'scholar_id' => $scholar->id
                        ]
                    );
                }
                else{
                    PlayerScholarHistory::WHERE('scholar_id', $request->id)->WHERENOTIN('player_id',[$player->id])->UPDATE(['status' => 0]);
                }
            }

            if($scholar['status'] == 'TERMINATED' || $scholar['status'] == 'RESIGNED'){
                $scholarsAccounts = Scholar::where('id',$request->id)->where('username',filter_var($request->username,FILTER_SANITIZE_STRING))->with('accounts')->get()[0]->accounts;
                    for($i=0;$i< count($scholarsAccounts);$i++){
                        Notification::CREATE([
                            'account_name' => $scholarsAccounts[$i]->account_name,
                            'category'     => 3, // Scholar Terminated
                            'status'       => 1,
                            'status_scholar' => 1,
                        ]);
                    }
                PlayerScholarHistory::WHERE('scholar_id',$request->id)->UPDATE(['status' => 0]);
            }

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
        $accountName = $request->account_name;
        
        $queryRequest = array_slice($request->all(), 3);
        $where        = [];

        $from = Carbon::parse('01-01-2020');
        $to   = Carbon::now();

        if(is_null($date) == false){
            $from = Carbon::parse(strtotime(str_replace("T16:00:00.000Z","",$request->date[0])));
            $to   = Carbon::parse(strtotime(str_replace("T16:00:00.000Z","",$request->date[1])));
        }
        
        $field     = ($queryRequest) ? explode('|', $request->sort)[0] : 'created_at';
        $direction = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';
            
        array_push($where, ['scholars.username', '=', $username]);
        array_push($where, ['report.average_per_day', '!=', null]);
        array_push($where, ['report.name','=',$accountName]);

        return Scholar:: LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'history.player_id', '=', 'players.id')
            ->LEFTJOIN('report', 'report.name', '=', 'players.account_name')
            ->WHERE($where)
            ->when(is_null($date) == false, function ($query) use ($date,$from,$to) {
                $query->whereBetween('report.created_at', [$from, $to]);
            })
            ->ORDERBY('report.batch', 'desc')
            ->PAGINATE(15);
    }

    public function getScholarReport(Request $request){
        $accountName = $request->account_name;
        $username = Auth::user()->username;
        return Scholar:: LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
            ->LEFTJOIN('players', 'history.player_id', '=', 'players.id')
            ->LEFTJOIN('report', 'report.name', '=', 'players.account_name')
            ->WHERE([['scholars.username', $username],['report.name',$accountName],['report.average_per_day', '!=', null]])
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
        $date = $request->date;
        $accountName = $request->account_name;
        
        $from = Carbon::parse('01-01-2020');
        $to   = Carbon::now();

        if(is_null($date) == false){
            $from = Carbon::parse(strtotime(str_replace("T16:00:00.000Z","",$request->date[0])));
            $to   = Carbon::parse(strtotime(str_replace("T16:00:00.000Z","",$request->date[1])));
        }
            
        return Report::LEFTJOIN('players', 'report.name', '=', 'players.account_name')
        ->LEFTJOIN('player_scholar_histories as history', 'players.id', '=', 'history.player_id')
        ->LEFTJOIN('scholars', 'history.scholar_id', '=', 'scholars.id')
        ->SELECT(
            'report.*'                
        )
        ->WHERE('scholars.username', $username)
        ->WHERE('report.name', $accountName)
        ->when(is_null($date) == false, function ($query) use ($date,$from,$to) {
            $query->whereDateBetween('report.created_at',$from,$to);
        })
        ->GET();
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
                PlayerScholarHistory::WHERE('scholar_id', $id)->DELETE();

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
        ->WHERE([['scholars.username', $username],['notification.status_scholar', 1]])
        ->GET();

    }

    public function changeStatusNotification(){
        try {
            $glblCtrl = new GlobalController;
            $scholarsAccounts = $glblCtrl->getListAccounts();

            for($i=0;$i< count($scholarsAccounts);$i++){
                Notification::WHERE('account_name',$scholarsAccounts[$i]->account_name)->WHERE('status_scholar',1)->update(['status_scholar' => 2]);
            }
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }
}
