<h1 class="font-bold text-xl py-[1.6rem]">حالة المشروع</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">حالة المشروع</small>
        <input type="text" placeholder="{{ $project->p_status }}" class="input input-bordered" disabled />
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">ملاحظات</small>
        <input type="text" placeholder="{{ $project->p_comment }}" class="input input-bordered" disabled />
    </div>
</div>