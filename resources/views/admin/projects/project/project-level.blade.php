<section class="mt-14">
    <h1 class="font-bold text-xl">مراحل المشروع</h1>

    <div class="grid gap-y-5 w-auto my-4">
        @foreach($stages as $stage)
        @php
        $isDone = $doneStages->contains('stage_name', $stage['stage_name']);
        @endphp
        <div class="w-full h-[4.1rem] rounded flex justify-between {{ $isDone ? 'bg-[#6AADC5]' : 'bg-white' }}">
            <p class="p-4 font-bold text-base {{ $isDone ? 'text-white' : 'text-[#6AADC5]' }}">
                {{ $stage['stage_name'] }}
            </p>
            <input
                type="checkbox"
                class="checkbox m-6"
                disabled
                {{ $isDone ? 'checked' : '' }} />
        </div>
        @endforeach
    </div>

</section>