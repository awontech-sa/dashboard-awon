@vite('resources/css/app.css')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

<section class="login-form" dir="rtl">
    <img src="{{ asset("assets/images/logo-2.png") }}" class="w-52 absolute top-4 right-8" alt="logo" />
    <form class="bg-white w-[517px] h-[561px] font-['Tajawal'] border-[#ECEEF6] rounded-md border-2" action="{{ route('verification') }}" method="POST" id="forgot">
        @csrf
        <h1 class="text-[32px] text-cyan-700 font-medium mt-[5.64rem] mr-[7.58rem]">استعادة كلمة المرور</h1>
        <div class="grid gap-y-5 mt-[4.6rem] mr-10">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" class="input border-gray-500 w-[453px]" placeholder="email@email.com" name="email" id="email" />
        </div>
        
        <div class="grid place-items-center my-[6.2rem] gap-y-3">
            <button class="btn btn-wide bg-cyan-700 text-white font-medium text-base">إرسال رمز التحقق</button>
            <a href="{{ route('auth.login') }}" class="text-cyan-700 font-medium text-base">تسجيل الدخول</a>
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