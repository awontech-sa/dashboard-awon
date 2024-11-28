<h1 class="font-bold text-xl py-14">برمجة المشروع</h1>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8 text-base font-normal">
    <div class="grid gap-y-5">
        <label>رابط الموقع</label>
        <a class="link" href="{{ $details->link ?? '' }}">رابط الموقع</a>
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] text-base font-normal">
    <div class="grid gap-y-5">
        <label>رابط التطبيق على IOS</label>
        <a class="link" href="{{ $details->ios ?? '' }}">رابط التطبيق</a>
    </div>
    <div class="grid gap-y-5">
        <label>رابط التطبيق على Android</label>
        <a class="link" href="{{ $details->android ?? '' }}">رابط التطبيق</a>
    </div>
</div>