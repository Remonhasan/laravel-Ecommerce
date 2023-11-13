<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                $userId = Auth::id();
                $roleId   = DB::table('role_user')->where('user_id', $userId)->value('role_id');
                $roleName = DB::table('roles')->where('id', $roleId)->value('name');

                if ($roleName == 'user') {
                    return redirect()->route('user.profile');
                }
                
                return redirect()->route('admin.dashboard');
                // return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
