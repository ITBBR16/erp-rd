<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class MDKios
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');

        if (auth()->check()) {
            return redirect('/kios/analisa/dashboard');
        }

        if ($request->path() === 'login') {
            return $next($request);
        }

        if ($token) {
            try {
                $user = JWTAuth::setToken($token)->authenticate();
            } catch (\Exception $e) {
                return $this->redirectAndForgetCookie();
            }

            if ($request->path() === 'login') {
                return $next($request);
            }

            if ($user->is_admin == 1 || ($user->is_admin == 2 && $user->divisi_id == 1) || ($user->is_admin == 3 && $user->divisi_id == 1)) {
                return $next($request);
            } else {
                return back();
            }
        }

        return $this->redirectAndForgetCookie();
    }

    private function redirectAndForgetCookie()
    {
        return Redirect::to('login')->withCookie(cookie()->forget('jwt_token'));
    }

}
