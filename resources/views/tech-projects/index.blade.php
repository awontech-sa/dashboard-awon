@extends('layouts.app')
@section('content')
<div class="grid font-['Tajawal'] font-bold text-xl mr-[5.6rem]">
    <section>
        <h1>{{ $project->p_name }}</h1>
        <div class="grid grid-cols-3 mt-7">
            <!-- start of project status section -->
            <div class="w-[20.2rem] h-28 bg-white border-[#ECEEF6] grid place-items-center rounded-md border-2">
                <div class="flex items-center gap-x-[7.2rem]">
                    <p class="font-bold text-base">حالة المشروع</p>
                    <img src="{{ asset("assets/icons/project_status.png") }}" class="w-5" alt="project-status" />
                </div>
                @if($project->p_status == 'معلق')
                <div class="badge badge-primary p-2 w-[16.2rem]">{{ $project->p_status }}</div>
                @elseif($project->p_status == 'قيد التنفيذ')
                <div class="badge badge-warning p-2 w-[16.2rem]">{{ $project->p_status }}</div>
                @else
                <div class="badge badge-success p-2 w-[16.2rem]">{{ $project->p_status }}</div>
                @endif
            </div>
            <!-- end of project status section -->

            <!-- start of project success section -->
            <div class="w-[20.2rem] pt-6 pr-5 h-28 bg-white border-[#ECEEF6] rounded-md border-2">
                <div>
                    <p class="font-bold text-base">نسبة إنجاز المشروع</p>
                    <small class="font-normal text-sm">المرحلة الحالية: اختبار جودة النظام</small>
                </div>
                <div class="flex items-center gap-x-2">
                    <small class="text-sm font-normal text-gray-500">7/10 إنجاز المراحل</small>
                    <progress class="progress progress-success w-44" value="70" max="100"></progress>
                </div>
            </div>
            <!-- end of project success section -->

            <!-- start of project benefit section -->
            <div class="w-[20.2rem] h-28 bg-white border-[#ECEEF6] rounded-md border-2">
                <div class="flex items-center gap-x-7 pr-4 pt-3">
                    <p class="font-bold text-base">عدد المستفيدين من الجهات</p>
                    <img src="{{ asset("assets/icons/benef_projects.png") }}" class="w-5" alt="project-status" />
                </div>
                <div class="pr-4">
                    <p class="font-bold text-3xl">{{ $project->p_num_beneficiaries }}</p>
                    <small class="text-gray-500 text-sm font-normal">جهة</small>
                </div>
            </div>
            <!-- end of project benefit section -->
        </div>
    </section>

    <section>
        <div class="flex items-center justify-around pt-16">
            <h1 class="font-bold text-xl text-center">بيانات المشروع</h1>
            <p class="font-normal text-base text-center">انقر على الرقم لعرض البيانات </p>
        </div>

        <div role="tablist" class="tabs mt-14 tabs-boxed bg-transparent">
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="01" checked="checked" />
            <div role="tabpanel" class="tab-content">
                @include('tech-projects.general-data')
            </div>
            <input
                type="radio"
                name="my_tabs_2"
                role="tab"
                class="tab"
                aria-label="02" />
            <div role="tabpanel" class="tab-content">
                @include('tech-projects.financial-data')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="03" />
            <div role="tabpanel" class="tab-content">
                @include('tech-projects.project-files')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="04" />
            <div role="tabpanel" class="tab-content">
                <!-- @include('tech-projects.project-status') -->
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="05" />
            <div role="tabpanel" class="tab-content">
                <!-- @include('tech-projects.project-level') -->
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="06" />
            <div role="tabpanel" class="tab-content">
                <!-- @include('tech-projects.project-code') -->
            </div>
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="07" />
            <div role="tabpanel" class="tab-content">
                <!-- @include('tech-projects.project-team') -->
            </div>
        </div>
    </section>
</div>
@endsection