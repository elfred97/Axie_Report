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
            'game_logs',
            'players',
            'scholarList',
            'notification',
            'payroll_history',
            'settings',
            '403',
            null,
            'api_sample',
            'audit',
            
            'scholars',
            // 'scholar_home',
            'scholar_account',
            'scholar_payroll',
            'scholar_notification',
            'scholar_announcement',
        ];

        if (!in_array($route, $vueComponents))
            abort(404);

        return $next($request);
    }
}
