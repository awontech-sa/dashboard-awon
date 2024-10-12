<section class="mt-4">
    <h1 class="font-bold text-xl">حالة الدعم</h1>

    <div class="flex items-center justify-between pb-52">
        <!-- start of support project section -->
        <div class="grid mt-[0.82rem] gap-y-[1.13rem]">
            <small class="font-normal text-base">حالة الدعم</small>
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
        <!-- end of support project section -->

        <!-- start of support entity project section -->
        <div class="grid mt-[0.82rem] gap-y-[1.13rem]">
            <small class="font-normal text-base">الجهة الداعمة</small>
            <input type="text" placeholder="{{ $project->p_support_entity }}"
            class="input input-bordered" disabled />
        </div>
        <!-- end of support entity project section -->
    </div>
</section>