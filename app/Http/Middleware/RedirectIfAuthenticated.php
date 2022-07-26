<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            // check if the request is for "panel/login", logout the user and redirect him to "/panel/login"
            if ($request->decodedPath() == "panel/login") {
                return redirect(route('show-confirm-logout', ['type' => 'user']));
            }

            // this data can be sent from auth/show-confirm-logout.blade.php
            if ($request->has('type') and $request->input('type') == 'user') {
                // it means user confirmed to logout
                Auth::guard()->logout();
                return redirect(route('show-admin-login-form'));
            }

            return redirect(RouteServiceProvider::HOME);
        }

        // change the redirect path if user is admin
        if (Auth::guard('admin')->check()) {
            // check if the request is for "login", logout the admin and redirect him to "/login"
            if ($request->decodedPath() == "login") {
                return redirect(route('show-confirm-logout', ['type' => 'admin']));
            }

            // this data can be sent from auth/show-confirm-logout.blade.php
            if ($request->has('type') and $request->input('type') == 'admin') {
                // it means user confirmed to logout
                Auth::guard('admin')->logout();
                return redirect('/login');
            }

            return redirect(RouteServiceProvider::ADMIN_HOME);
        }
        return $next($request);
    }
}
