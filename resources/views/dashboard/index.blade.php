  @extends('layouts.app')
  @section('content')
  <main class="font-['Tajawal'] w-[1071px] h-full px-16
  lg:w-auto
  xl:w-[1071px]
  2xl:w-[1071px]">
    <section class="grid grid-cols-4 gap-x-32
    lg:grid-cols-2 lg:gap-x-4 lg:w-fit lg:gap-y-4 lg:mt-6 lg:mr-56
    xl:gap-x-28 xl:grid-cols-4
    2xl:gap-x-3 2xl:grid-cols-4 2xl:w-auto">
      <div class="w-64 h-36 bg-white border-2 border-[#ECEEF6] rounded-md
      xl:w-64 xl:h-36
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
    lg:gap-x-5 lg:w-fit lg:mr-56
    xl:gap-x-[7.5rem]
    2xl:gap-x-3 2xl:w-auto">
      <div class="w-[340px] h-[139px] bg-white border-2 border-[#ECEEF6] rounded-md
      lg:w-[10.2rem]
      xl:w-[340px]
      2xl:w-auto">
        <div class="flex justify-between px-9 py-6
        xl:px-9 xl:py-6
        2xl:px-9 2xl:py-6
        lg:px-2 lg:py-3">
          <p class="font-bold text-base
          xl:text-base
          2xl:text-base
          lg:text-[0.6rem]">عدد المشاريع المدعومة</p>
          <x-fas-tools class="text-gray-500 w-6 h-6
          xl:w-6 xl:h-6
          2xl:w-6 2xl:h-6
          lg:w-4 lg:h-4" />
        </div>
        <div class="px-7
        lg:px-2">
          <h1 class="font-bold text-3xl
          xl:text-3xl
          2xl:text-3xl
          lg:text-base">{{ $support_projects->count() }}</h1>
          <small class="text-sm font-normal
          xl:text-sm
          lg:text-[0.6rem]">مشروع</small>
        </div>
      </div>

      <div class="w-[340px] h-[139px] bg-white border-2 border-[#ECEEF6] rounded-md
      lg:w-[10.2rem]
      xl:w-[340px]
      2xl:w-auto">
        <div class="flex justify-between px-9 py-6
        xl:px-9 xl:py-6
        2xl:px-9 2xl:py-6
        lg:px-2 lg:py-3">
          <p class="font-bold text-base
          xl:text-base
          2xl:text-base
          lg:text-[0.6rem]">عدد المستفيدين من الجهات</p>
          <x-far-building class="text-gray-500 w-6 h-6
          lg:w-4 lg:h-4" />
        </div>
        <div class="px-7
        2xl:px-2
        lg:px-2">
          <h1 class="font-bold text-3xl
          xl:text-3xl
          2xl:text-3xl
          lg:text-base">{{ $benef_projects->count() }}</h1>
          <small class="text-sm font-normal
          xl:text-sm
          2xl:text-sm
          lg:text-[0.6rem]">جهة</small>
        </div>
      </div>

      <div class="w-[340px] h-[139px] bg-white border-2 border-[#ECEEF6] rounded-md
      lg:w-[10.2rem]
      xl:w-[340px]
      2xl:w-auto">
        <div class="flex justify-between px-9 py-6
        xl:px-9 xl:py-6
        2xl:px-9 2xl:py-6
        lg:px-2 lg:py-3">
          <p class="font-bold text-base
          xl:text-base
          2xl:text-base
          lg:text-[0.6rem]">عدد المستفيدين من الأفراد</p>
          <x-fas-person class="text-gray-500 w-6 h-6
          xl:w-6 xl:h-6
          2xl:w-6 2xl:h-6
          lg:w-4 lg:h-4" />
        </div>
        <div class="px-7
        lg:px-2">
          <h1 class="font-bold text-3xl
          xl:text-3xl
          2xl:text-3xl
          lg:text-base">0</h1>
          <small class="text-sm font-normal
          xl:text-sm
          2xl:text-sm
          lg:text-[0.6rem]">فرد</small>
        </div>
      </div>
    </section>

    <section class="grid grid-cols-2 w-[1071px] h-[296px] my-7 gap-x-[27px]
    lg:grid-cols-1
    xl:gap-x-0 xl:grid-cols-2
    2xl:w-auto 2xl:grid-cols-2">
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