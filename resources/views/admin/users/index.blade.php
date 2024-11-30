@extends('layouts.admin-sidebar')

@section('admin-content')
<div class="overflow-x-auto pb-96 font-['Tajawal']">
    @if(session('success_message'))
    @include('layouts.success-message')
    @endif
    <div class="flex items-center p-8
    xl:justify-center xl:gap-x-[44rem]
    max-md:grid max-md:gap-y-4
    md:gap-x-[28rem]
    2xl:justify-center 2xl:gap-x-[54rem]">
        <h1 class="font-bold text-xl">الحسابات</h1>
        <a href="{{ route('admin.create.show') }}" class="btn btn-sm bg-white shadow-none font-normal text-base
        max-md:w-fit">إنشاء حساب جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>
    </div>
    <table class="table font-['Tajawal'] rounded-lg mx-auto table-xs w-0
    md:w-[46rem]
    2xl:w-[1103px] 2xl:table
    xl:w-[60rem] xl:table">
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
                <th>
                    @if(!preg_match('/\.(jpg|jpeg|png|gif)$/i', basename($user->profile_image)))
                    <img src="{{ asset("assets/images/user-profile.png") }}" class="w-14" alt="image-profile" />
                    @else
                    <img class="rounded-full w-14 h-14" src="{{ $user->profile_image }}" alt="profile-image" />
                    @endif
                </th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                @foreach($user->positions as $position)
                <td>{{ $position->department->d_name }}</td>
                <td>{{ $position->p_name }}</td>
                @endforeach

                <td>{{ count($user->projects->unique('id')) }}</td>
                <td>
                    @if($user->roles[0]->name !== 'Admin')
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.powers.show', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('admin.show.update.user', ['id' => $user->id]) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                    <a class="btn btn-xs btn-link bg-[#FAFBFD]" href="{{ route('admin.show.user', ['id' => $user->id]) }}"><x-far-eye class="w-4 h-4 text-gray-600" /></a>
                    @if($user->roles[0]->name !== 'Admin')
                    <button class="btn btn-sm btn-link bg-[#FAFBFD]" onclick="my_modal_1.showModal()"><x-far-trash-can class="w-4 h-4 text-red-500" /></button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">هل أنت متأكد من أنك تريد حذف الحساب؟</h3>
            <div class="modal-action flex justify-around items-center">
                <form action="{{ route('admin.delete.user', ['id' => $user->id]) }}" method="POST" style="display: inline;">
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