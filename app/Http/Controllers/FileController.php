<?php

namespace App\Http\Controllers;

use App\Imports\PayrollImport;
use DB;
use Auth;
use File;
use Excel;
use Carbon\Carbon;
use Storage;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Player;
use App\Models\Type;
use App\Imports\ReportImport;
use App\Models\Notification;
use App\Models\importModel as ImportModel;

class FileController extends Controller
{
    public function importZipQR(Request $request){
        $zip = new \ZipArchive();
        $file = $request->file('file');
        $zip->open($file->path());
        $path = 'uploads/qr_codes/';
        $zip->extractTo($path);
        for($i=0;$i<$zip->numFiles;$i++){
            $fileName = substr($zip->getNameIndex($i),1);
            $n = $zip->getNameIndex($i);
            rename(public_path().'/uploads/qr_codes/'.$n,public_path().'/uploads/qr_codes/'.$fileName);
            Player::where('account_name', '#'.explode(".",$fileName)[0])
                ->update(['qr_code' => 'qr_codes/'.$fileName,'qr_code_date' => Carbon::now()]);
        }
        $zip->close();  
    }

    public function importPayroll(Request $request){
        Excel::import(new PayrollImport, $request->file);
        return "File Uploaded";
    }
    public function import(Request $request){
        Excel::import(new ReportImport, $request->file);
        return "File Uploaded";
    }

    public function getImportedReport(Request $request){
        $queryRequest   = array_slice($request->all(), 3);
        $type  = $request->type;
        $where = [];

        if ($type)
            array_push($where, ['s.type_id', '=', $type]);

        $field          = ($queryRequest) ? str_replace("_field","",explode('|', $request->sort)[0]) : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';
        
        return DB::TABLE('report as r')
            ->LEFTJOIN('players as p', 'p.account_name', '=', 'r.name')
            ->LEFTJOIN('player_scholar_histories as psh', 'p.id', '=', 'psh.player_id')
            ->LEFTJOIN('scholars as s', 's.id', '=', 'psh.scholar_id')
            ->LEFTJOIN('type as t', 't.id', '=', 's.type_id')
            ->SELECT(
                'r.name as account_name',
                's.type_id',
                DB::RAW('CONCAT(s.first_name, " ", s.last_name) as player_name'),
                'r.*',
                't.name as type_name',
                )
            ->where($where)
            ->orderBy($field, $direction)
            ->PAGINATE($request->per_page);
    }

    public function getReport(Request $request){
        $queryRequest   = array_slice($request->all(), 3);
        $where = [];

        if ($request->type)
            array_push($where, ['s.type_id', '=', $request->type]);

        $field          = ($queryRequest) ? str_replace("_field","",explode('|', $request->sort)[0]) : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';    

        $latest_id_per_account = DB::table('report as r')
                        ->select(DB::raw('max(id) as id'))->groupBy('ronin_address')->pluck('id');

        $reports =  DB::TABLE('report as r')
            ->LEFTJOIN('players as p', 'p.account_name', '=', 'r.name')
            ->LEFTJOIN('player_scholar_histories as psh', 'p.id', '=', 'psh.player_id')
            ->LEFTJOIN('scholars as s', 's.id', '=', 'psh.scholar_id')
            ->LEFTJOIN('type as t', 't.id', '=', 's.type_id')
            ->SELECT(
                'r.name as account_name',
                DB::RAW('concat(s.first_name," ",s.last_name) as player_name'),
                'p.penalty',
                'r.*',
                't.name as type_name',
            )
            ->WHERE($where)
            ->orderBy($field,$direction)
            ->whereIn('r.id', $latest_id_per_account)
            ->paginate($request->get('per_page', 15));

        // return $this->buildJson(compact('reports'));
        return $reports;
    }

    public function getTotalReportbyDate(Request $request){
        return DB::TABLE('report')->GET();
    }

    public function getTotalReport(Request $request){
        return DB::TABLE('report')->GET();
    }

    public function getGraph(Request $request){
        $year  = $request->year;
        $month = $request->month;
        $type  = $request->type;
        $account_name  = $request->account_name;
        $where = [];

        // $typeData = Type::WHERE('id', $type)->FIRST();

        if ($year)
            array_push($where, [DB::raw('YEAR(r.created_at)'), '=', $year]);

        if ($month)
            array_push($where, [DB::raw('MONTH(r.created_at)'), '=', $month]);

        if ($type)
            array_push($where, ['s.type_id', '=', $type]);
        
        if ($account_name)
            array_push($where, ['r.name', '=', $account_name]);

        return DB::TABLE('report as r')
            ->SELECT(DB::raw("SUM(r.total_slp) as slp, SUM(r.unclaimed) as unclaimed, SUM(r.claimed) as claimed, DATE(r.created_at) as date"))
            ->LEFTJOIN('players as p', 'p.account_name', '=', 'r.name')
            ->LEFTJOIN('player_scholar_histories as history', 'history.player_id', '=', 'p.id')
            ->LEFTJOIN('scholars as s', 's.id', '=', 'history.scholar_id')
            ->groupBy('date')
            ->where($where)
            ->when($account_name, function ($query) use ($account_name) {
                $query->where('p.account_name', $account_name);
            })
            ->GET(array(
                DB::raw('Date(r.created_at) as date'),
            ));
    }

    public function getNotification(Request $request){
        $queryRequest   = array_slice($request->all(), 3);
        $field          = ($queryRequest) ? str_replace("_field","",explode('|', $request->sort)[0]) : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';
        $latest_id_per_account = DB::table('battle_logs as r')
            ->select(DB::raw('max(id) as id'))->groupBy('ronin_address')->pluck('id');
    
        $from = Carbon::parse('01-01-2020');
        $to   = Carbon::now();

        if($request->date){
            $from = ($request->date[0]) ? Carbon::parse($request->date[0]) : $from;
            $to   = ($request->date[1]) ? Carbon::parse($request->date[1]) : $to;
        }

        $notification = DB::TABLE('notification as n')
        ->SELECT('n.*', DB::RAW('concat(s.first_name," ",s.last_name) as player_name'), 'r.gained_slp_today', 'r.mmr')
            ->LEFTJOIN('players as p', 'p.account_name', '=', 'n.account_name')
            ->LEFTJOIN('player_scholar_histories as psh', 'p.id', '=', 'psh.player_id')
            ->LEFTJOIN('scholars as s', 's.id', '=', 'psh.scholar_id')
            ->LEFTJOIN('battle_logs as r', 'r.account_name', '=', 'n.account_name')
            ->where('n.status',1)
            ->whereIn('r.id', $latest_id_per_account)
            ->ORDERBY($field,$direction);
        
            if($request->date == 'today') {
                $notification = $notification->get();
            }
            else{
                $notification = $notification->whereBetween('n.created_at', [$from, $to])->PAGINATE(15);
            }

        return $notification;
    }

    public function changeStatusNotification(){
        try {
            $notif = DB::table('notification')->where('status', '=', 1)->update(array('status' => 2));
            if($notif)
                return response()->json(['message' => 'Notification has been read!'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }


    public function showFile($file_name, Request $request){
        // $type = $request->type;
        // if($type == 'qr_code'){
        //     if ($file_name){
                // return Storage::get('qr_codes/samuel_johnson.JPG');
                return File::get(public_path('file.jpg'));
        //     }
        //     else
        //         return Storage::get(public_path('img/'.'default.jpg'));
        // }
    }

}
