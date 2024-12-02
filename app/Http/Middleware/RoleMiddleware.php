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
                url('/admin/percentage-projects'),
                url('/admin/users'),
                url("/admin/users/{$request->id}"),
                url("/admin/users/update/{$request->id}"),
                url("/admin/create-user"),
                url('/admin/settings'),
                url("/admin/powers/{$request->id}"),
                url("/admin/projects/create/{$request->step}"),
                url("/admin/projects/update/{$request->step}/{$request->id}"),
                url("/admin/project/{$request->id}")
            ];

            if (!in_array($currentUrl, $adminUrls)) {
                return redirect()->route('admin.dashboard');
            }
        }

        // Employee Role Handling
        if ($user->hasRole('Employee')) {
            $employeeUrls = [
                url('/employee/panel'),
                url('/employee/projects-percentage'),
                url('/employee/settings'),
                url('/employee/profile'),
                url('/employee/users'),
                url("/employee/users/{$request->id}"),
                url("/employee/users/update/{$request->id}"),
                url("/employee/projects/create/{$request->step}"),
                url("/employee/projects/update/{$request->step}/{$request->id}"),
                url("/employee/project/{$request->id}"),
            ];

            if (!in_array($currentUrl, $employeeUrls)) {
                return redirect()->route('employee.dashboard');
            }
        }

        // Allow request to proceed if all checks pass
        return $next($request);
    }
}
