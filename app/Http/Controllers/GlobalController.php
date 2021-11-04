<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\UserModel as UserModel;

class GlobalController extends Controller
{
    //
    protected function index(){
        return view('main');
    }
    
    protected function showLogin(){
        return view('login');
    }

    public function getAccountInfo(){
        return UserModel::WHERE('username', Auth::user()->username)->FIRST();
    }

    public function getUsers(){
        return UserModel::WHERE('username', '!=', Auth::user()->username)->GET();
    }

    public function updateAccountInfo(Request $request){

        try {
            $user = UserModel::UPDATEORCREATE(
                [ 'id' => $request->id ],
                [
                    'first_name' => $request->first_name,
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
    
    protected function login(Request $request){
        if (Auth::check()) return redirect('/');
        $this->restoreDefaults();

        $username = $request->username;
        $password = $request->password;
        $error    = 0;        
        
        $user = UserModel::WHERE('username', $username)->FIRST();
        
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
        // $access = new AccessController;
        // if (isset($request->expired)) {
        //     session()->flash('expired', 'true');
        //     session()->flash('username', Auth::user()->username);
        // }

        // $access->removeEmergencyAccess();

        Auth::logout();

        // $this->restoreDefaults();

        return redirect('login');   
    }
    
    protected function error($username, $password){
        session()->flash('username', $username);
        session()->flash('password', $password);
        return redirect('login');
    }

    protected function restoreDefaults() {
        session()->flush();
    }

    public function getType(){
        return DB::TABLE('type')->GET();
    }
    
    public function saveNewType(Request $request){

    }

    public function updateorcreateType(Request $request){
        
    }

    public function getNotificationSettings(){

    }

    public function updateorcreateNotificationSettings(Request $request){
        
    }
}
