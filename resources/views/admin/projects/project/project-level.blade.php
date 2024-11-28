<section class="mt-14">
    <h1 class="font-bold text-xl">مراحل المشروع</h1>

    <div class="grid gap-y-5 w-auto my-4">
        @foreach($stages as $stage)
        <div class="w-full h-[4.1rem] rounded bg-[#6AADC5] flex justify-between">
            <p class="p-4 font-bold text-white text-base">{{ $stage->stage_name ?? '' }}</p>
            <input type="checkbox" class="checkbox m-6 bg-white" disabled checked="checked" />
        </div>
        @endforeach
    </div>
</section>