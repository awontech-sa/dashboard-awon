@extends('layouts.admin-sidebar')

@section('admin-content')
<div class="overflow-x-auto pb-96 font-['Tajawal']">
    <div class="flex items-center justify-between p-8
    max-md:justify-start max-md:gap-x-32
    2xl:justify-evenly">
        <h1 class="font-bold text-xl">الحسابات</h1>
        <a href="{{ route('admin.create.show') }}" class="btn btn-sm bg-white shadow-none font-normal text-base">إنشاء حساب جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>
    </div>
    <table class="table font-['Tajawal'] rounded-lg mx-auto table-xs w-0
    2xl:w-[1103px] 2xl:table
    xl:w-[1103px] xl:table">
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
                    @if($user->roles[0]->name !== 'Admin')
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.show.update.user', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    <a class="btn btn-xs btn-link bg-[#FAFBFD]" href="{{ route('admin.show.user', ['id' => $user->id]) }}"><x-far-eye class="w-4 h-4 text-gray-600" /></a>
                    @if($user->roles[0]->name !== 'Admin')
                    <form action="{{ route('admin.delete.user', ['id' => $user->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-link bg-[#FAFBFD]">
                            <x-far-trash-can class="w-4 h-4 text-red-500" />
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection