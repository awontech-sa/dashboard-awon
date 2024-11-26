@extends('layouts.admin-sidebar')
@section('admin-content')
<div class="grid font-['Tajawal'] font-bold text-xl mx-[6.4rem]">
    <section>
        <h1>{{ $project->p_name }}</h1>
        <div class="grid grid-cols-2 gap-x-10 gap-y-8 w-fit mt-7">
            <!-- start of project status section -->
            <div class="w-[20.2rem] h-28 bg-white border-[#ECEEF6] grid place-items-center rounded-md border-2">
                <div class="flex items-center gap-x-[7.2rem]">
                    <p class="font-bold text-base">حالة المشروع</p>
                    <img src="{{ asset("assets/icons/project_status.png") }}" class="w-5" alt="project-status" />
                </div>
                @if($project->project_status == 'معلق')
                <div class="badge badge-primary p-2 w-[16.2rem]">{{ $project->project_status }}</div>
                @elseif($project->project_status == 'قيد التنفيذ')
                <div class="badge badge-warning p-2 w-[16.2rem]">{{ $project->project_status }}</div>
                @elseif($project->project_status == 'مكتمل')
                <div class="badge badge-success p-2 w-[16.2rem]">{{ $project->project_status }}</div>
                @else
                <div class="badge badge-ghost p-2 w-[16.2rem]">{{ $project->project_status }}</div>
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
                    <small class="text-sm font-normal text-gray-500">{{ count($stages) }}/5 إنجاز المراحل</small>
                    <progress class="progress progress-success w-44" value="{{ count($stages) }}" max="5"></progress>
                </div>
            </div>
            <!-- end of project success section -->

            <!-- start of project success section -->
            <div class="w-[20.2rem] h-28 bg-white border-[#ECEEF6] rounded-md border-2">
                <div class="flex items-center gap-x-7 pr-4 pt-3">
                    <p class="font-bold text-base">تكلفة المشروع</p>
                    {{-- <img src="{{ asset("assets/icons/benef_projects.png") }}" class="w-5" alt="project-status" /> --}}
                </div>
                <div class="pr-4 py-4">
                    <p class="font-bold text-3xl">{{ ($project->total_cost === '0.00') ? 'مجانًا' : $project->total_cost }}</p>
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
                @include('admin.projects.project.general-data')
            </div>
            <input
                type="radio"
                name="my_tabs_2"
                role="tab"
                class="tab"
                aria-label="02" />
            <div role="tabpanel" class="tab-content">
                @include('admin.projects.project.financial.index')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="03" />
            <div role="tabpanel" class="tab-content">
                @include('admin.projects.project.project-files')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="04" />
            <div role="tabpanel" class="tab-content">
                @include('admin.projects.project.project-status')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="05" />
            <div role="tabpanel" class="tab-content">
                @include('admin.projects.project.project-level')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="06" />
            <div role="tabpanel" class="tab-content">
                @include('admin.projects.project.project-code')
            </div>
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="07" />
            <div role="tabpanel" class="tab-content">
                @include('admin.projects.project.project-team')
            </div>
        </div>
    </section>
</div>
@endsection