<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AccessControl
{    
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');

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

            if ($user->is_admin == 1) {
                return $next($request);
            }

            if (in_array($user->is_admin, [2,3]) && $user->divisi_id == 1) {
                return $next($request);
            }

            if (in_array($user->is_admin, [2,3]) && $user->divisi_id == 6) {
                return $next($request);
            }

        } else {
            return $this->redirectAndForgetCookie();
        }

    }

    private function redirectAndForgetCookie()
    {
        return Redirect::to('login')->withCookie(cookie()->forget('jwt_token'));
    }

}
