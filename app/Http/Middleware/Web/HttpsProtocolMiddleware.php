<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Support\Facades\App;

class HttpsProtocolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && app()->environment('prod')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
