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
                <th>المنصب</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th>{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection