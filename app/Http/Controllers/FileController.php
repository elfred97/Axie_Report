<?php

namespace App\Http\Controllers;

use DB;
use File;
use Excel;
use Carbon\Carbon;
use Storage;
use Illuminate\Http\Request;
use App\Models\reportModel as ReportModel;
use App\Models\Player;
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
            array_push($where, ['p.type', '=', $type]);

        $field          = ($queryRequest) ? explode('|', $request->sort)[0] : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';

        return DB::TABLE('report as r')
            ->LEFTJOIN('player as p', 'p.account_name', '=', 'r.name')
            ->SELECT(
                'r.name as account_name',
                'p.status',
                'p.type',
                DB::RAW('CONCAT(p.first_name, " ", p.last_name) as player_name'),
                'r.*'
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
            array_push($where, ['p.type', '=', $request->type]);

        return DB::TABLE('report as r')
            ->LEFTJOIN('player as p', 'p.account_name', '=', 'r.name')
            ->SELECT(
                'r.name as account_name',
                'p.status',
                DB::RAW('concat(p.first_name," ",p.last_name) as player_name'),
                'p.penalty',
                'r.*'
            )
            ->WHERE($where)
            ->orderBy($sortType, $request->sortOrder)
            ->GET()
            ->GROUPBY('account_name');
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

        if ($year)
            array_push($where, [DB::raw('YEAR(r.created_at)'), '=', $year]);

        if ($month)
            array_push($where, [DB::raw('MONTH(r.created_at)'), '=', $month]);

        if ($type)
            array_push($where, ['p.type', '=', $type]);

        return DB::TABLE('report as r')
            ->SELECT(DB::raw("SUM(r.total_slp) as slp, SUM(r.unclaimed) as unclaimed, SUM(r.claimed) as claimed, DATE(r.created_at) as date"))
            ->LEFTJOIN('player AS p', 'p.account_name', '=', 'r.name')
            ->groupBy('date')
            ->where($where)
            ->GET(array(
                DB::raw('Date(r.created_at) as date'),
            ));
    }

    public function getNotification(Request $request){
        if($request->date != NULL){
            $notification = DB::TABLE('notification as n')
                ->SELECT('n.*', DB::RAW('concat(p.first_name," ",p.last_name) as player_name'))
                ->LEFTJOIN('player AS p', 'p.account_name', '=', 'n.account_name')
                ->whereDate('n.created_at', Carbon::parse($request->date))
                ->PAGINATE(15);
        }else
            $notification = DB::TABLE('notification as n')
                ->SELECT('n.*', DB::RAW('concat(p.first_name," ",p.last_name) as player_name'))
                ->LEFTJOIN('player AS p', 'p.account_name', '=', 'n.account_name')
                ->PAGINATE(15);

        return $notification;
    }

}
