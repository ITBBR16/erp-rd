<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use App\Models\employee\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function authentic(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $employee = Employee::where('username', $credentials['username'])->first();

        if($employee) {
            
            $request->session()->regenerate();
    
            return redirect()->intended('/customer');
        }

        return back()->with('loginError', 'Failed to Login !');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
