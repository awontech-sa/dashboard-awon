@extends('layouts.employee-sidebar')

@section('employee-content')
<section class="flex items-center gap-x-7">
    <div class="grid grid-cols-2 gap-x-[1.6rem] pr-10 w-fit gap-y-7">
        <!-- start all projects -->
        <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
        xl:w-[15.5rem]
        2xl:w-auto">
            <div class="flex justify-around items-center font-['Tajawal'] pt-6">
                <p class="text-base font-bold">إجمالي عدد المشاريع</p>
                <img src="{{ asset("assets/icons/all_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] pr-[1.3rem] pt-[1.26rem]
          2xl:pr-[5.2rem]
          xl:pr-[1.3rem]">
                <p class="font-bold text-3xl">{{ count($project) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end all projects squre -->

        <!-- start in progress projects -->
        <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
        xl:w-[15.5rem]
        2xl:w-auto">
            <div class="flex justify-around items-center font-['Tajawal'] pt-6">
                <p class="text-base font-bold">عدد المشاريع قيد التنفيذ</p>
                <img src="{{ asset("assets/icons/progress.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] pr-[1.3rem] pt-[1.26rem]
          2xl:pr-[5.2rem]
          xl:pr-[1.3rem]">
                <p class="font-bold text-3xl">{{ count($completed_projects) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end in progress projects -->

        <!-- start completed projects -->
        <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
        xl:w-[15.5rem]
        2xl:w-auto">
            <div class="flex justify-around items-center font-['Tajawal'] pt-6">
                <p class="text-base font-bold">عدد المشاريع المكتملة</p>
                <img src="{{ asset("assets/icons/completed_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] pr-[1.3rem] pt-[1.26rem]
          2xl:pr-[5.2rem]
          xl:pr-[1.3rem]">
                <p class="font-bold text-3xl">{{ count($completed_projects) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end completed projects -->

        <!-- start stopped projects -->
        <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
        xl:w-[15.5rem]
        2xl:w-auto">
            <div class="flex justify-around items-center font-['Tajawal'] pt-6">
                <p class="text-base font-bold">عدد المشاريع المعلقة</p>
                <img src="{{ asset("assets/icons/stopped_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
            </div>
            <div class="grid font-['Tajawal'] pr-[1.3rem] pt-[1.26rem]
          2xl:pr-[5.2rem]
          xl:pr-[1.3rem]">
                <p class="font-bold text-3xl">{{ count($stopped_projects) }}</p>
                <small class="text-sm font-normal text-gray-500">مشروع</small>
            </div>
        </div>
        <!-- end stopped projects -->
    </div>

    <div class="w-[516px] h-[296px] bg-white border-2 border-[#ECEEF6] rounded-md px-6 font-['Tajawal']
      2xl:w-auto">
        <div class="flex justify-between py-6">
            <p class="font-bold text-base">نسبة إنجاز المشاريع</p>
        </div>
        <div class="w-[475px] grid gap-y-6
        2xl:w-auto">
            <div class="grid grid-cols-3 items-center">
                <p>سخي</p>
                <p>7/10 إنجاز المراحل</p>
                <progress class="progress progress-success w-32" value="70" max="100"></progress>
            </div>
            <div class="grid grid-cols-3 items-center">
                <p>نظام إدارة المحتوى</p>
                <p>7/10 إنجاز المراحل</p>
                <progress class="progress progress-success w-32" value="70" max="100"></progress>
            </div>
            <div class="grid grid-cols-3 items-center">
                <p>فرصة</p>
                <p>7/10 إنجاز المراحل</p>
                <progress class="progress progress-success w-32" value="70" max="100"></progress>
            </div>
            <div class="grid grid-cols-3 items-center">
                <p>وعي</p>
                <p>7/10 إنجاز المراحل</p>
                <progress class="progress progress-success w-32" value="70" max="100"></progress>
            </div>
        </div>
    </div>
</section>

<section class="pr-10 pt-8">
    <div class="flex items-center gap-x-6 font-['Tajawal']">
        <x-fas-list-check class="w-11 h-11 text-gray-500" />
        <div class="grid gap-y-3">
            <h1 class="font-bold text-xl">مشاريعي</h1>
            <small class="text-sm font-normal text-gray-500">انقر للانتقال إلى صفحة المشروع</small>
        </div>
    </div>

    <div class="grid grid-cols-3">
        <div class="grid grid-cols-2 font-['Tajawal']">
            <div class="w-[19.4rem] h-36 bg-white rounded-md border-2 border-[#ECEEF6] mt-11">
                <div class="flex items-center gap-x-4 mr-5 mt-6">
                    <x-far-folder class="w-6 h-6 text-gray-500" />
                    <h1 class="font-bold text-base">نظام إدارة المحتوى</h1>
                </div>
                <div class="flex gap-x-5 items-center mt-9 mr-9">
                    <p>7/10 إنجاز المراحل</p>
                    <progress class="progress progress-success w-32" value="70" max="100"></progress>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 font-['Tajawal']">
            <div class="w-[19.4rem] h-36 bg-white rounded-md border-2 border-[#ECEEF6] mt-11">
                <div class="flex items-center gap-x-4 mr-5 mt-6">
                    <x-far-folder class="w-6 h-6 text-gray-500" />
                    <h1 class="font-bold text-base">نظام إدارة المحتوى</h1>
                </div>
                <div class="flex gap-x-5 items-center mt-9 mr-9">
                    <p>7/10 إنجاز المراحل</p>
                    <progress class="progress progress-success w-32" value="70" max="100"></progress>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 font-['Tajawal']">
            <div class="w-[19.4rem] h-36 bg-white rounded-md border-2 border-[#ECEEF6] mt-11">
                <div class="flex items-center gap-x-4 mr-5 mt-6">
                    <x-far-folder class="w-6 h-6 text-gray-500" />
                    <h1 class="font-bold text-base">نظام إدارة المحتوى</h1>
                </div>
                <div class="flex gap-x-5 items-center mt-9 mr-9">
                    <p>7/10 إنجاز المراحل</p>
                    <progress class="progress progress-success w-32" value="70" max="100"></progress>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 font-['Tajawal']">
            <div class="w-[19.4rem] h-36 bg-white rounded-md border-2 border-[#ECEEF6] mt-11">
                <div class="flex items-center gap-x-4 mr-5 mt-6">
                    <x-far-folder class="w-6 h-6 text-gray-500" />
                    <h1 class="font-bold text-base">نظام إدارة المحتوى</h1>
                </div>
                <div class="flex gap-x-5 items-center mt-9 mr-9">
                    <p>7/10 إنجاز المراحل</p>
                    <progress class="progress progress-success w-32" value="70" max="100"></progress>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection