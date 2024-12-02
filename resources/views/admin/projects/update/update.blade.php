@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="mx-[5.6rem] font-['Tajawal']">
    @foreach($dashboard as $project)
    <h1 class="font-bold text-xl">تعديل مشروع {{ $project->p_name }}</h1>

    @if(session('error_message'))
    @include('layouts.error-message')
    @elseif(session('success_message'))
    @include('layouts.error-message')
    @endif

    <div role="tablist" class="tabs my-11 tabs-boxed bg-transparent">
        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="01" {{ $step == 1 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">بيانات عامة</h1>
                @include('admin.projects.update.general-data')
            </div>
        </div>
        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="02" {{ $step == 2 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">البيانات المالية</h1>
                @include('admin.projects.update.financial-data', ['step' => $step])
            </div>
        </div>

        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="03" {{ $step == 3 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                @include('admin.projects.update.attachments', ['step' => $step])
            </div>
        </div>

        <input type="radio" disabled name="my_tabs_2" role="tab" class="tab" aria-label="04" {{ $step == 4 ? "checked" : "" }} />
        <div role="tabpanel" class="tab-content">
            <div class="my-20">
                <h1 class="font-bold text-xl">حالة المشروع</h1>

                <form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.update.status')

                    <div class="join grid grid-cols-2 w-1/4 float-left">
                        @if($step == 4 && $step < 8)
                            <a type="submit" href="{{ route('admin.update.project', ['step' => $step - 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
                            hover:bg-cyan-700/30 hover:text-cyan-700">
                            السابق
                            </a>
                            <button type="submit" href="{{ route('admin.update.project', ['step' => $step + 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700 text-base text-white
                            hover:bg-cyan-700">
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

                <form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.update.level')

                    <div class="join grid grid-cols-2 w-1/4 float-left">
                        @if($step == 5 && $step < 8)
                            <a type="submit" href="{{ route('admin.update.project', ['step' => $step - 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
                            hover:bg-cyan-700/30 hover:text-cyan-700">
                            السابق
                            </a>
                            <button type="submit" href="{{ route('admin.update.project', ['step' => $step + 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700 text-base text-white
                            hover:bg-cyan-700">
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

                <form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.update.code')

                    <div class="join grid grid-cols-2 w-1/4 float-left">
                        @if($step == 6 && $step < 8)
                            <a type="submit" href="{{ route('admin.update.project', ['step' => $step - 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
                            hover:bg-cyan-700/30 hover:text-cyan-700">
                            السابق
                            </a>
                            <button type="submit" href="{{ route('admin.update.project', ['step' => $step + 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700 text-base text-white
                            hover:bg-cyan-700">
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

                <form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.projects.update.team', ['users' => $users])

                    <div class="join grid grid-cols-2 w-1/4 float-left">
                        @if($step == 7)
                        <a type="submit" href="{{ route('admin.update.project', ['step' => $step - 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
                        hover:bg-cyan-700/30 hover:text-cyan-700">
                            السابق
                        </a>
                        <button type="submit" href="{{ route('admin.update.project.final') }}" class="join-item btn bg-cyan-700 text-xs text-white
                        hover:bg-cyan-700">
                            تعديل المشروع
                        </button>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
    @endforeach
</section>
@endsection