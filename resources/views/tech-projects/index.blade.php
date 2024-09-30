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
                @include('tech-projects.financial-data')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab checked:rounded-full" aria-label="03" />
            <div role="tabpanel" class="tab-content p-6">
                @include('tech-projects.project-files')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab checked:rounded-full" aria-label="04" />
            <div role="tabpanel" class="tab-content p-6">
                @include('tech-projects.project-status')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab checked:rounded-full" aria-label="05" />
            <div role="tabpanel" class="tab-content p-6">
                @include('tech-projects.project-level')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab checked:rounded-full" aria-label="06" />
            <div role="tabpanel" class="tab-content p-6">
                @include('tech-projects.project-code')
            </div>
            <input type="radio" name="my_tabs_2" role="tab" class="tab checked:rounded-full" aria-label="07" />
            <div role="tabpanel" class="tab-content p-6">
                @include('tech-projects.project-team')
            </div>

        </div>
    </section>
</main>
@endsection