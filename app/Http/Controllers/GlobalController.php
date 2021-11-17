<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Type;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;

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

    public function getAccountInfo(){
        return User::WHERE('username', Auth::user()->username)->FIRST();
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
        $validator = Validator::make(
			$request->all(),
			[
				'username'    => 'required',
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
                    'username'    => $request->username,
                    'first_name'  => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name'   => $request->last_name,
                    'password'    => Hash::make($request->new_password),
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
                [ 'username' => $request->username ],
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

    public function getScholarImport(Request $request){
        return Player::PAGINATE(15);
    }
}
