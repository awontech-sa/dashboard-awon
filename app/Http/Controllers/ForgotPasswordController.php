<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\EmailVerification;

class ForgotPasswordController extends Controller
{
    // Show the forgot password form
    public function index()
    {
        return view('auth.forgot-password');
    }

    // Send OTP to the user's email for verification
    public function verification(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->is_verified == 1) {
            return view('auth.login');
        }

        $this->sendOtp($user);  // Send OTP
        return view('auth.verification', ['email' => $user->email]);
    }

    // Function to send OTP email
    private function sendOtp($user)
    {
        $otp = rand(1000, 9999);
        $time = Carbon::now();

        EmailVerification::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'otp' => $otp,
                'created_at' => $time->toDateTimeString(),
            ]
        );

        $data['email'] = $user->email;
        $data['title'] = 'Mail Verification';
        $data['body'] = 'Your OTP is: ' . $otp;

        Mail::send('mails.send-forgot-password-mail', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });
    }

    // Verify the OTP entered by the user
    public function verifyOtp(Request $request)
    {
        $otp = $request->otp4 . $request->otp3 . $request->otp2 . $request->otp1;
        $user = User::where('email', $request->email)->first();
        $otpData = EmailVerification::where('otp', $otp)->first();

        if (!$otpData) {
            return response()->json(['success' => false, 'msg' => 'You entered the wrong OTP']);
        }

        User::where('id', $user->id)->update(['is_verified' => 1]);

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('reset.password.form', ['token' => $token, 'email' => $request->email]);
    }

    public function showResetPasswordForm(string $token, string $email)
    {
        return view('mails.forgot-password-form', ['token' => $token, 'email' => $email]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $updatePassword = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
        ]);

        if (!$updatePassword) {
            return back()->withInput()->with('error_message', 'Invalid token!');
        }

        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $request->new_password)) {

            User::where('email', $request->email)->update(['password' => Hash::make($request->new_password)]);

            DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            return redirect('/login');
        } else {
            return back()->withInput()->with('error_message', 'حدث خطأ!');
        }
    }
}
