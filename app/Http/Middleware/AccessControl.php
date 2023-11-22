<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessControl
{    
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
    
        $user = Auth::user();

        if($user && ($user->is_admin == 1 || $user->is_admin == 2)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    
    }
}
