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
            // $id = $request->id;

            if ($user->hasRole('Admin')) {
                if ($currentUrl !== url('/admin/panel') && $currentUrl !== url('/admin/users') && $currentUrl !== url("/admin/users/{$request->id}")
                && $currentUrl !== url("/admin/users/update/{$request->id}") && $currentUrl !== url('/admin/settings') && $currentUrl !== url("/admin/powers/{$request->id}")) {
                    return redirect()->route('admin.dashboard');
                }
            }

            if ($user->hasRole('Employee')) {
                if ($currentUrl !== url('/employee/panel') && $currentUrl !== url('employee/profile')) {
                    return redirect()->route('employee.dashboard');
                }
            }
        }

        return $next($request);
    }
}
