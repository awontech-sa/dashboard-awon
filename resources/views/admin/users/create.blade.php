@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] m-[5.7rem]
2xl:mx-96">
    <h1 class="font-bold text-xl">البيانات الشخصية</h1>

    @if(session('success_message'))
    @include('layouts.success-message')
    @elseif(session('error_message'))
    @include('layouts.error-message')
    @endif

    <form action="{{ route('admin.create.user') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mt-6 grid gap-y-3">
            <small>رفع صورة</small>
            <input name="profile_image" type="file" class="file-input max-w-sm
            max-md:w-fit" />
            @error('profile_image')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="grid grid-cols-1 mt-6 gap-y-7
        2xl:grid-cols-2
        xl:grid-cols-2">
            <div class="grid gap-y-5">
                <small>الاسم الشخصي <span class="text-error">*</span></small>
                <input type="text" name="name" class="input max-w-sm
                max-md:w-fit" />
                @error('name')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>البريد الإلكتروني <span class="text-error">*</span></small>
                <input name="email" type="text" class="input max-w-sm
                max-md:w-fit" />
                @error('email')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>المنصب</small>
                <input name="position" type="text" class="input max-w-sm
                max-md:w-fit" />
            </div>
            <div class="grid gap-y-5">
                <small>الإدارة</small>
                <input name="department" type="text" class="input max-w-sm
                max-md:w-fit" />
            </div>
            <div class="grid gap-y-5">
                <small>رقم الجوال</small>
                <input name="phone_number" type="number" min="0" class="input max-w-sm
                max-md:w-fit" />
                @error('phone_number')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>كلمة المرور <span class="text-error">*</span></small>
                <input name="password" type="password" class="input max-w-sm
                max-md:w-fit" />
                @error('password')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>تأكيد كلمة المرور <span class="text-error">*</span></small>
                <input name="password_confirmation" type="password" class="input max-w-sm
                max-md:w-fit" />
            </div>
        </div>

        <div class="grid mt-9">
            <h1 class="text-xl font-bold">مواقع التواصل الإجتماعي</h1>
            <div class="grid grid-cols-1 mt-6
            2xl:grid-cols-2
            xl:grid-cols-2">
                <div class="grid gap-y-5">
                    <small>منصة X</small>
                    <input name="x" type="text" class="input max-w-sm
                    max-md:w-fit" />
                    @error('url')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid gap-y-5">
                    <small>لنكد إن</small>
                    <input name="linkedin" type="text" class="input max-w-sm
                    max-md:w-fit" />
                    @error('url')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-[3.8rem] mx-40
        max-md:mx-0
        2xl:mx-96">
            <button type="submit" class="btn btn-wide text-white bg-cyan-600 font-bold text-base">إضافة حساب</button>
        </div>
    </form>
</section>
@endsection