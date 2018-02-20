<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_permissions = $userId = Auth::user()->permissionList;
        if(cp(9, $user_permissions))
            return $next($request);
        else
            return redirect('/');
    }
}
