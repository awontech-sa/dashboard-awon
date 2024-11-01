@extends('layouts.admin-sidebar')

@section('admin-content')
<div class="overflow-x-auto">
    <table class="table font-['Tajawal'] rounded-lg w-[1103px] mx-auto">
        <!-- head -->
        <thead>
            <tr>
                <th>#</th>
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
            <tr>
                <th>{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->position }}</td>
                <td>{{ $user->position }}</td>
                <td>
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('powers.show') }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                </td>
                <td>
                    <a class="btn btn-sm btn-link bg-[#FAFBFD]" href="{{ route('powers.show') }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection