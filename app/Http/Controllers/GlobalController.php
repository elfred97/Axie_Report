<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Type;
use App\Models\Payroll;
use App\Models\Scholar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\IsUniqueExceptDeleted;
class GlobalController extends Controller
{
    //
    protected function index(Request $request){
        $user = $request->user();
        $user->load('notification_settings');

        // $notification_settings = $user->notification_settings;
        // return view('main', compact('notification_settings'));
        return view('main');
    }

    public function redirectMain(){
        if(auth()->guard('admins')->check()) {
            return redirect('home');
        }

        return redirect('scholars');
    }

    protected function login(Request $request){
        if (Auth::check()) return redirect('/');
        $this->restoreDefaults();

        $username = $request->username;
        $password = $request->password;
        $type = $request->type;
        $error    = 0;

        $user = User::WHERE('username', $username)->FIRST();

        if (empty($username)) {
            session()->flash('error', ['username', 'Please enter your username']);
            return $this->error($username, $password);
        }else if (empty($password)) {
            session()->flash('error', ['password', 'Please enter your password']);
            return $this->error($username, $password);
        }else if (empty($user)) {
            session()->flash('error', ['username', 'Username not found']);
            return $this->error($username, $password);
        }

        if (!Auth::attempt(array('username' => $username, 'password' => $password))) {
            session()->flash('error', ['password', 'Incorrect password']);
            return $this->error($username, $password);
        }

        return redirect()->intended('home');
    }

    protected function logout(Request $request){
        Auth::logout();
        return redirect('login');
    }

    protected function showLogin(){
        return view('login');
    }

    public function getAccountInfo($type){
        if($type == 'admins')
            return User::WHERE('username', Auth::user()->username)->FIRST();
        else if($type == 'scholars'){
            $username = Auth::user()->username;

            return Scholar:: LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
                ->LEFTJOIN('players', 'history.player_id', '=', 'players.id')
                ->LEFTJOIN('type', 'type.id', '=', 'scholars.type_id')
                ->SELECT('scholars.*', 'players.*', 'type.name as type_name')
                ->WHERE('scholars.username', $username)
                ->FIRST();
        }
    }

    public function getUsers(){
        return User::WHERE([['username', '!=', Auth::user()->username], ['status', '!=', 3]])->GET();
    }

    public function updateAccountInfo(Request $request){
        try {
            $user = User::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'first_name' => $request->first_name,
                    'middle_name'=> $request->middle_name,
                    'last_name'  => $request->last_name,
                    'username'   => $request->username,
                ]
            );
            if($user)
                return response()->json(['message' => 'Account Informations is saved'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function updateUser(Request $request){
        $sanitizeUsername = filter_var(preg_replace('/\s+/','',$request->username),FILTER_SANITIZE_STRING);
        $ruleUsername = isset($request->id) ? (User::findOrFail($request->id)->username == $sanitizeUsername ? ['required'] : 
        ['required',new IsUniqueExceptDeleted]) : 
        ['required',new IsUniqueExceptDeleted];
        $validator = Validator::make(
			$request->all(),
			[
				'username'    => $ruleUsername,
				'first_name'  => 'required',
				'last_name'   => 'required',
				// 'middle_name' => 'required',
			]
		);

		if ($validator->fails())
			return response()->json($validator->errors(), 422);

		try {
            $user = User::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'username'    => filter_var(preg_replace('/\s+/','',$request->username),FILTER_SANITIZE_STRING),
                    'first_name'  => filter_var($request->first_name,FILTER_SANITIZE_STRING),
                    'middle_name' => filter_var($request->middle_name,FILTER_SANITIZE_STRING),
                    'last_name'   => filter_var($request->last_name,FILTER_SANITIZE_STRING),
                    'password'    => filter_var(Hash::make($request->new_password),FILTER_SANITIZE_STRING),
                    'status'      => $request->status,
                ]
            );
            if($user)
                return response()->json(['message' => 'User Informations is saved'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function deleteUser(Request $request){
        try {
            $user = User::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'status'      => 3,
                ]
            );
            if($user)
                return response()->json(['message' => 'User deleted'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function restoreUser(Request $request){
        try {
            $user = User::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'status'      => 1,
                ]
            );
            if($user)
                return response()->json(['message' => 'User restored'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    protected function error($username, $password){
        session()->flash('username', $username);
        session()->flash('password', $password);
        return redirect('login');
    }

    protected function restoreDefaults() {
        session()->flush();
    }

    public function getType(Request $request){
        $where = [];
        $status = $request->status;

        if($status)
            array_push($where, ['status', '=', $status]);

        array_push($where, ['status', '!=', 'Deleted']);

        return Type::WHERE($where)->ORDERBY('id', 'desc')->GET();
    }

    public function saveNewType(Request $request){
        $validator = Validator::make(
            $request->all(),
			[
                'name'      => 'required|unique:type',
            ]
        );

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

            if($request->name){
                $type = Type::CREATE([
                    'name'   => $request->name,
                    'status' => 'Active'
                ]);
                if($type)
                    return response()->json(['message' => 'Type saved'], 200);
                else
                    return response()->json(['message' => 'There was a problem processing your request'], 500);
            }
    }

    public function updateType(Request $request){
        $typeName = Type::findOrFail($request->id)->name;
        $rule = $typeName == $request->name ? 'required' : 'required|unique:type';
        $validator = Validator::make(
            $request->all(),
			[
                'name'      => $rule,
            ]
        );

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        try {
            $user = Type::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'name'   => $request->name,
                    'status' => $request->status,
                ]
            );
            if($user)
                return response()->json(['message' => 'Type Informations is saved'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function deleteType(Request $request){
        try {
            $user = Type::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'status'      => 'Deleted',
                ]
            );
            if($user)
                return response()->json(['message' => 'Type deleted'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function restoreType(Request $request){
        try {
            $user = Type::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'status'      => 'Active',
                ]
            );
            if($user)
                return response()->json(['message' => 'Type restored'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function changePassword(Request $request){

        $validator = Validator::make(
			$request->all(),
			[
				'password'         => 'required',
				'new_password'     => 'required|required_with:confirm_password|same:confirm_password',
				'confirm_password' => 'required',
				// 'middle_name' => 'required',
			]
		);

        if ($validator->fails())
			return response()->json($validator->errors(), 422);

        $password         = $request->password;
        $new_password     = $request->new_password;
        $confirm_password = $request->confirm_password;

        if(!Hash::check($password, Auth::user()->password))
            return response()->json(['password' => 'Password did not match'], 422);

        try{
            $user = User::UPDATEORCREATE(
                [ 'username' => Auth::user()->username ],
                [
                    'password'      => Hash::make($new_password),
                ]
            );
            if($user)
                return response()->json(['message' => 'User password changed'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()], 500);
		}
    }

    public function getPayrollHistory($status, Request $request){
        $status = ($status == 'pending') ? 0 : 1;
        $year  = $request->year;
        $month = $request->month;
        $type  = $request->type;
        $search  = $request->search;
        $where = [];
        $queryRequest   = array_slice($request->all(), 3);

        $field          = ($queryRequest) ? str_replace("_field","",explode('|', $request->sort)[0]) : 'created_at';
        $direction      = ($queryRequest) ? explode('|', $request->sort)[1] : 'desc';

        array_push($where, ['payrolls.status', '=', $status]);

        if ($year)
            array_push($where, [DB::raw('YEAR(payrolls.created_at)'), '=', $year]);

        if ($month)
            array_push($where, [DB::raw('MONTH(payrolls.created_at)'), '=', $month]);

        if ($type)
            array_push($where, ['scholars.type_id', '=', $type]);

        if ($search)
            array_push($where, [DB::RAW("CONCAT(scholars.first_name,' ',scholars.last_name)"), 'LIKE', '%'.$search.'%']);

        return Payroll::LEFTJOIN('players', 'payrolls.player_id', '=', 'players.id')
        ->LEFTJOIN('scholars', 'payrolls.scholar_id', '=', 'scholars.id')
        ->LEFTJOIN('type', 'scholars.type_id', '=', 'type.id')
        ->SELECT(
            'payrolls.*',
            DB::RAW('concat(scholars.first_name," ",scholars.last_name) as player_name'),
            'players.account_name',
            'players.ronin_address',
            'type.name as type_name'
        )
        ->where($where)
        ->ORDERBY($field,$direction)
        ->paginate($request->per_page);
    }

    public function getScholarPayrollHistory(Request $request){
        $username = Auth::user()->username;        
        return Payroll::LEFTJOIN('scholars', 'payrolls.scholar_id', '=', 'scholars.id')
                ->LEFTJOIN('players', 'payrolls.player_id', '=', 'players.id')
                ->SELECT(
                    'payrolls.*',
                    'players.account_name as account_name'
                )
                ->WHERE('scholars.username', $username)
                ->WHERE('payrolls.txn_id', 'like', '%'.$request->search.'%')
                ->ORDERBY('payrolls.id', 'desc')
                ->GET();
    }
    public function updatePayrollHistory(Request $request){
        try{
            $payroll = Payroll::UPDATEORCREATE(
                ['id' => $request->id],
                [
                    'txn_id' => $request->txn_id,
                    'status' => $request->status
                ]
            );
            if($payroll)
                return response()->json(['message' => 'Payroll paid'], 200);
            else
                return response()->json(['message' => 'There was a problem processing your request'], 500);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
