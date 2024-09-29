<h1 class="font-bold text-xl py-[1.6rem]">البيانات المالية</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">حالة الدعم</small>
        @if($project->p_support == 0)
        <div class="form-control">
            <label class="label cursor-pointer w-fit flex gap-x-4 items-center" style="direction: ltr">
                <span class="label-text">غير مدعوم</span>
                <input type="checkbox" class="checkbox" disabled />
            </label>
        </div>
        @else
        <div class="form-control">
            <label class="label cursor-pointer w-fit flex gap-x-4 items-center" style="direction: ltr">
                <span class="label-text">مدعوم</span>
                <input type="checkbox" class="checkbox" disabled checked="checked" />
            </label>
        </div>
        @endif
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">تاريخ نهاية المشروع</small>
        <input type="text" placeholder="{{ $project->p_date_end }}" class="input input-bordered" disabled />
    </div>
</div>