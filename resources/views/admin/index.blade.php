@extends('layouts.admin-sidebar')

@section('admin-content')
<div>
  <a href="{{ route('admin.new.project.show', ['step' => 1]) }}" class="font-['Tajawal'] btn btn-sm bg-white shadow-none font-normal text-base mx-12 my-5">إضافة مشروع جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>

  <section class="grid grid-cols-1 gap-y-4
  laptop:grid-cols-4 laptop:mx-12 laptop:gap-x-4">

    @if(session('success_message'))
    @include('layouts.success-message')
    @endif

    <!-- start all projects -->
    <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 p-4">
      <div class="flex items-center font-['Tajawal'] gap-x-4">
        <p class="text-base font-bold">إجمالي عدد المشاريع</p>
        <img src="{{ asset("assets/icons/all_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mt-4">
        <p class="font-bold text-3xl">{{ count($projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end all projects squre -->

    <!-- start completed projects -->
    <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 p-4">
      <div class="flex items-center font-['Tajawal'] gap-x-4">
        <p class="text-base font-bold">عدد المشاريع المكتملة</p>
        <img src="{{ asset("assets/icons/completed_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mt-4">
        <p class="font-bold text-3xl">{{ count($completed_projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end completed projects -->

    <!-- start stopped projects -->
    <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 p-4">
      <div class="flex items-center font-['Tajawal'] gap-x-4">
        <p class="text-base font-bold">عدد المشاريع المعلقة</p>
        <img src="{{ asset("assets/icons/stopped_projects.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mt-4">
        <p class="font-bold text-3xl">{{ count($stopped_projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end stopped projects -->

    <!-- start in progress projects -->
    <div class="w-auto h-auto bg-white rounded-md border-[#ECEEF6] border-2 p-4">
      <div class="flex items-center font-['Tajawal'] gap-x-4">
        <p class="text-base font-bold">عدد المشاريع قيد التنفيذ</p>
        <img src="{{ asset("assets/icons/progress.png") }}" alt="all-project icon" class="w-6 h-6" />
      </div>
      <div class="grid font-['Tajawal'] mt-4">
        <p class="font-bold text-3xl">{{ count($progress_projects) }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end in progress projects -->
  </section>

  <section class="grid grid-cols-1 mx-12 my-6
  laptop:grid-cols-3 laptop:gap-x-4">
    <div class="w-auto h-auto border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal'] py-2">
      <div class="flex items-center mt-2 justify-between px-10">
        <p class="font-bold text-base">عدد المشاريع المدعومة</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/supported_projects.png") }}" alt="supported-projects" />
      </div>
      <div class="grid mx-9">
        <p class="font-bold text-3xl">{{ count($supporter) }}</p>
        <small class="text-sm text-gray-400">مشروع</small>
      </div>
    </div>

    <div class="w-auto h-auto border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal'] py-2">
      <div class="flex items-center my-2 justify-between px-10">
        <p class="font-bold text-base">عدد المستفيدين من الجهات</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/benef_projects.png") }}" alt="benef-projects" />
      </div>
      <div class="grid mx-9">
        <p class="font-bold text-3xl">{{ count($supporterComp) }}</p>
        <small class="text-sm text-gray-400">جهة</small>
      </div>
    </div>

    <div class="w-auto h-auto border-[#ECEEF6] grid gap-y-2 rounded-md bg-white border-2 font-['Tajawal'] py-2">
      <div class="flex items-center my-2 justify-between px-10">
        <p class="font-bold text-base">عدد المستفيدين من الأفراد</p>
        <img class="w-6 h-6" src="{{ asset("assets/icons/people.png") }}" alt="people" />
      </div>
      <div class="grid mx-9">
        <p class="font-bold text-3xl">{{ $supporterIndividual }}</p>
        <small class="text-sm text-gray-400">فرد</small>
      </div>
    </div>
  </section>

  <section class="flex items-center font-['Tajawal'] mx-4">
    <div class="w-auto h-auto bg-white border-2 border-[#ECEEF6] rounded-md mx-6 px-4">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">نسبة إنجاز المشاريع</p>
        <a href="{{ route('admin.percentage') }}" class="link text-blue-600">عرض الكل ←</a>
      </div>
      <div class="grid gap-y-6 pb-4">
        @foreach($dashboard as $project)
        <div class="grid grid-cols-3 items-center">
          <p>{{ $project->p_name }}</p>
          <p>{{ $project->stages->count() }}/{{ $project->stage->count() }}</p>
          <progress class="progress progress-success" value="{{ $project->stages->count() }}" max="{{ $project->stage->count() }}"></progress>
        </div>
        @endforeach
      </div>
    </div>

    <div class="w-auto h-auto bg-white border-2 border-[#ECEEF6] rounded-md mx-6 px-4">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">إجمالي دخل المشاريع</p>
        <a href="{{ route('admin.show.income') }}" class="link text-blue-600">عرض الكل ←</a>
      </div>
      <div class="flex py-4">
        <div class="grid gap-y-6">
          @foreach($dashboard as $project)
          <div class="grid grid-cols-2 gap-x-4 items-center">
            <p>{{ $project->p_name }}</p>
            <p class="text-gray-500">{{ ($project->total_cost === null || $project->total_cost === 0) ? 'مجانًا' : $project->total_cost }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <section class="grid grid-cols-2 font-['Tajawal'] mx-12 gap-x-10 my-8">
    <div class="w-auto h-auto bg-white rounded-md p-7 border-2 border-[#ECEEF6]">
      <h1 class="font-bold text-base">إجمالي الدخل السنوي</h1>
      {!! $viewGrossAnnualIncome->container() !!}
    </div>

    <div class="w-auto h-auto bg-white rounded-md p-7 border-2 border-[#ECEEF6]">
      <h1 class="font-bold text-base">إجمالي الدخل الحالي</h1>
      {!! $viewCurrentGrossIncome->container() !!}
    </div>
  </section>
</div>
@endsection