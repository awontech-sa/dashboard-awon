<h1 class="font-bold text-xl py-14">مراحل المشروع</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        @foreach($stages as $stage)
        <div class="w-[52rem] h-[4.1rem] rounded bg-[#6AADC5] flex justify-between">
            <p class="p-4 font-bold text-white text-base">{{ $stage->stage_name }}</p>
            <input type="checkbox" class="checkbox m-6 bg-white" disabled checked="checked" />
        </div>
        @endforeach
    </div>
</div>