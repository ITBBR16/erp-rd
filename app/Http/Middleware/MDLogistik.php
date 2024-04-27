<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class MDLogistik
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');

        if (auth()->check()) {
            return redirect('/logistik');
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

            if ($this->isAdminInDivision($user)) {
                return $next($request);
            } else {
                return back();
            }
        }

        return $this->redirectAndForgetCookie();
    }

    private function isAdminInDivision($user)
    {
        return $user->is_admin == 1 || ($user->is_admin == 2 && $user->divisi_id == 6) || ($user->is_admin == 3 && $user->divisi_id == 6);
    }

    private function redirectAndForgetCookie()
    {
        return Redirect::to('login')->withCookie(cookie()->forget('jwt_token'));
    }

}
