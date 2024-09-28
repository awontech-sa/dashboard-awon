@extends('layouts.app')
@section('content')
<main class="font-['Tajawal'] w-[1071px] px-16 h-full
    2xl:w-auto">
    <h1 class="font-bold text-xl py-[1.6rem]">{{ $project->p_name }}</h1>
    <section class="grid grid-cols-3 gap-x-12">
        <div class="w-[20.2rem] h-28 bg-white border-2 border-[#ECEEF6] rounded-md
            2xl:w-auto">
            <div class="flex justify-between pt-6 pr-5 pl-4
                2xl:justify-between 2xl:pl-10 2xl:pr-6">
                <p class="font-bold text-base">حالة المشروع</p>
                <x-far-check-circle class="text-gray-500 w-6 h-6" />
            </div>
            <div class="px-4 py-6">
                @if($project->p_status === 'معلق' || $project->p_status === 'قيد التنفيذ')
                <progress class="progress w-[18rem] h-6 progress-warning" value="50" max="100"></progress>
                @else
                <progress class="progress w-[18rem] h-6 progress-success" value="100" max="100"></progress>
                @endif
            </div>
        </div>

        <div class="w-[20.2rem] h-28 bg-white border-2 border-[#ECEEF6] rounded-md
            2xl:w-auto">
            <div class="pt-6 pr-5 pl-4">
                <p class="font-bold text-base">نسبة إنجاز المشروع</p>
                <small>المرحلة الحالية: اختبار جودة النظام</small>
            </div>
            <div class="flex items-center gap-x-2 pr-5 pt-1">
                <small class="text-sm text-gray-500">7/10 إنجاز المراحل</small>
                <progress class="progress w-[11.5rem] h-6 progress-success" value="70" max="100"></progress>
            </div>
        </div>

        <div class="w-[20.2rem] h-28 bg-white border-2 border-[#ECEEF6] rounded-md
            2xl:w-auto">
            <div class="flex justify-between pt-6 pr-5 pl-4
                2xl:justify-between 2xl:pl-10 2xl:pr-6">
                <p class="font-bold text-base">عدد المستفيدين من الجهات</p>
                <x-far-building class="text-gray-500 w-6 h-6" />
            </div>
            <div class="px-7">
                <h1 class="font-bold text-3xl">{{ $project->num_beneficiaries }}</h1>
                <small class="text-sm font-normal">جهة</small>
            </div>
        </div>
    </section>

    <section>
        <h1 class="font-bold text-xl pt-[1.6rem]">بيانات المشروع</h1>
        <div role="tablist" class="tabs tabs-boxed bg-transparent">
            <input type="radio" name="my_tabs_2" role="tab" class="tab 
            checked:rounded-full" aria-label="01" checked="checked"  />
            <div role="tabpanel" class="tab-content p-6">
                @include('tech-projects.general-data')
            </div>

            <input
                type="radio"
                name="my_tabs_2"
                role="tab"
                class="tab checked:rounded-full"
                aria-label="02" />
            <div role="tabpanel" class="tab-content p-6">
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
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab checked:rounded-full" aria-label="Tab 3" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                Tab content 3
            </div>
        </div>
    </section>
</main>
@endsection

<script>
    function toggleDiv(section) {
        // Hide both sections initially
        document.getElementById('general-section').classList.add('hidden');
        document.getElementById('financial-section').classList.add('hidden');

        // Show the selected section
        if (section === 'general') {
            document.getElementById('general-section').classList.remove('hidden');
        } else if (section === 'financial') {
            document.getElementById('financial-section').classList.remove('hidden');
        }
    }
</script>