<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Requests\LoginRequest;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        session(['token' => $token]);

        session(['role' => $user->getRoleNames()->first()]);

        Auth::login($user);

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
