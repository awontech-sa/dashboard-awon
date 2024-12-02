<h1 class="font-bold text-xl mt-14">برمجة المشروع</h1>
<div class="grid grid-cols-2 gap-x-[3.3rem] text-base font-normal mt-[0.82rem]">
    <div class="grid gap-y-5">
        <label>لغة البرمجة</label>
        <input class="input text-center text-base" disabled type="text" placeholder="{{ $details->program_language ?? '' }}" />
    </div>
    <div class="grid gap-y-5">
        <label>إطار البرمجة</label>
        <input disabled class="input text-center text-base" placeholder="{{ $details->framework ?? '' }}" type="text" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8 text-base font-normal">
    <div class="grid gap-y-5">
        <label for="github">رابط GitHub</label>
        <input class="input" readonly value="{{ $details->github ?? '' }}" />
    </div>
    <div class="grid gap-y-5">
        <label>رابط الموقع</label>
        <input class="input" readonly value="{{ $details->link ?? '' }}" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] text-base font-normal">
    <div class="grid gap-y-5">
        <label>رابط التطبيق على IOS</label>
        <input class="input" readonly value="{{ $details->ios ?? '' }}" />
    </div>
    <div class="grid gap-y-5">
        <label>رابط التطبيق على Android</label>
        <input class="input" readonly value="{{ $details->android ?? '' }}" />
    </div>
</div>

<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="dashboard">رابط لوحة التحكم</label>
    <input class="input" readonly value="{{ $details->dashboard ?? '' }}" />
</div>