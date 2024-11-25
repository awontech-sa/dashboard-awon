<section class="mt-14">
    <h1 class="text-xl font-bold">بيانات عامة</h1>

    <div class="w-[55.3rem] mt-6">
        <!-- start name of project -->
        <div class="grid gap-y-5">
            <p class="font-normal text-base">اسم المشروع</p>
            <input type="text" placeholder="{{ $project->p_name }}" class="input input-bordered" disabled />
        </div>
        <!-- end name of project -->

        <!-- start of date of the project section -->
        <div class="flex items-center mt-8 gap-x-14">
            <div class="grid gap-y-5 w-1/2">
                <p class="font-normal text-base">تاريخ بداية المشروع</p>
                <input type="text" placeholder="{{ $project->p_date_start }}" class="input input-bordered" disabled />
            </div>
            <div class="grid gap-y-5 w-1/2">
                <p class="font-normal text-base">تاريخ نهاية المشروع</p>
                <input type="text" placeholder="{{ $project->p_date_end }}" class="input input-bordered" disabled />
            </div>
        </div>
        <!-- end of date of the project section -->

        <!-- start of remaining of the project section -->
        <div class="flex items-center mt-8 gap-x-14">
            <div class="grid gap-y-5 w-1/2">
                <p class="font-normal text-base">مدة المشروع</p>
                <input type="text" placeholder="{{ $project->p_duration }}" class="input input-bordered" disabled />
            </div>
            <div class="grid gap-y-5 w-1/2">
                <p class="font-normal text-base">المدة المتبقية</p>
                <input type="text" placeholder="{{ $project->p_remaining }}" class="input input-bordered" disabled />
            </div>
        </div>
        <!-- end of remaining of the project section -->

        <!-- start description of the project -->
        <div class="grid gap-y-5 mt-8">
            <p class="font-normal text-base">نبذه عن المشروع</p>
            <textarea class="textarea" placeholder="{{ $project->p_description }}" disabled></textarea>
        </div>
        <!-- end description of the project -->

        <!-- start of remaining of the project section -->
        <div class="flex items-center mt-8 pb-52 gap-x-14">
            <div class="grid gap-y-5 w-1/2">
                <p class="font-normal text-base">نوع المستفيدين من المشروع</p>
                <select name="" id="" disabled="disabled" class="select">
                    <option value="">{{ $project->type_benef }}</option>
                </select>
            </div>
            <div class="grid gap-y-5 w-1/2">
                <p class="font-normal text-base">عدد المستفيدين</p>
                <input type="text" placeholder="{{ $project->p_num_beneficiaries }}" class="input input-bordered" disabled />
            </div>
        </div>
        <!-- end of remaining of the project section -->
    </div>
</section>