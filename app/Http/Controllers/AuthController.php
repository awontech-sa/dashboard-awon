<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Requests\LoginRequest;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error_message', 'البريد الإلكتروني غير مسجل بالنظام');
        }

        if (! Hash::check($request->password, $user->password) || $request->email !== $user->email) {
            return back()->with('error_message', 'كلمة المرور أو البريد الإلكتروني المدخل غير صحيح');
        }

        $token = $user->createToken('token-name')->plainTextToken;
        session(['token' => $token]);
        session(['role' => $user->getRoleNames()->first()]);
        Auth::login($user);

        return app(RoleMiddleware::class)->handle($request, function () {
            return view('dashboard.index');
        });
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
