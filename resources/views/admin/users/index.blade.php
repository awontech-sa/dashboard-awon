@extends('layouts.admin-sidebar')

@section('admin-content')
<div class="overflow-x-auto pb-96 font-['Tajawal']">
    <div class="flex items-center justify-between p-8">
        <h1 class="font-bold text-xl">الحسابات</h1>
        <a href="" class="btn btn-sm bg-white shadow-none font-normal text-base">إنشاء حساب جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>
    </div>
    <table class="table font-['Tajawal'] rounded-lg w-[1103px] mx-auto">
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
                <th>الصلاحيات</th>
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
                    @if($admin->email === $user->email)
                    <a class="btn btn-sm hidden btn-link bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    @else
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    @endif
                </td>
                <td>
                    @if(($admin->email === $user->email) && ($admin->email != $user->email && $adminPermission->powers_id != 2))
                    <a class="btn btn-sm btn-link hidden bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    @elseif($admin->email != $user->email && $adminPermission->powers_id === 2)
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    @endif
                    
                    @if(($admin->email === $user->email) && ($admin->email != $user->email && $adminPermission->powers_id != 1))
                    <a class="btn btn-sm hidden btn-link bg-[#FAFBFD]" href="{{ route('admin.show.user', ['id' => $user->id]) }}"><x-far-eye class="w-4 h-4 text-gray-600" /></a>
                    @elseif($admin->email != $user->email && $adminPermission->powers_id === 1)
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.show.user', ['id' => $user->id]) }}"><x-far-eye class="w-4 h-4 text-gray-600" /></a>
                    @endif
                    
                    @if(($admin->email === $user->email) && ($admin->email != $user->email && $adminPermission->powers_id != 3))
                    <a class="btn btn-sm btn-link hidden bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-trash-can class="w-4 h-4 text-red-500" /></a>
                    @elseif($admin->email != $user->email && $adminPermission->powers_id === 3)
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-trash-can class="w-4 h-4 text-red-500" /></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection