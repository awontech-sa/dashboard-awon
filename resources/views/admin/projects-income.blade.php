@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] px-12">
    <h1 class="font-bold text-xl">إجمالي دخل المشاريع</h1>

    <div class="grid gap-y-5 my-8">
        @foreach($projects as $project)
        <div class="h-20 bg-white border-gray-500 border-[0.6px] rounded-xl grid grid-cols-2 w-1/2 p-4">
            <p class="font-medium text-base">{{ $project->p_name }}</p>
            <p class="text-base font-normal">{{ ($project->total_cost === null || $project->total_cost === 0) ? 'مجانًا' : $project->total_cost }}</p>
        </div>
        @endforeach
    </div>
</section>
@endsection