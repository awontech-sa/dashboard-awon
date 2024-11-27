@vite('resources/css/app.css')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

<section class="login-form" dir="rtl">
    <img src="{{ asset("assets/images/logo-2.png") }}" class="w-52 absolute top-4 right-8" alt="logo" />
    <div class="bg-white w-[517px] h-[561px] font-['Tajawal'] border-[#ECEEF6] rounded-md border-2">
        <form action="{{ route('otp.verify') }}" method="POST" id="verified">
            @csrf
            <h1 class="text-xl text-cyan-700 font-medium mt-[5.64rem] mr-24">
                تم إرسال رمز التحقق إلى البريد الإلكتروني
            </h1>
            <small class="font-medium text-gray-400 text-base mx-[12.7rem] my-7">{{ $email }}</small>
            <input type="hidden" name="email" value="{{ $email }}" />

            <div class="grid place-items-center">
                <div class="flex gap-x-7 justify-center">
                    <div class="w-14 h-14 bg-white rounded-md border border-gray-500">
                        <input type="number" name="otp1" class="text-center w-14 h-14" min="0" />
                    </div>
                    <div class="w-14 h-14 bg-white rounded-md border border-gray-500">
                        <input type="number" name="otp2" class="text-center w-14 h-14" min="0" />
                    </div>
                    <div class="w-14 h-14 bg-white rounded-md border border-gray-500">
                        <input type="number" name="otp3" class="text-center w-14 h-14" min="0" />
                    </div>
                    <div class="w-14 h-14 bg-white rounded-md border border-gray-500">
                        <input type="number" name="otp4" class="text-center w-14 h-14" min="0" />
                    </div>
                </div>
                @if(!empty($errorMsg))
                <label class="text-error my-4">{{ $errorMsg }}</label>
                @endif
            </div>

            <div class="grid place-items-center my-[6.2rem]">
                <button type="submit" class="btn btn-wide bg-cyan-700 text-white font-medium text-base">
                    تأكيد التحقق
                </button>
            </div>
        </form>

        <form action="{{ route('resend.otp', ['user' => $user->id]) }}" class="flex justify-center" method="POST">
            @csrf
            <button type="submit" class="text-gray-500">إعادة إرسال الرمز</button>
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