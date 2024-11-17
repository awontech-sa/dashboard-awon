@vite('resources/css/app.css')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

@if(session('error_message'))
@include('layouts.error-message')
@endif
<section class="login-form">
    <div class="grid place-items-center">
        <img src="{{ asset("assets/images/logo-2.png") }}" alt="logo" class="w-96" />

        <form method="POST" action="{{ route('auth.login') }}" dir="rtl">
            @csrf
            <div>
                <input class="input w-[300px] text-white border-white bg-transparent font-['Tajawal']" id="email" placeholder="الإيميل" type="email" name="email" required>
            </div>

            <div class="mt-5">
                <input class="input w-[300px] text-white border-white bg-transparent font-['Tajawal']" placeholder="كلمة المرور" id="password" type="password" name="password" required>
            </div>

            <div class="grid place-items-start gap-y-3">
                <button class="btn btn-wide mt-11 mr-4 font-['Tajawal'] font-medium text-base text-cyan-900" type="submit">تسجيل الدخول</button>
                <a href="{{ route('forgot.password') }}" class="font-medium mr-4 text-base text-white font-['Tajawal']">نسيت كلمة المرور؟</a>
            </div>
        </form>
    </div>
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