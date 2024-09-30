<h1 class="font-bold text-xl py-[1.6rem]">المرفقات</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        @foreach(json_decode($project->p_files) as $key => $value)
            <div class="w-[52rem] h-[4.1rem] rounded bg-white flex justify-between">
                <p class="p-4">{{ basename($value) }}</p>
                <a class="btn btn-md bg-sky-200 text-sky-600 border-sky-600 m-2" href="{{ $value }}" download="">لعرض الملف</a>
            </div>
        @endforeach
    </div>
</div>