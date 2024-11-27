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

use function PHPUnit\Framework\isEmpty;

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

        if (!$user) {
            return back()->with('error_message', 'البريد الإلكتروني غير مسجل');
        } else {
            $this->sendOtp($user);  // Send OTP
            return view('auth.verification', ['email' => $user->email, 'user' => $user]);
        }
    }

    // Function to send OTP email
    public function sendOtp(User $user)
    {
        $otp = rand(1000, 9999);
        $time = Carbon::now();

        EmailVerification::updateOrCreate(
            ['email' => $user->email],
            ['email' => $user->email, 'otp' => $otp, 'created_at' => $time->toDateTimeString()]
        );

        $data['email'] = $user->email;
        $data['title'] = 'Mail Verification';
        $data['body'] = 'Your OTP is: ' . $otp;

        Mail::send('mails.send-forgot-password-mail', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });

        return view('auth.verification', ['email' => $user->email, 'user' => $user]);
    }

    // Verify the OTP entered by the user
    public function verifyOtp(Request $request)
    {
        $otp = $request->otp4 . $request->otp3 . $request->otp2 . $request->otp1;
        $user = User::where('email', $request->email)->first();
        $otpData = EmailVerification::where('otp', $otp)->first();

        if ($otp == '') {
            return view('auth.verification')->with('email', $user->email)->with('user', $user)->with('errorMsg', 'الرجاء إدخال رمز التحقق');
        }

        if (!$otpData) {
            return view('auth.verification')->with('email', $user->email)->with('user', $user)->with('errorMsg', 'الرمز المدخل غير صحيح');
        }

        $is_verified = User::where('id', $user->id)->first();

        if ($is_verified->is_verified === 0) {
            User::where('id', $user->id)->update(['is_verified' => 1]);
        }

        $token = Str::random(64);
        $emailExist = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if (!$emailExist) {
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        } else {
            DB::table('password_reset_tokens')->update([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        }

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

        if ($request->new_password != $request->new_password_confirmation) {
            return back()->with('error_message', 'كلمات المرور المدخلة غير متطابقة');
        }

        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $request->new_password)) {

            User::where('email', $request->email)->update(['password' => bcrypt($request->new_password)]);

            DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            return redirect('/login')->with('register_success', 'Your password has been changed!');
        } else {
            return back()->with('error_message', 'يجب أن تكون كلمة المرور على الأقل ٨ أحرف، حرف كبير، حرف صغير، علامة مميزة');
        }
    }
}
