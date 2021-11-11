<?php

namespace App\Http\Controllers\Scholars;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use File;
use App\Models\Scholar;
use App\Imports\ScholarImport;

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
        return Scholar::PAGINATE(15);
    }
}
