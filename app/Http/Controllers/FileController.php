<?php

namespace App\Http\Controllers;

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

        $field          = ($queryRequest) ? explode('|', $request->sort)[0] : 'created_at';
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
            ->orderBy('r.created_at', 'desc')
            ->PAGINATE($request->per_page);
    }

    public function getReport(Request $request){
        $where = [];

        $sortType = (isset($request->sortType)) ? $request->sortType : 'r.name';
        $type = (isset($request->type)) ? $request->type : 'Trust';

        if ($request->type)
            array_push($where, ['s.type_id', '=', $request->type]);


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
            // ->orderBy($sortType, $request->sortOrder)
            ->orderBy($sortType, 'asc')
            ->whereIn('r.id', $latest_id_per_account)
//            ->GROUPBY('account_name')
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
        $where = [];

        // $typeData = Type::WHERE('id', $type)->FIRST();

        if ($year)
            array_push($where, [DB::raw('YEAR(r.created_at)'), '=', $year]);

        if ($month)
            array_push($where, [DB::raw('MONTH(r.created_at)'), '=', $month]);

        if ($type)
            array_push($where, ['s.type_id', '=', $type]);

        return DB::TABLE('report as r')
            ->SELECT(DB::raw("SUM(r.total_slp) as slp, SUM(r.unclaimed) as unclaimed, SUM(r.claimed) as claimed, DATE(r.created_at) as date"))
            ->LEFTJOIN('players as p', 'p.account_name', '=', 'r.name')
            ->LEFTJOIN('player_scholar_histories as history', 'history.player_id', '=', 'p.id')
            ->LEFTJOIN('scholars as s', 's.id', '=', 'history.scholar_id')
            ->groupBy('date')
            ->where($where)
            ->GET(array(
                DB::raw('Date(r.created_at) as date'),
            ));
    }

    public function getNotification(Request $request){
        if($request->date == 'today'){
            $notification = DB::TABLE('notification as n')
            ->SELECT('n.*', DB::RAW('concat(s.first_name," ",s.last_name) as player_name'), 'r.gained_slp_today')
                ->LEFTJOIN('players as p', 'p.account_name', '=', 'n.account_name')
                ->LEFTJOIN('player_scholar_histories as psh', 'p.id', '=', 'psh.player_id')
                ->LEFTJOIN('scholars as s', 's.id', '=', 'psh.scholar_id')
                ->LEFTJOIN('report as r', 'r.name', '=', 'n.account_name')
                ->whereDate('n.created_at', Carbon::parse($request->date))
                ->ORDERBY('n.created_at', 'desc')
                ->GET();
        }else{
            $from = Carbon::parse($request->date[0]);
            $to   = Carbon::parse($request->date[1]);
            $notification = DB::TABLE('notification as n')
                ->SELECT('n.*', DB::RAW('concat(s.first_name," ",s.last_name) as player_name'), 'r.gained_slp_today', 'r.mmr')
                ->LEFTJOIN('players as p', 'p.account_name', '=', 'n.account_name')
                ->LEFTJOIN('player_scholar_histories as psh', 'p.id', '=', 'psh.player_id')
                ->LEFTJOIN('scholars as s', 's.id', '=', 'psh.scholar_id')
                ->LEFTJOIN('report as r', 'r.name', '=', 'n.account_name')
                ->whereBetween('report.created_at', [$from, $to])
                ->ORDERBY('n.created_at', 'desc')
                ->PAGINATE(15);
        }

        return $notification;
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
