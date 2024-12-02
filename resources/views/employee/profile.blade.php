@extends('layouts.employee-sidebar')

@section('employee-content')
<section class="grid items-center gap-x-7 mx-auto gap-y-4">
    <div class="grid grid-cols-1 gap-y-7 gap-x-4 mx-4
    laptop:grid-cols-4">
        <!-- start all projects -->
        <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 px-4">
            <div class="flex gap-x-4 items-center font-['Tajawal'] my-6">
                <p class="text-base font-bold">إجمالي عدد المشاريع</p>
                <img src="{{ asset("assets/icons/all_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] my-[1.26rem]">
                <p class="font-bold text-3xl">{{ count($projects) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end all projects squre -->

        <!-- start in progress projects -->
        <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 px-4">
            <div class="flex gap-x-4 items-center font-['Tajawal'] my-6">
                <p class="text-base font-bold">عدد المشاريع قيد التنفيذ</p>
                <img src="{{ asset("assets/icons/progress.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] my-[1.26rem]">
                <p class="font-bold text-3xl">{{ count($inProgressProjects) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end in progress projects -->

        <!-- start completed projects -->
        <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 px-4">
            <div class="flex gap-x-4 items-center font-['Tajawal'] my-6">
                <p class="text-base font-bold">عدد المشاريع المكتملة</p>
                <img src="{{ asset("assets/icons/completed_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] my-[1.26rem]">
                <p class="font-bold text-3xl">{{ count($completedProjects) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end completed projects -->

        <!-- start stopped projects -->
        <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 px-4">
            <div class="flex gap-x-4 items-center font-['Tajawal'] my-6">
                <p class="text-base font-bold">عدد المشاريع المعلقة</p>
                <img src="{{ asset("assets/icons/stopped_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] my-[1.26rem]">
                <p class="font-bold text-3xl">{{ count($stoppedProjects) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end stopped projects -->
    </div>

    <div class="w-auto h-auto bg-white border-2 border-[#ECEEF6] rounded-md mx-6 font-['Tajawal'] p-4">
        <div class="flex justify-between mb-4">
            <p class="font-bold text-base">نسبة إنجاز المشاريع</p>
        </div>
        <div class="w-auto grid gap-y-6">
            @foreach($projects as $project)
            @foreach($stages as $stage)
            <div class="grid grid-cols-3 items-center">
                <p>{{ $project->p_name }}</p>
                <p>{{ $stage->stageOfProject->count() }}/5 إنجاز المراحل</p>
                <progress class="progress progress-success w-20
                laptop:w-32" value="{{ $stage->stageOfProject->count() }}" max="5"></progress>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
</section>

<section class="mx-10 w-auto my-16">
    <div class="flex items-center gap-x-6 font-['Tajawal']">
        <x-fas-list-check class="w-11 h-11 text-gray-500" />
        <div class="grid gap-y-3">
            <h1 class="font-bold text-xl">مشاريعي</h1>
            <small class="text-sm font-normal text-gray-500">انقر للانتقال إلى صفحة المشروع</small>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-x-4 gap-y-0
    laptop:grid-cols-3
    desktop:grid-cols-4">
        @foreach($projects as $project)
        @foreach($stages as $stage)
        <div class="grid font-['Tajawal']">
            <div class="w-fit h-auto bg-white rounded-md border-2 border-[#ECEEF6] my-11
            2xl:w-auto">
                <div class="flex items-center gap-x-4 mx-5 my-6">
                    <x-far-folder class="w-6 h-6 text-gray-500" />
                    <a href="{{ route('employee.show.project', ['id'=>$project->id]) }}" class="font-bold text-base">{{ $project->p_name }}</a>
                </div>
                <div class="flex gap-x-5 items-center my-9 mx-9">
                    <p>{{ $project->stages->count() }}/{{ $project->stage->count() }} إنجاز المراحل</p>
                    <progress class="progress progress-success w-32" value="{{ $stage->stageOfProject->count() }}" max="5"></progress>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
</section>
@endsection