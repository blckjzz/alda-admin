<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login()
    {
        if (Auth::user()) {
            if (Auth::user()->hasRole('conselheiro'))
                return redirect()->route('conselheiro.dashboard');
            else
                return redirect()->route('voyager.dashboard');
        }
        return Voyager::view('voyager::login');
    }

    public function novoLogin(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /*
     * Preempts $redirectTo member variable (from RedirectsUsers trait)
     */
    public function redirectTo()
    {
        if (Auth::user()->hasRole('conselheiro'))
            return route('conselheiro.dashboard');
        return route('voyager.dashboard');
    }


    public function logout()
    {
        return redirect()->route('voyager.login')->with(Auth::logout());
    }

}