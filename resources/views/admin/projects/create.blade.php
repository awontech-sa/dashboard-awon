@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="mx-[5.6rem] font-['Tajawal']">
    <h1 class="font-bold text-xl">مشروع جديد</h1>

    @if(session('error_message'))
    @include('layouts.error-message')
    @elseif(session('success_message'))
    @include('layouts.error-message')
    @endif

    <div role="tablist" class="tabs mt-11 tabs-boxed bg-transparent">
        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="01" {{ $step == 1 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">بيانات عامة</h1>

                <form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.general-data')

                    <div class="join grid grid-cols-2 w-1/4">
                        @if($step == 1)
                        <button type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item w-1/2 btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            التالي
                        </button>
                        @endif
                    </div>

                </form>
            </div>
        </div>
        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="02" {{ $step == 2 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">البيانات المالية</h1>
                @include('admin.projects.financial-data', ['step' => $step])
            </div>
        </div>

        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="03" {{ $step == 3 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                @include('admin.projects.attachments', ['step' => $step])
            </div>
        </div>

        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="04" {{ $step == 4 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">حالة المشروع</h1>

                <form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.status')

                    <div class="join grid grid-cols-2 w-1/4">
                        @if($step == 4 && $step < 8)
                            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            السابق
                            </a>
                            <button type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                                التالي
                            </button>
                            @endif
                    </div>

                </form>
            </div>
        </div>

        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="05" {{ $step == 5 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">مراحل المشروع</h1>

                <form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.level')

                    <div class="join grid grid-cols-2 w-1/4">
                        @if($step == 5 && $step < 8)
                            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            السابق
                            </a>
                            <button type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                                التالي
                            </button>
                            @endif
                    </div>

                </form>
            </div>
        </div>

        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="06" {{ $step == 6 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">برمجة المشروع</h1>

                <form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.code')

                    <div class="join grid grid-cols-2 w-1/4">
                        @if($step == 6 && $step < 8)
                            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            السابق
                            </a>
                            <button type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                                التالي
                            </button>
                            @endif
                    </div>

                </form>
            </div>
        </div>
        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="07" {{ $step == 7 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">فريق العمل</h1>

                <form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.team', ['users' => $users])

                    <div class="join grid grid-cols-2 w-1/4">
                        @if($step == 7)
                        <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                            السابق
                        </a>
                        <button type="submit" href="{{ route('admin.create.project.final') }}" class="join-item btn bg-cyan-700 text-xs text-white hover:bg-cyan-700">
                            إضافة المشروع
                        </button>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection