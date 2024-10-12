<section class="mt-4">
    <h1 class="font-bold text-xl">حالة المشروع</h1>

    <div class="flex items-center justify-between pb-52">
        <!-- start of support project section -->
        <div class="grid mt-[0.82rem] gap-y-[1.13rem]">
            <small class="font-normal text-base">حالة المشروع</small>
            <input type="text" placeholder="{{ $project->p_status }}"
                class="input input-bordered" disabled />
        </div>
        <!-- end of support project section -->

        <!-- start of support entity project section -->
        <div class="grid mt-[0.82rem] gap-y-[1.13rem]">
            <small class="font-normal text-base">ملاحظات</small>
            <textarea class="textarea" placeholder="{{ $project->p_comment }}"
            name="{{ $project->id }}" id="{{ $project->id }}" disabled></textarea>
        </div>
        <!-- end of support entity project section -->
    </div>
</section>