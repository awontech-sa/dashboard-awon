<h1 class="font-bold text-xl mt-14">برمجة المشروع</h1>
<div class="grid grid-cols-2 gap-x-[3.3rem] mt-[0.82rem] text-base font-normal">
    <div class="grid gap-y-5">
        <label>رابط الموقع</label>
        <input class="input" readonly value="{{ $details->link ?? '' }}" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] text-base font-normal my-8">
    <div class="grid gap-y-5">
        <label>رابط التطبيق على IOS</label>
        <input class="input" readonly value="{{ $details->ios ?? '' }}" />
    </div>
    <div class="grid gap-y-5">
        <label>رابط التطبيق على Android</label>
        <input class="input" readonly value="{{ $details->android ?? '' }}" />
    </div>
</div>