<h1 class="font-bold text-xl py-[1.6rem]">برمجة المشروع</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">رابط الموقع</small>
        <input type="text" placeholder="{{ $project->p_web }}" class="input input-bordered" disabled />
        <small class="text-base">رابط التطبيق على andriod</small>
        <input type="text" placeholder="{{ $project->p_android }}" class="input input-bordered" disabled />
        <small class="text-base">رابط التطبيق على ios</small>
        <input type="text" placeholder="{{ $project->p_ios }}" class="input input-bordered" disabled />
    </div>
</div>