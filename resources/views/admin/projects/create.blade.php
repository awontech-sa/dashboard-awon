@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="mx-[5.6rem] font-['Tajawal']">
    <h1 class="font-bold text-xl">مشروع جديد</h1>

    <div role="tablist" class="tabs mt-11 tabs-boxed bg-transparent">
        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="01" {{ $step == 1 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">بيانات عامة</h1>

                @if(session('success_message'))
                @include('layouts.success-message')
                @elseif(session('error_message'))
                @include('layouts.error-message')
                @endif

                <form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST">
                    @csrf
                    @include('admin.projects.general-data', ['typeBenef' => $typeBenef])


                    <div class="join grid grid-cols-2 w-1/4">
                        @if($step == 1)
                        <a type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item w-1/2 btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            التالي
                        </a>
                        @endif

                        @if($step > 1 && $step < 7)
                            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            السابق
                            </a>
                            <a type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                                التالي
                            </a>
                            @endif

                            @if($step == 7)
                            <a type="submit" href="{{ route('admin.create.project.finalize') }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                                إضافة المشروع
                            </a>
                            @endif
                    </div>

                </form>
            </div>
        </div>
        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="02" {{ $step == 2 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">البيانات المالية</h1>

                @if(session('success_message'))
                @include('layouts.success-message')
                @elseif(session('error_message'))
                @include('layouts.error-message')
                @endif

                <form action="{{ route('admin.create.project', ['step' => 2]) }}" method="POST">
                    @csrf
                    @include('admin.projects.financial-data')

                    <div class="join grid grid-cols-2 w-1/4">
                        @if($step == 1)
                        <a type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item w-1/2 btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            التالي
                        </a>
                        @endif

                        @if($step > 1 && $step < 7)
                            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            السابق
                            </a>
                            <a type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                                التالي
                            </a>
                            @endif

                            @if($step == 7)
                            <a type="submit" href="{{ route('admin.create.project.finalize') }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                                إضافة المشروع
                            </a>
                            @endif
                    </div>
                </form>
            </div>
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="03" {{ $step == 3 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            //
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="04" {{ $step == 4 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            //
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="05" {{ $step == 5 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            //
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="06" {{ $step == 6 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            //
        </div>
        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="07" {{ $step == 7 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            //
        </div>
    </div>
</section>
@endsection