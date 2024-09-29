<h1 class="font-bold text-xl py-[1.6rem]">المرفقات</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        @foreach(json_decode($project->p_files) as $key => $value)
            <a class="btn btn-link" href="{{ $value }}" download="">عرض الملف</a>
        @endforeach
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">تاريخ نهاية المشروع</small>
        <input type="text" placeholder="{{ $project->p_date_end }}" class="input input-bordered" disabled />
    </div>
</div>