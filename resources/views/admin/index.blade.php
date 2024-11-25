@extends('layouts.admin-sidebar')

@section('admin-content')
<div>
  <a href="{{ route('admin.new.project.show', ['step' => 1]) }}" class="font-['Tajawal'] btn btn-sm bg-white shadow-none font-normal text-base mr-32 mb-5">إضافة مشروع جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>

  <section class="grid grid-cols-4 gap-x-[1.6rem] w-[67rem] pr-10
  max-sm:pr-10
  max-md:grid-cols-1 max-md:w-auto max-md:gap-y-4 max-md:pr-24 max-md:pt-10
  md:grid-cols-2 md:w-fit md:gap-x-8 md:gap-y-8 md:px-auto
  lg:mx-16 lg:gap-x-[1.6rem] lg:grid-cols-2 lg:w-fit
  2xl:w-auto 2xl:pr-2 2xl:gap-x-[1.6rem] 2xl:grid-cols-4
  xl:w-[67rem] xl:pr-[3.75rem] xl:gap-x-[1.6rem] xl:grid-cols-4">
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
        <p class="font-bold text-3xl">{{ count($dashboard) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end all projects squre -->

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
        <p class="font-bold text-3xl">{{ count($progress_projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end in progress projects -->
  </section>

  <section class="grid grid-cols-3 gap-x-20 pr-[7.7rem] my-6 w-[67rem]">
    <div class="w-[21.3rem] h-36 border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal']">
      <div class="flex items-center mt-2 justify-around">
        <p class="font-bold text-base">عدد المشاريع المدعومة</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/supported_projects.png") }}" alt="supported-projects" />
      </div>
      <div class="grid mr-9">
        <p class="font-bold text-3xl">{{ count($supporter) }}</p>
        <small class="text-sm text-gray-400">مشروع</small>
      </div>
    </div>

    <div class="w-[21.3rem] h-36 border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal']">
      <div class="flex items-center mt-2 justify-around">
        <p class="font-bold text-base">عدد المستفيدين من الجهات</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/benef_projects.png") }}" alt="benef-projects" />
      </div>
      <div class="grid mr-9">
        <p class="font-bold text-3xl">{{ count($supporterComp) }}</p>
        <small class="text-sm text-gray-400">جهة</small>
      </div>
    </div>

    <div class="w-[21.3rem] h-36 border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal']">
      <div class="flex items-center mt-2 justify-around">
        <p class="font-bold text-base">عدد المستفيدين من الأفراد</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/people.png") }}" alt="people" />
      </div>
      <div class="grid mr-9">
        <p class="font-bold text-3xl">{{ count($supporterIndividual) }}</p>
        <small class="text-sm text-gray-400">فرد</small>
      </div>
    </div>
  </section>

  <section class="grid grid-cols-2 w-[72rem] my-7 font-['Tajawal'] pr-[7.7rem]
    lg:grid-cols-1
    xl:gap-x-0 xl:grid-cols-2
    2xl:w-auto 2xl:grid-cols-2">
    <div class="w-[516px] bg-white border-2 border-[#ECEEF6] rounded-md px-6
      2xl:w-auto">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">نسبة إنجاز المشاريع</p>
        <!-- <a href="" class="link text-blue-600">عرض الكل ←</a> -->
      </div>
      {{-- <div class="w-[475px] grid gap-y-6
        2xl:w-auto">
        @foreach($dashboard as $project)
        <div class="grid grid-cols-3 items-center">
          <p>{{ $project->p_name }}</p>
          <p>{{ $project->p_implemented_stages }}/{{ $project->p_stages }}</p>
          //progress
        </div>
        @endforeach
      </div> --}}
    </div>

    <div class="w-[516px] bg-white border-2 border-[#ECEEF6] rounded-md px-6
      2xl:w-auto">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">إجمالي دخل المشاريع</p>
        <!-- <a href="" class="link text-blue-600">عرض الكل ←</a> -->
      </div>
      {{-- <div class="flex">
        <div class="w-[475px] grid gap-y-6">
          <div class="grid grid-cols-2 gap-x-4 items-center">
            <p>سخي</p>
            <p class="text-gray-500">50%</p>
          </div>
          <div class="grid grid-cols-2 gap-x-4 items-center">
            <p>نظام إدارة المحتوى</p>
            <p class="text-gray-500">22.5%</p>
          </div>
          <div class="grid grid-cols-2 gap-x-4 items-center">
            <p>فرصة</p>
            <p class="text-gray-500">30.8%</p>
          </div>
          <div class="grid grid-cols-2 gap-x-4 items-center">
            <p>وعي</p>
            <p class="text-gray-500">8.1%</p>
          </div>
        </div>
        <div class="w-52 h-52">
          {!! $chart->container() !!}
        </div>
      </div> --}}
    </div>
  </section>

  <section class="grid grid-cols-2 font-['Tajawal'] pr-[7.7rem] w-[72rem]">
    <div class="h-[302px] bg-white rounded-md p-7 border-2 border-[#ECEEF6]">
      <h1 class="font-bold text-base">إجمالي الدخل السنوي</h1>
      {!! $viewGrossAnnualIncome->container() !!}
    </div>

    <div class="h-[302px] bg-white rounded-md p-7 border-2 border-[#ECEEF6]">
      <h1 class="font-bold text-base">إجمالي الدخل الحالي</h1>
      {!! $viewCurrentGrossIncome->container() !!}
    </div>
  </section>
</div>
@endsection