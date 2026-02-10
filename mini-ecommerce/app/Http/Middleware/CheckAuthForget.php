<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthForget
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle($request, $next)
{
    $response = $next($request);

    if (!app()->environment('local')) {
        return $response;
    }

    // 1. Ila kant l-route hiya login wla logout, n-khlliwha d-douz bla check
    if ($request->is('login', 'logout', 'register', 'password/*')) {
        return $response;
    }

    $isAdminRoute = $request->is('admin') || $request->is('admin/*');

    if ($isAdminRoute && !app()->bound('auth_checked')) {
        throw new \Exception(
            "🛑 SECURITY ALERT: Nsiti madrtich authorize() f wahed l-admin route!\n" .
            "📍 Controller: " . $request->route()->getActionName()
        );
    }

    return $response;
}
}
