<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is not authenticated, redirect to the login page
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User */
        $user = Auth::user();
        $currentUrl = $request->url();

        // Admin Role Handling
        if ($user->hasRole('Admin')) {
            $adminUrls = [
                url('/admin/panel'),
                url('/admin/users'),
                url("/admin/users/{$request->id}"),
                url("/admin/users/update/{$request->id}"),
                url("/admin/create-user"),
                url('/admin/settings'),
                url("/admin/powers/{$request->id}"),
                url("/admin/projects/create/{$request->step}")
            ];

            if (!in_array($currentUrl, $adminUrls)) {
                return redirect()->route('admin.dashboard');
            }
        }

        // Employee Role Handling
        if ($user->hasRole('Employee')) {
            $employeeUrls = [
                url('/employee/panel'),
                url('/employee/settings'),
                url('/employee/users'),
            ];

            if (!in_array($currentUrl, $employeeUrls)) {
                return redirect()->route('employee.dashboard');
            }
        }

        // Allow request to proceed if all checks pass
        return $next($request);
    }
}
