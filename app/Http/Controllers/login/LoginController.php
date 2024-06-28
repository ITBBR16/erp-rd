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
        if (auth()->check()) {

            if (auth()->user()->is_admin == 1) {
                return redirect('/');
            } elseif (auth()->user()->is_admin == 2 && auth()->user()->divisi_id == 1) {
                return redirect('/kios/analisa/dashboard');
            } elseif (auth()->user()->is_admin == 2 && auth()->user()->divisi_id == 6) {
                return redirect('/logistik');
            } elseif (auth()->user()->is_admin == 2 && auth()->user()->divisi_id == 2) {
                return redirect('/repair/customer/list-customer');
            }

        } else {

            return view('auth.login', [
                'title' => 'Login'
            ]);

        }

    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if($token = JWTAuth::attempt($credentials)) {
            $cookie = cookie('jwt_token', $token, 60 * 24);
            $user = JWTAuth::setToken($token)->authenticate();
            if($user->is_admin == 1){
                return redirect('/')->withCookie($cookie);
            } elseif($user->is_admin == 2 && $user->divisi_id == 1){
                return redirect()->intended('/kios/analisa/dashboard')->withCookie($cookie);
            } elseif($user->is_admin == 2 && $user->divisi_id == 6){
                return redirect()->intended('/logistik')->withCookie($cookie);
            } elseif (auth()->user()->is_admin == 2 && auth()->user()->divisi_id == 2) {
                return redirect('/repair/customer/list-customer')->withCookie($cookie);
            }

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

}
