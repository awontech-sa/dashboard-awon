<!-- <h1 class="font-bold text-xl py-[1.6rem]">فريق العمل</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">مدير المشروع</small>
        <input type="text" placeholder="{{ $project->p_date_start }}" class="input input-bordered" disabled />
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">نائب مدير المشروع</small>
        <input type="text" placeholder="{{ $project->p_date_end }}" class="input input-bordered" disabled />
    </div>
</div>
<h1 class="text-base pt-16">فريق العمل</h1>
<div class="grid grid-cols-2 mt-8 gap-x-14">
    <div class="grid gap-y-5">
        <small class="text-base">اسم العضو</small>
        <input type="text" placeholder="{{ $project->p_date_start }}" class="input input-bordered" disabled />
    </div>
    <div class="grid gap-y-5">
        <small class="text-base">الدور</small>
        <input type="text" placeholder="{{ $project->p_remaining }}" class="input input-bordered" disabled />
    </div>
</div> -->

<section class="mt-4">
    <h1 class="font-bold text-xl">فريق العمل</h1>

    <!-- start manager of project section -->
    <div class="flex items-center justify-between">
        @foreach($team as $member)
        <div class="grid gap-y-5">
            <p>مدير المشروع</p>
            <input type="text" placeholder="{{ $member->role_id }}" class="input">
        </div>
        @endforeach
    </div>
    <!-- end manager of project section -->
</section>