<?php

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\employee\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

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
                return redirect('/repair/customer/list-customer-repair');
            } elseif (auth()->user()->is_admin == 2 && auth()->user()->divisi_id == 4) {
                return redirect('/gudang/purchasing/belanja-sparepart');
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

        $user = Employee::whereRaw('BINARY username = ?', [$credentials['username']])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = JWTAuth::fromUser($user);

            $now = now();
            $midnight = $now->copy()->endOfDay();
            $minutesUntilMidnight = $now->diffInMinutes($midnight);

            $cookie = cookie('jwt_token', $token, $minutesUntilMidnight);

            if ($user->statusEmployee->status == 'Super Admin') {
                return redirect('/')->withCookie($cookie);
            } elseif ($user->statusEmployee->status == 'Admin' && $user->divisiEmployee->nama == 'Kios') {
                return redirect()->intended('/kios/analisa/dashboard')->withCookie($cookie);
            } elseif ($user->statusEmployee->status == 'Admin' && $user->divisiEmployee->nama == 'Logistik') {
                return redirect()->intended('/logistik')->withCookie($cookie);
            } elseif ($user->statusEmployee->status == 'Admin' && $user->divisiEmployee->nama == 'Repair') {
                return redirect('/repair/csr/case-list')->withCookie($cookie);
            } elseif ($user->statusEmployee->status == 'Admin' && $user->divisiEmployee->nama == 'Gudang') {
                return redirect('/gudang/purchasing/belanja-sparepart')->withCookie($cookie);
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
