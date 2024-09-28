<h1 class="font-bold text-xl py-[1.6rem]">بيانات عامة</h1>
<div class="grid gap-y-5">
    <small class="text-base">اسم المشروع</small>
    <input type="text" placeholder="{{ $project->p_name }}" class="input input-bordered" disabled />
</div>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">تاريخ بداية المشروع</small>
        <input type="text" placeholder="{{ $project->p_date_start }}" class="input input-bordered" disabled />
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">تاريخ نهاية المشروع</small>
        <input type="text" placeholder="{{ $project->p_date_end }}" class="input input-bordered" disabled />
    </div>
</div>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">مدة المشروع</small>
        <input type="text" placeholder="{{ $project->p_date_start }}" class="input input-bordered" disabled />
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">المدة المتبقية</small>
        <input type="text" placeholder="{{ $project->p_remaining }}" class="input input-bordered" disabled />
    </div>
</div>
<div class="grid gap-y-5 mt-8">
    <small class="text-base">نبذة عن المشروع</small>
    <input type="text" placeholder="{{ $project->p_description }}" class="input input-bordered" disabled />
</div>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">نوع المستفيدين من المشروع</small>
        <input type="text" placeholder="{{ $project->p_type_beneficiaries }}" class="input input-bordered" disabled />
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">عدد المستفيدين</small>
        <input type="text" placeholder="{{ $project->p_num_beneficiaries }}" class="input input-bordered" disabled />
    </div>
</div>