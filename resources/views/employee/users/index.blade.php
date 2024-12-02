@extends('layouts.employee-sidebar')

@section('employee-content')
<div class="overflow-x-auto pb-96 font-['Tajawal']">
    @if(session('success_message'))
    @include('layouts.success-message')
    @endif
    <div class="flex items-center justify-evenly py-8">
        <h1 class="font-bold text-xl">الحسابات</h1>
    </div>
    <table class="table font-['Tajawal'] rounded-lg mx-auto table-xs w-auto">
        <!-- head -->
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>الصورة</th>
                <th>الاسم</th>
                <th>البريد الالكتروني</th>
                <th>الإدارة</th>
                <th>المنصب</th>
                <th>عدد المشاريع</th>
                <th>الإعدادات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="text-center">
                <th>{{ $user->id }}</th>
                <th><img class="rounded-full w-14 h-14" src="{{ $user->profile_image }}" alt="profile-image" /></th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                @foreach($user->positions as $position)
                <td>{{ $position->department->d_name }}</td>
                <td>{{ $position->p_name }}</td>
                @endforeach

                <td>{{ count($user->projects) }}</td>
                <td>
                    @foreach($permission as $p)
                    @if($p->permission === 'تعديل' && $user->roles[0]->name !== 'Admin')
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('employee.show.update.user', ['id' => $user->id])}}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    @elseif($p->permission === 'مشاهدة')
                    <a class="btn btn-xs btn-link bg-[#FAFBFD]" href="{{ route('employee.show.user', ['id' => $user->id]) }}"><x-far-eye class="w-4 h-4 text-gray-600" /></a>
                    @elseif($p->permission === 'حذف' && $user->roles[0]->name !== 'Admin')
                    <form action="{{ route('employee.delete.user', ['id' => $user->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-link bg-[#FAFBFD]">
                            <x-far-trash-can class="w-4 h-4 text-red-500" />
                        </button>
                    </form>
                    @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection