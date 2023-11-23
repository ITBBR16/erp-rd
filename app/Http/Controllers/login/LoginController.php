<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if($token = JWTAuth::attempt($credentials)) {
            $cookie = cookie('jwt_token', $token, 60 * 24);

            return redirect('/customer')->withCookie($cookie);
        }

        return back()->with('loginError', 'Failed to Login!');
    }

    public function logout()
    {
        $token = request()->cookie('jwt_token');

        JWTAuth::setToken($token)->invalidate();

        $cookie = Cookie::forget('jwt_token');

        Session::flush();
        Session::put('_token', null);


        return redirect('/login')->withCookie($cookie);
    }

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if(Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return redirect()->intended('/customer');
    //     }

    //     return back()->with('loginError', 'Failed to Login!');
    // }

    // public function logout(Request $request)
    // {
    //     Auth::logout();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->away('/login');
    // }
}
