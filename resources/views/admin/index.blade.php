@extends('layouts.admin-sidebar')

@section('admin-content')
<div>
  <a href="{{ route('admin.new.project.show', ['step' => 1]) }}" class="font-['Tajawal'] btn btn-sm bg-white shadow-none font-normal text-base mx-12 my-5
  2xl:mx-20
  xl:mx-4
  md:mx-32">إضافة مشروع جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>

  <section class="grid grid-cols-1 gap-y-4 w-fit
  max-md:mx-auto
  2xl:mx-20 2xl:gap-x-[1.6rem] 2xl:grid-cols-4 2xl:w-auto
  xl:gap-x-1 xl:w-fit xl:mx-4 xl:grid-cols-4
  md:grid-cols-2 md:mx-auto md:gap-x-4">

    @if(session('success_message'))
    @include('layouts.success-message')
    @endif

    <!-- start all projects -->
    <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
    2xl:w-auto
    xl:w-56">
      <div class="flex justify-around items-center font-['Tajawal'] my-6">
        <p class="text-base font-bold">إجمالي عدد المشاريع</p>
        <img src="{{ asset("assets/icons/all_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mx-[1.3rem] my-[1.26rem]
      2xl:mx-[5.2rem]
      xl:mx-4
      md:mx-4">
        <p class="font-bold text-3xl">{{ count($projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end all projects squre -->

    <!-- start completed projects -->
    <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
    2xl:w-auto
    xl:w-56">
      <div class="flex justify-around items-center font-['Tajawal'] pt-6">
        <p class="text-base font-bold">عدد المشاريع المكتملة</p>
        <img src="{{ asset("assets/icons/completed_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mx-[1.3rem] pt-[1.26rem]
      2xl:mx-[5.2rem]
      xl:mx-[1.3rem]">
        <p class="font-bold text-3xl">{{ count($completed_projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end completed projects -->

    <!-- start stopped projects -->
    <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
    2xl:w-auto
    xl:w-56">
      <div class="flex justify-around items-center font-['Tajawal'] pt-6">
        <p class="text-base font-bold">عدد المشاريع المعلقة</p>
        <img src="{{ asset("assets/icons/stopped_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mx-[1.3rem] my-[1.26rem]
      2xl:mx-[5.2rem]
      xl:mx-[1.3rem]">
        <p class="font-bold text-3xl">{{ count($stopped_projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end stopped projects -->

    <!-- start in progress projects -->
    <div class="w-[15.5rem] h-[8.5rem] bg-white rounded-md border-[#ECEEF6] border-2
    xl:w-[15.5rem]
    2xl:w-[29rem]">
      <div class="flex justify-around items-center font-['Tajawal'] my-6">
        <p class="text-base font-bold">عدد المشاريع قيد التنفيذ</p>
        <img src="{{ asset("assets/icons/progress.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mx-[1.3rem] my-[1.26rem]
      2xl:mx-[5.2rem]
      xl:mx-[1.3rem]">
        <p class="font-bold text-3xl">{{ count($progress_projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end in progress projects -->
  </section>

  <section class="grid grid-cols-1 gap-x-20 mx-10 my-6 w-fit
  2xl:mx-20
  xl:grid-cols-3 xl:gap-x-6 xl:mx-4
  md:grid-cols-1 md:mx-32 md:gap-y-4
  max-md:mx-12 max-md:gap-y-4">
    <div class="h-36 border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal']
    2xl:w-[40rem]
    xl:w-80
    md:w-[32rem]
    max-md:w-[16rem]">
      <div class="flex items-center mt-2 justify-around
      2xl:justify-between 2xl:mx-20
      xl:justify-around xl:mx-0
      md:justify-between md:mx-10">
        <p class="font-bold text-base">عدد المشاريع المدعومة</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/supported_projects.png") }}" alt="supported-projects" />
      </div>
      <div class="grid mx-9
      2xl:mx-20">
        <p class="font-bold text-3xl">{{ count($supporter) }}</p>
        <small class="text-sm text-gray-400">مشروع</small>
      </div>
    </div>

    <div class="h-36 border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal']
    2xl:w-[40rem]
      xl:w-80
    md:w-[32rem]
    max-md:w-[16rem]">
      <div class="flex items-center my-2 justify-around
      2xl:justify-between 2xl:mx-20
      xl:justify-around xl:mx-0
      md:justify-between md:mx-10">
        <p class="font-bold text-base">عدد المستفيدين من الجهات</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/benef_projects.png") }}" alt="benef-projects" />
      </div>
      <div class="grid mx-9
      2xl:mx-20">
        <p class="font-bold text-3xl">{{ count($supporterComp) }}</p>
        <small class="text-sm text-gray-400">جهة</small>
      </div>
    </div>

    <div class="h-36 border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal']
    2xl:w-[41rem]
    xl:w-80
    md:w-[32rem]
    max-md:w-[16rem]">
      <div class="flex items-center my-2 justify-around
      2xl:justify-between 2xl:mx-20
      xl:justify-around xl:mx-0
      md:justify-between md:mx-10">
        <p class="font-bold text-base">عدد المستفيدين من الأفراد</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/people.png") }}" alt="people" />
      </div>
      <div class="grid mx-9
      2xl:mx-20">
        <p class="font-bold text-3xl">{{ count($supporterIndividual) }}</p>
        <small class="text-sm text-gray-400">فرد</small>
      </div>
    </div>
  </section>

  <section class="grid grid-cols-2 w-fit my-7 font-['Tajawal'] mx-[7.7rem]
    2xl:grid-cols-2 2xl:mx-20 2xl:w-auto
    xl:grid-cols-2 xl:mx-0
    md:grid-cols-1 md:mx-24 md:gap-y-4
    max-md:grid-cols-1 max-md:mx-4 max-md:gap-y-4">
    <div class="w-[516px] bg-white border-2 border-[#ECEEF6] rounded-md mx-6
      2xl:w-[60rem] 2xl:my-6 2xl:mx-0 2xl:px-8
      xl:w-[30.6rem] xl:px-8
      md:px-4
      max-md:w-[16rem] max-md:px-4">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">نسبة إنجاز المشاريع</p>
        <a href="{{ route('admin.percentage') }}" class="link text-blue-600">عرض الكل ←</a>
      </div>
      <div class="w-auto grid gap-y-6">
        @foreach($dashboard as $project)
        <div class="grid grid-cols-3 items-center">
          <p>{{ $project->p_name }}</p>
          <p>{{ $project->stages->count() }}/{{ $project->stage->count() }}</p>
          <progress class="progress progress-success" value="{{ $project->stages->count() }}" max="5"></progress>
        </div>
        @endforeach
      </div>
    </div>

    <div class="w-[516px] bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-[63rem] 2xl:my-6 2xl:px-8
      xl:w-[30.6rem] xl:px-8 xl:mx-0
      md:mx-6 md:px-4
      max-md:w-[16rem] max-md:mx-7 max-md:px-4">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">إجمالي دخل المشاريع</p>
        <a href="" class="link text-blue-600">عرض الكل ←</a>
      </div>
      {{-- <div class="flex py-4">
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

  <section class="grid grid-cols-2 font-['Tajawal'] mx-[7.7rem] w-fit
  2xl:mx-20 2xl:w-auto
  xl:mx-4 xl:w-fit xl:gap-x-8 xl:grid-cols-2
  md:grid-cols-1 md:gap-y-6 md:mx-24
  max-md:grid-cols-1 max-md:mx-10 max-md:gap-y-4">
    <div class="h-[302px] bg-white rounded-md p-7 border-2 border-[#ECEEF6]
    2xl:w-[64rem]
    xl:w-[30.6rem] xl:mx-0
    md:w-[32rem] md:mx-7
    max-md:w-[16rem]">
      <h1 class="font-bold text-base">إجمالي الدخل السنوي</h1>
      {!! $viewGrossAnnualIncome->container() !!}
    </div>

    <div class="h-[302px] bg-white rounded-md p-7 border-2 border-[#ECEEF6]
    2xl:w-[64rem]
    xl:w-[30.6rem] xl:mx-0
    md:w-[32rem] md:mx-7
    max-md:w-[16rem]">
      <h1 class="font-bold text-base">إجمالي الدخل الحالي</h1>
      {!! $viewCurrentGrossIncome->container() !!}
    </div>
  </section>
</div>
@endsection