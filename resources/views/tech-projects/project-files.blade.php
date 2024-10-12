<section class="mt-4">
    <h1 class="font-bold text-xl">مرفقات</h1>

    <div class="grid mt-[2.9rem] gap-y-5 pb-52">
        @if($project->p_files != null)
        @foreach(json_decode($project->p_files) as $key => $value)
        @if(str_contains(basename($value->value), 'pdf'))
        <!-- start of files section -->
        <small class="font-normal text-base">ملف تعريفي</small>
        <div class="w-[52rem] h-[4.1rem] bg-white rounded flex justify-between">
            <div class="flex gap-x-5 p-4 items-center">
                <img src="{{ asset("assets/icons/pdf.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                <p class="font-normal text-base">{{ $value->name }}</p>
            </div>
            <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $value->value }}" download="">عرض الملف</a>
        </div>
        <!-- end of files section -->
        @elseif(str_contains(basename($value->value), 'mp4'))
        <!-- start of video section -->
        <small class="font-normal text-base">فيديو تعريفي</small>
        <div class="w-[52rem] h-[4.1rem] bg-white rounded flex justify-between">
            <div class="flex gap-x-5 p-4 items-center">
                <img src="{{ asset("assets/icons/video.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                <p class="font-normal text-base">{{ $value->name }}</p>
            </div>
            <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $value->value }}" download="">عرض الملف</a>
        </div>
        <!-- end of video section -->
        @endif
        @endforeach
        @endif
    </div>
</section>