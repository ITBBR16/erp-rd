<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');

        if ($token) {
            try {
                $user = JWTAuth::setToken($token)->authenticate();
            } catch (\Exception $e) {
                return $this->redirectAndForgetCookie();
            }

            if ($request->path() === 'login') {
                return $next($request);
            }

            if($user->is_admin == 1){
                return $next($request);
            } else {
                return back();
            }
        } else{
            return $this->redirectAndForgetCookie();
        }

        abort(403, 'Unauthorized action.');
    }

    private function redirectAndForgetCookie()
    {
        return Redirect::to('login')->withCookie(cookie()->forget('jwt_token'));
    }
}
