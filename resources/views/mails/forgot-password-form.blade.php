@php
$data = \DB::table('password_reset_tokens')->where('token', $token)->first();
$email = $data->email;
@endphp

@vite('resources/css/app.css')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

<section class="login-form" dir="rtl">
    <img src="{{ asset("assets/images/logo-2.png") }}" class="w-52 absolute top-4 right-8" alt="logo" />

    <!-- Display General Error Message as an Overlay -->
    @if (session('error_message'))
    @include('layouts.error-message')
    @endif

    <form class="bg-white w-[517px] h-[561px] font-['Tajawal'] border-[#ECEEF6] rounded-md border-2 relative z-0"
        action="{{ route('reset.password.post', ['token' => $data->token, 'email' => $email]) }}" method="POST" id="forgotpassword">
        @csrf
        
        <h1 class="text-xl text-cyan-700 font-medium mt-[5.64rem] mr-[10.1rem]">إعادة تعيين كلمة المرور</h1>

        <div class="my-4 mx-[5.6rem]">
            <label class="font-medium text-base text-gray-500">رجاءاً قم بتعبئة البيانات التالية لإعادة تعيين كلمة المرور</label>
        </div>

        <!-- New Password Field -->
        <div class="grid gap-y-5 mt-[2.3rem] mr-8">
            <label for="new_password">كلمة المرور الجديدة <span class="text-red-600">*</span></label>
            <input type="password" class="input border-gray-500 w-[453px]" name="new_password" id="new_password" required />
        </div>

        <!-- Confirm Password Field -->
        <div class="grid gap-y-5 mt-5 mr-10">
            <label for="confirm_password">تأكيد كلمة المرور الجديدة <span class="text-red-600">*</span></label>
            <input type="password" class="input border-gray-500 w-[453px]" name="new_password_confirmation" id="new_password_confirmation" required />
        </div>

        <!-- Submit Button -->
        <div class="mx-32 my-4">
            <button type="submit" class="btn btn-wide bg-cyan-700 text-white font-medium text-base">إعادة تعيين كلمة المرور</button>
        </div>
    </form>
</section>

<style>
    .login-form {
        width: 100%;
        height: 100vh;
        background-image: url('/assets/images/login-background.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }
</style>