<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function Index()
    {
        return view('auth.forgot-password');
    }

    public function submitForgotPasswordForm(Request $request)
    {

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('mails.send-forgot-password-mail', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        Session::flash('link_success', ' Reset Link Send Successfully!');

        return redirect()->back();
    }

    public function showResetPasswordForm($token)
    {
        return view('mails.forgot-password-form', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $updatePassword = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token
        ]);

        if (! $updatePassword) {
            return back()->withInput()->with('error_message', 'Invalid token!');
        }

        User::query()->where('email', $request->email)->update(['password' => Hash::make($request->new_password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        User::query()->where('email', $request->email)->first();

        return redirect('/')->with('register_success', 'Your password has been changed!');
    }
}
