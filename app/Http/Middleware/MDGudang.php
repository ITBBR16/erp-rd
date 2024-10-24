<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class MDGudang
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');

        if (auth()->check()) {
            return redirect('/gudang/analisa');
        }

        if ($this->shouldBypassAuthentication($request)) {
            return redirect('/gudang/analisa');
        }

        if ($token) {
            try {
                $user = JWTAuth::setToken($token)->authenticate();
            } catch (TokenExpiredException $e) {
                return $this->redirectAndForgetCookie();
            } catch (TokenInvalidException $e) {
                return $this->redirectAndForgetCookie();
            } catch (JWTException $e) {
                return $this->redirectAndForgetCookie();
            }

            if ($this->isAdminOrHasPermission($user)) {
                return $next($request);
            } else {
                return back();
            }
        }

        return $this->redirectAndForgetCookie();
    }

    private function shouldBypassAuthentication($request)
    {
        return $request->path() === 'login';
    }

    private function isAdminOrHasPermission($user)
    {
        return $user->is_admin == 1 || ($user->is_admin == 2 && $user->divisi_id == 4) || ($user->is_admin == 3 && $user->divisi_id == 4);
    }

    private function redirectAndForgetCookie()
    {
        return Redirect::to('login')->withCookie(cookie()->forget('jwt_token'));
    }

}
