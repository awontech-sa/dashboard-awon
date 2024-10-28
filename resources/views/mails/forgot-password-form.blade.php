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
    <form class="bg-white w-[517px] h-[561px] font-['Tajawal'] border-[#ECEEF6] rounded-md border-2" action="{{ route('reset.password.post') }}" method="POST" id="forgotpassword">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <h1 class="text-xl text-cyan-700 font-medium mt-[5.64rem] mr-[10.1rem]">إعادة تعيين كلمة المرور</h1>
        <div class="my-4 mx-[5.6rem]">
            <label class="font-medium text-base text-gray-500">رجاءاً قم بتعبئة البيانات التالية لإعادة تعيين كلمة المرور</label>
        </div>

        <div class="grid gap-y-5 mt-[2.3rem] mr-8">
            <label for="password">كلمة المرور الجديدة *</label>
            <input type="password" class="input border-gray-500 w-[453px]" name="new_password" id="new_password" required />
        </div>

        <div class="grid gap-y-5 mt-5 mr-10">
            <label for="password">تأكيد كلمة المرور الجديدة *</label>
            <input type="password" class="input border-gray-500 w-[453px]" name="confirm_password" id="confirm_password" required />
        </div>

        <div class="mx-32 my-4">
            <button class="btn btn-wide bg-cyan-700 text-white font-medium text-base">إعادة تعيين كلمة المرور</button>
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
    }
</style>