@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] m-[5.7rem]">
    <h1 class="font-bold text-xl">البيانات الشخصية</h1>

    @if(session('success_message'))
        @include('layouts.success-message')
    @elseif(session('error_message'))
        @include('layouts.error-message')
    @endif

    <form action="{{ route('setting.update') }}" class="relative z-0" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mt-6 grid gap-y-3">
            <small>رفع صورة</small>
            <input value="{{ $admin->profile_image }}" name="profile-image" type="file" class="file-input w-full max-w-sm" />
        </div>
        <div class="grid grid-cols-2 mt-6 gap-y-7">
            <div class="grid gap-y-5">
                <small>الاسم الشخصي</small>
                <input value="{{ $admin->name }}" name="name" type="text" placeholder="{{ $admin->name }}" class="input w-full max-w-sm" />
            </div>
            <div class="grid gap-y-5">
                <small>البريد الإلكتروني</small>
                <input value="{{ $admin->email }}" name="email" type="text" placeholder="{{ $admin->email }}" class="input w-full max-w-sm" />
            </div>
            <div class="grid gap-y-5">
                <small>المنصب</small>
                <input value="{{ $admin->position }}" name="position" type="text" placeholder="{{ $admin->position }}" class="input w-full max-w-sm" />
            </div>
            <div class="grid gap-y-5">
                <small>رقم الجوال</small>
                <input value="{{ $admin->phone_number }}" name="phone-number" type="text" placeholder="{{ $admin->phone_number }}" class="input w-full max-w-sm" />
            </div>
            <div class="grid gap-y-5">
                <small>كلمة المرور</small>
                <input value="{{ $admin->password }}" name="password" type="password" class="input w-full max-w-sm" />
            </div>
            <div class="grid gap-y-5">
                <small>تأكيد كلمة المرور</small>
                <input name="password_confirmation" value="{{ $admin->password }}" type="password" class="input w-full max-w-sm" />
            </div>
        </div>

        <div class="grid mt-9">
            <h1 class="text-xl font-bold">مواقع التواصل الإجتماعي</h1>
            <div class="grid grid-cols-2 mt-6">
                <div class="grid gap-y-5">
                    <small>منصة X</small>
                    <input value="{{ $admin->x }}" name="x" type="text" placeholder="{{ $admin->x }}" class="input w-full max-w-sm" />
                </div>
                <div class="grid gap-y-5">
                    <small>لنكد إن</small>
                    <input value="{{ $admin->linkedin }}" name="linkedin" type="text" placeholder="{{ $admin->linkedin }}" class="input w-full max-w-sm" />
                </div>
            </div>
        </div>

        <div class="mt-[3.8rem] mx-80">
            <button type="submit" class="btn btn-wide text-white bg-cyan-600 font-bold text-base">تحديث البيانات</button>
        </div>
    </form>
</section>
@endsection