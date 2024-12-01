@extends('layouts.employee-sidebar')
@section('employee-content')
<div class="grid font-['Tajawal'] font-bold text-xl mx-auto w-auto">
    <section>
        <div class="flex items-center justify-evenly">
            <h1>{{ $project->p_name }}</h1>
            <button class="btn btn-sm bg-[#FAFBFD]" onclick="my_modal_1.showModal()">حذف المشروع <x-far-trash-can class="w-4 h-4 text-red-500" /></button>
        </div>
        <div class="grid grid-cols-2 gap-y-8 my-7 mx-auto w-fit
        2xl:gap-x-16 2xl:grid-cols-4
        xl:gap-x-4
        md:gap-x-4">
            <!-- start of project status section -->
            <div class="w-auto h-28 bg-white border-[#ECEEF6] grid place-items-center rounded-md border-2">
                <div class="flex items-center gap-x-[7.2rem]">
                    <p class="font-bold text-base">حالة المشروع</p>
                    <img src="{{ asset("assets/icons/project_status.png") }}" class="w-5" alt="project-status" />
                </div>
                @if($project->project_status == 'معلق')
                <div class="badge badge-primary p-2 w-[16.2rem]">{{ $project->project_status }}</div>
                @elseif($project->project_status == 'قيد التنفيذ')
                <div class="badge badge-warning p-2 w-[16.2rem]">{{ $project->project_status }}</div>
                @elseif($project->project_status == 'مكتمل')
                <div class="badge badge-success p-2 w-[16.2rem]">{{ $project->project_status }}</div>
                @else
                <div class="badge badge-ghost p-2 w-[16.2rem]">{{ $project->project_status }}</div>
                @endif
            </div>
            <!-- end of project status section -->

            <!-- start of project success section -->
            <div class="w-[20.2rem] pt-6 pr-5 h-28 bg-white border-[#ECEEF6] rounded-md border-2">
                <div>
                    <p class="font-bold text-base">نسبة إنجاز المشروع</p>
                </div>
                <div class="flex items-center gap-x-2">
                    <small class="text-sm font-normal text-gray-500">{{ count($stages) }}/5 إنجاز المراحل</small>
                    <progress class="progress progress-success w-44" value="{{ count($stages) }}" max="5"></progress>
                </div>
            </div>
            <!-- end of project success section -->

            <!-- start of project success section -->
            <div class="w-[20.2rem] h-28 bg-white border-[#ECEEF6] rounded-md border-2">
                <div class="flex items-center gap-x-7 pr-4 pt-3">
                    <p class="font-bold text-base">تكلفة المشروع</p>
                    {{-- <img src="{{ asset("assets/icons/benef_projects.png") }}" class="w-5" alt="project-status" /> --}}
                </div>
                <div class="pr-4 py-4">
                    <p class="font-bold text-3xl">{{ ($project->total_cost === null) ? 'مجانًا' : $project->total_cost }}</p>
                </div>
            </div>
            <!-- end of project success section -->

            <!-- start of project benefit section -->
            <div class="w-[20.2rem] h-28 bg-white border-[#ECEEF6] rounded-md border-2">
                <div class="flex items-center gap-x-7 pr-4 pt-3">
                    <p class="font-bold text-base">عدد المستفيدين من الجهات</p>
                    <img src="{{ asset("assets/icons/benef_projects.png") }}" class="w-5" alt="project-status" />
                </div>
                <div class="pr-4">
                    <p class="font-bold text-3xl">{{ $project->p_num_beneficiaries }}</p>
                    <small class="text-gray-500 text-sm font-normal">جهة</small>
                </div>
            </div>
            <!-- end of project benefit section -->
        </div>
    </section>

    <section class="mx-auto">
        <div class="flex items-center justify-around pt-16">
            <h1 class="font-bold text-xl text-center">بيانات المشروع</h1>
            <p class="font-normal text-base text-center">انقر على الرقم لعرض البيانات </p>
        </div>
        
        <div role="tablist" class="tabs my-16 tabs-boxed bg-transparent">
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="01" />
            <div role="tabpanel" class="tab-content">
                @include('employee.projects.project.general-data')
            </div>
            <input
                type="radio"
                name="my_tabs_2"
                role="tab"
                class="tab"
                aria-label="02" />
            <div role="tabpanel" class="tab-content">
                @include('employee.projects.project.financial.index')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="03" />
            <div role="tabpanel" class="tab-content">
                @include('employee.projects.project.project-files')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="04" />
            <div role="tabpanel" class="tab-content">
                @include('employee.projects.project.project-status')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="05" />
            <div role="tabpanel" class="tab-content">
                @include('employee.projects.project.project-level')
            </div>

            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="06" />
            <div role="tabpanel" class="tab-content">
                @include('employee.projects.project.project-code')
            </div>
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="07" />
            <div role="tabpanel" class="tab-content">
                @include('employee.projects.project.project-team')
            </div>
        </div>
    </section>

    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">هل أنت متأكد من أنك تريد حذف المشروع؟</h3>
            <div class="modal-action flex justify-around items-center">
                <form action="{{ route('employee.delete.project', ['id' => $project->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-error">نعم</button>
                </form>
                <form method="dialog">
                    <button class="btn">تراجع</button>
                </form>
            </div>
        </div>
    </dialog>
</div>
@endsection