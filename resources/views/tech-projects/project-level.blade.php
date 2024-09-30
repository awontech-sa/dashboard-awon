<h1 class="font-bold text-xl py-[1.6rem]">مرحلة المشروع</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        @foreach(json_decode($project->p_level) as $key => $value)
            @if($value == 'دراسة المشروع')
            <div class="w-[52rem] h-[4.1rem] rounded bg-[#6AADC5] flex justify-between">
                <p class="p-4 font-bold text-white text-base">{{ $value }}</p>
                <input type="checkbox" class="checkbox m-6 bg-white" disabled checked="checked" />
            </div>
            @else
            <div class="w-[52rem] h-[4.1rem] rounded bg-white flex justify-between">
                <p class="p-4 font-bold text-[#6AADC5] text-base">دراسة المشروع</p>
                <input type="checkbox" class="checkbox m-6 bg-white" disabled />
            </div>
            @endif

            @if($value == 'تصميم تجربة واجهات المستخدم')
            <div class="w-[52rem] h-[4.1rem] rounded bg-[#6AADC5] flex justify-between">
                <p class="p-4 font-bold text-white text-base">{{ $value }}</p>
                <input type="checkbox" class="checkbox m-6 bg-white" disabled checked="checked" />
            </div>
            @else
            <div class="w-[52rem] h-[4.1rem] rounded bg-white flex justify-between">
                <p class="p-4 font-bold text-[#6AADC5] text-base">تصميم تجربة واجهات المستخدم</p>
                <input type="checkbox" class="checkbox m-6 bg-white" disabled />
            </div>
            @endif

            @if($value == 'البرمجة')
            <div class="w-[52rem] h-[4.1rem] rounded bg-[#6AADC5] flex justify-between">
                <p class="p-4 font-bold text-white text-base">{{ $value }}</p>
                <input type="checkbox" class="checkbox m-6 bg-white" disabled checked="checked" />
            </div>
            @else
            <div class="w-[52rem] h-[4.1rem] rounded bg-white flex justify-between">
                <p class="p-4 font-bold text-[#6AADC5] text-base">البرمجة</p>
                <input type="checkbox" class="checkbox m-6 bg-white" disabled />
            </div>
            @endif
        @endforeach
    </div>
</div>