<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            /** @var \App\Models\User */
            $user = Auth::user();
            $currentUrl = $request->url();

            if ($user->hasRole('Admin') && $currentUrl !== url('/admin/panel')) {
                return redirect('/admin/panel');
            }

            if ($user->hasRole('Employee') && $currentUrl !== url('/employee/panel')) {
                return redirect('/employee/panel');
            }

        }

        return $next($request);
    }
}
