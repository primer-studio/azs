<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "dashboard/pay/IPG/callback/*/*"
    ];
    
    public function handle($request, \Closure $next)
    {
        if (in_array(env('APP_ENV'), ['local', 'dev'])) {
            return $next($request);
        }
    
        return parent::handle($request, $next);
    }
    
    
}
