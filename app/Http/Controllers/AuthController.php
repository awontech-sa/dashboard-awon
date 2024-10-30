<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // User authenticated successfully
        $token = $user->createToken('token-name')->plainTextToken;
        session(['token' => $token]);
        session(['role' => $user->getRoleNames()->first()]);
        Auth::login($user);

        // Use middleware to handle role-based redirection
        return app(RoleMiddleware::class)->handle($request, function () {
            return view('dashboard.index'); // Default route if no redirection happens in middleware
        });
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
