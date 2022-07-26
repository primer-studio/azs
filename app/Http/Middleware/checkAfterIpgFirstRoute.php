<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class checkAfterIpgFirstRoute
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check for redirected_to_ipg
        $redirected_to_ipg = session()->pull('redirected_to_ipg');
        if (!empty($redirected_to_ipg)) {
            $current_route = $request->getRequestUri();
            Log::info("first route after redirected_to_ipg for $redirected_to_ipg is $current_route");
        }
        return $next($request);
    }
}
