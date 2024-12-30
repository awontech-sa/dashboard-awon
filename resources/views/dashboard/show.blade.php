@extends('layouts.app')
@section('content')
<div class="grid font-['Tajawal'] font-bold text-xl w-auto">
    <section>
        <div class="grid gap-y-8 my-7 w-fit gap-x-4 mr-4
        desktop:grid-cols-4 desktop:mx-auto
        laptop:grid-cols-2 laptop:mx-auto">
            <!-- start of project status section -->
            <div class="w-auto h-auto bg-white border-[#ECEEF6] grid place-items-center gap-y-8 rounded-md border-2 py-4">
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
            <div class="w-auto grid p-4 h-auto bg-white border-[#ECEEF6] rounded-md border-2 gap-y-8">
                <div>
                    <p class="font-bold text-base">نسبة إنجاز المشروع</p>
                </div>
                <div class="flex items-center gap-x-2">
                    <small class="text-sm font-normal text-gray-500">{{ $project->stages->count() }}/{{ $project->stage->count() }} إنجاز المراحل</small>
                    <progress class="progress progress-success w-44" value="{{ count($doneStages) }}" max="{{ $project->stage->count() }}"></progress>
                </div>
            </div>
            <!-- end of project success section -->

            <!-- start of project success section -->
            <div class="w-auto h-auto bg-white border-[#ECEEF6] rounded-md border-2">
                <div class="flex items-center gap-x-7 p-4 justify-between">
                    <p class="font-bold text-base">تكلفة المشروع</p>
                    <x-fas-money-bill-1 class="w-5 text-gray-500" />
                </div>
                <div class="pr-4 py-4">
                    <p class="font-bold text-2xl">{{ ($project->total_cost === null || $project->total_cost === 0) ? 'مجانًا' : $project->total_cost }}</p>
                </div>
            </div>
            <!-- end of project success section -->

            <!-- start of project benefit section -->
            <div class="w-auto h-auto bg-white border-[#ECEEF6] rounded-md border-2 p-4 gap-y-4 grid">
                <div class="flex items-center justify-between">
                    <p class="font-bold text-base">عدد المستفيدين من {{ $project->type_benef === 'جهة' ? 'الجهات' : 'الأفراد'}}</p>
                    <img src="{{ asset("assets/icons/benef_projects.png") }}" class="w-5" alt="project-status" />
                </div>
                <div>
                    <p class="font-bold text-3xl">{{ $project->p_num_beneficiaries }}</p>
                    <small class="text-gray-500 text-sm font-normal">{{ $project->type_benef === 'جهة' ? 'جهة' : 'فرد'}}</small>
                </div>
            </div>
            <!-- end of project benefit section -->
        </div>
    </section>

    <section class="mx-auto">
        <div class="flex items-center gap-x-4 py-16 mx-2
        desktop:justify-around
        laptop:justify-around">
            <h1 class="font-bold text-xl text-center">بيانات المشروع</h1>
            <p class="font-normal text-base text-center">انقر على الرقم لعرض البيانات </p>
        </div>

        <div role="tablist" class="tabs my-16 tabs-boxed bg-transparent">
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="01" />
            <div role="tabpanel" class="tab-content">
                @include('dashboard.general-data')
            </div>
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="02" />
            <div role="tabpanel" class="tab-content">
                @include('dashboard.financial')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="03" />
            <div role="tabpanel" class="tab-content">
                @include('dashboard.project-status')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="04" />
            <div role="tabpanel" class="tab-content">
                @include('dashboard.project-level')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="05" />
            <div role="tabpanel" class="tab-content">
                @include('dashboard.project-code')
            </div>
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="06" />
            <div role="tabpanel" class="tab-content">
                @include('dashboard.project-team')
            </div>
        </div>
    </section>
</div>
@endsection