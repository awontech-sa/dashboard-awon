@extends('layouts.app')
@section('content')
<div>
  <section class="grid grid-cols-4 gap-x-[1.6rem] w-[67rem] pr-[3.75rem]
  md:grid-cols-2 md:w-auto md:gap-x-0 md:gap-y-4
  lg:pr-0 lg:gap-x-[1.6rem] lg:grid-cols-4
  2xl:w-auto 2xl:pr-[3.75rem] 2xl:gap-x-[1.6rem] 2xl:grid-cols-4
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
        <p class="font-bold text-3xl">{{ $dashboard->count() }}</p>
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
        <p class="font-bold text-3xl">{{ $completed_projects->count() }}</p>
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
        <p class="font-bold text-3xl">{{ $stopped_projects->count() }}</p>
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
        <p class="font-bold text-3xl">{{ $progress_projects->count() }}</p>
        <small class="text-sm font-normal text-gray-500">مشروع</small>
      </div>
    </div>
    <!-- end in progress projects -->
  </section>

  <section></section>

  <section></section>
</div>
@endsection