@extends('layouts.app')
@section('content')
<main class="font-['Tajawal'] w-[1071px] h-full px-16
  2xl:w-auto">
  <section class="grid grid-cols-4 gap-x-32
    xl:gap-x-28
    2xl:gap-x-3">
    <div class="w-64 h-36 bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-auto">
      <div class="flex justify-evenly pt-6
        2xl:justify-between 2xl:pl-10 2xl:pr-6">
        <p class="font-bold text-base">إجمالي عدد المشاريع</p>
        <x-fas-diagram-project class="text-gray-500 w-6 h-6" />
      </div>
      <div class="px-7 py-6">
        <h1 class="font-bold text-3xl">{{ $dashboard->count() }}</h1>
        <small class="text-sm font-normal">مشروع</small>
      </div>
    </div>

    <div class="w-64 h-36 bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-auto">
      <div class="flex justify-evenly pt-6
        2xl:justify-between 2xl:pl-10 2xl:pr-6">
        <p class="font-bold text-base">عدد المشاريع المكتملة</p>
        <x-far-check-circle class="text-gray-500 w-6 h-6" />
      </div>
      <div class="px-7 py-6">
        <h1 class="font-bold text-3xl">{{ $completed_projects->count() }}</h1>
        <small class="text-sm font-normal">مشروع</small>
        <span class="indicator-item float-left badge bg-green-200 text-green-800 py-1 px-2 text-center">75%</span>
      </div>
    </div>

    <div class="w-64 h-36 bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-auto">
      <div class="flex justify-evenly pt-6
        2xl:justify-between 2xl:pl-10 2xl:pr-6">
        <p class="font-bold text-base">عدد المشاريع المعلقة</p>
        <x-far-clock class="text-gray-500 w-6 h-6" />
      </div>
      <div class="px-7 py-6">
        <h1 class="font-bold text-3xl">{{ $stopped_projects->count() }}</h1>
        <small class="text-sm font-normal">مشروع</small>
        <span class="indicator-item float-left badge bg-gray-200 text-gray-600 py-1 px-2 text-center">25%</span>
      </div>
    </div>

    <div class="w-64 h-36 bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-auto">
      <div class="flex justify-evenly pt-6
        2xl:justify-between 2xl:pl-10 2xl:pr-6">
        <p class="font-bold text-base">عدد المشاريع قيد التنفيذ</p>
        <x-fas-tools class="text-gray-500 w-6 h-6" />
      </div>
      <div class="px-7 py-6">
        <h1 class="font-bold text-3xl">{{ $progress_projects->count() }}</h1>
        <small class="text-sm font-normal">مشروع</small>
        <span class="indicator-item float-left badge bg-orange-200 text-orange-600 py-1 px-2 text-center">25%</span>
      </div>
    </div>
  </section>

  <section class="grid grid-cols-3 mt-6 gap-x-36
    xl:gap-x-[7.5rem]
    2xl:gap-x-3">
    <div class="w-[340px] h-[139px] bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-auto">
      <div class="flex justify-between px-9 py-6">
        <p class="font-bold text-base">عدد المشاريع المدعومة</p>
        <x-fas-tools class="text-gray-500 w-6 h-6" />
      </div>
      <div class="px-7">
        <h1 class="font-bold text-3xl">{{ $support_projects->count() }}</h1>
        <small class="text-sm font-normal">مشروع</small>
      </div>
    </div>

    <div class="w-[340px] h-[139px] bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-auto">
      <div class="flex justify-between px-9 py-6">
        <p class="font-bold text-base">عدد المستفيدين من الجهات</p>
        <x-far-building class="text-gray-500 w-6 h-6" />
      </div>
      <div class="px-7">
        <h1 class="font-bold text-3xl">{{ $benef_projects->count() }}</h1>
        <small class="text-sm font-normal">جهة</small>
      </div>
    </div>

    <div class="w-[340px] h-[139px] bg-white border-2 border-[#ECEEF6] rounded-md
      2xl:w-auto">
      <div class="flex justify-between px-9 py-6">
        <p class="font-bold text-base">عدد المستفيدين من الأفراد</p>
        <x-fas-person class="text-gray-500 w-6 h-6" />
      </div>
      <div class="px-7">
        <h1 class="font-bold text-3xl">0</h1>
        <small class="text-sm font-normal">فرد</small>
      </div>
    </div>
  </section>

  <section class="grid grid-cols-2 w-[1071px] h-[296px] my-7 gap-x-[27px]
    xl:gap-x-0
    2xl:w-auto">
    <div class="w-[516px] h-[296px] bg-white border-2 border-[#ECEEF6] rounded-md px-6
      2xl:w-auto">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">نسبة إنجاز المشاريع</p>
        <a href="" class="link text-blue-600">عرض الكل ←</a>
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

    <div class="w-[516px] h-[296px] bg-white border-2 border-[#ECEEF6] rounded-md px-6
      2xl:w-auto">
      <div class="flex justify-between py-6">
        <p class="font-bold text-base">إجمالي دخل المشاريع</p>
        <a href="" class="link text-blue-600">عرض الكل ←</a>
      </div>
      <div class="flex">
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
      </div>
    </div>
  </section>
</main>
@endsection