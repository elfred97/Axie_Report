<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
//        $this->middleware('guest:admins')->except('logout');
//        $this->middleware('guest:scholars')->except('logout');
    }

    public function showLoginForm()
    {
        if(Auth::guard('admins')->check()){
            return redirect('/');
        }
        if(Auth::guard('scholars')->check()){
            return redirect('/scholars');
        }
        return view('login');
    }

    public function username()
    {
        return 'username';
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    protected function guard()
    {
        $type = \request('type');
        $type = in_array($type, ['admins', 'scholars']) ? $type : 'scholars';
        return Auth::guard($type);
    }

    protected function authenticated(Request $request, $user)
    {
        if(\auth()->guard('admins')->check()) {
            return redirect(url('home'));
        } else {
            return redirect(url('scholars'));
        }
    }

    public function redirectTo(Request $request)
    {
        if(\auth()->guard('admins')->check()) {
            return redirect(url('home'));
        } else {
            return redirect(url('scholars'));
        }
    }

}
