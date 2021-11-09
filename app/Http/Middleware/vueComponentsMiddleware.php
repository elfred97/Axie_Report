<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class vueComponentsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $route         = $request->route;

        $vueComponents = [
            'home',
            'scholars',
            'import',
            'players',
            'notification',
            'settings',
            '403',
            null
            // 'patient'
        ];

        if (!in_array($route, $vueComponents))
            abort(404);

        return $next($request);
    }
}
