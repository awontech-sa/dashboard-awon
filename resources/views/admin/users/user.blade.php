@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="grid gap-y-14 mx-14 font-['Tajawal'] my-20">
    <div class="flex items-center gap-x-4">
        <h1 class="font-bold text-xl">البيانات الشخصية</h1>
        <a class="btn btn-sm btn-link border rounded-lg border-gray-500 bg-[#FAFBFD]" href="{{ route('admin.show.update.user', $id) }}"><x-far-pen-to-square class="w-4 h-4 text-gray-600" /></a>
    </div>

    <div class="w-[65.7rem] font-normal text-base" dir="rtl">
        <table class="table border rounded-2xl p-11">
            <tbody>
                @foreach($user as $u)
                <tr>
                    <td>الصورة الشخصية</td>
                    <td>
                        @if(!preg_match('/\.(jpg|jpeg|png|gif)$/i', basename($u->profile_image)))
                        <img src="{{ asset("assets/images/user-profile.png") }}" class="w-14" alt="image-profile" />
                        @else
                        <img class="rounded-full w-14 h-14" src="{{ $u->profile_image }}" alt="profile-image" />
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>الإسم الشخصي</td>
                    <td>{{ $u->name }}</td>
                </tr>
                <tr>
                    <td>البريد الإلكتروني</td>
                    <td>{{ $u->email }}</td>
                </tr>
                <tr>
                    <td>المنصب</td>
                    @foreach($userPosition as $position)
                    <td>{{ $position->p_name }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>رقم الجوال</td>
                    <td>{{ $u->phone_number }}</td>
                </tr>
                <tr>
                    <td>منصة X</td>
                    <td>{{ $u->x }}</td>
                </tr>
                <tr>
                    <td>لنكد إن</td>
                    <td>{{ $u->linkedin }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection