<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    protected function authenticated(Request $request, $user)
//    {
//
//        if ($user->isAdmin()) {// do your margic here
//            return redirect('/admin');
//        }
//        if ($user->isDoctor()) {// do your margic here
//            return redirect()->route('manger.index');
//        }
//        if ($user->isStudentAffair()) {// do your margic here
//            return redirect()->route('pharmacy.index');
//        }
//        if ($user->isStudent()) {// do your margic here
//            return redirect()->route('pharmacy.index');
//        }
//
//        return redirect('/');
//    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
