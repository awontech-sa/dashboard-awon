<h1 class="font-bold text-xl py-14">برمجة المشروع</h1>
<div class="grid grid-cols-2 gap-x-[3.3rem] text-base font-normal">
    <div class="grid gap-y-5">
        <label>لغة البرمجة</label>
        {{-- <input class="input text-center text-base" disabled type="text" placeholder="{{ $details->program_language }}" /> --}}
    </div>
    <div class="grid gap-y-5">
        <label>إطار البرمجة</label>
        <input disabled class="input text-center text-base" placeholder="{{ $details->framework }}" type="text" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8 text-base font-normal">
    <div class="grid gap-y-5">
        <label for="github">رابط GitHub</label>
        <a class="link" href="{{ $details->github }}">رابط GiHub</a>
    </div>
    <div class="grid gap-y-5">
        <label>رابط الموقع</label>
        <a class="link" href="{{ $details->link }}">رابط الموقع</a>
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] text-base font-normal">
    <div class="grid gap-y-5">
        <label>رابط التطبيق على IOS</label>
        <a class="link" href="{{ $details->ios }}">رابط التطبيق</a>
    </div>
    <div class="grid gap-y-5">
        <label>رابط التطبيق على Android</label>
        <a class="link" href="{{ $details->android }}">رابط التطبيق</a>
    </div>
</div>

<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="dashboard">رابط لوحة التحكم</label>
    <a class="link" href="{{ $details->dashboard }}">رابط لوحة التحكم</a>
</div>