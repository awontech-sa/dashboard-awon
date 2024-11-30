@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] px-12">
    <h1 class="font-bold text-xl">نسبة إنجاز المشاريع</h1>
    
    <div class="grid gap-y-5 my-8">
        @foreach($projects as $project)
        <div class="w-full h-20 bg-white border-gray-500 border-[0.6px] rounded-xl flex justify-around items-center
        max-md:max-w-xs max-md:grid">
            <div class="flex items-center gap-x-6">
                <x-far-folder-open class="w-8 h-8 text-gray-600
                max-md:hidden" />
                <p class="font-medium text-base
                max-md:text-xs">{{ $project->p_name }}</p>
            </div>
    
            <div class="flex items-center gap-x-5">
                <p class="text-sm font-normal
                max-md:text-xs">تم إنجاز {{ $project->stages->count() }} من أصل 5 مراحل</p>
                <progress class="progress progress-success w-56
                max-md:w-16" value="{{ $project->stages->count() }}" max="5"></progress>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection