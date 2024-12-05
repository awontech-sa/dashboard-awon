@extends('layouts.employee-sidebar')

@section('employee-content')
<section class="font-['Tajawal'] m-[5.7rem]">
    <h1 class="font-bold text-xl">البيانات الشخصية</h1>

    @if(session('success_message'))
    @include('layouts.success-message')
    @elseif(session('error_message'))
    @include('layouts.error-message')
    @endif

    <form action="{{ route('employee.setting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mt-6 grid gap-y-3">
            <small>رفع صورة</small>
            <input value="{{ $employee->profile_image }}" name="profile_image" type="file" class="file-input w-auto
            desktop:max-w-[30rem]" />
            @error('profile_image')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="grid grid-cols-1 mt-6 gap-y-7
        desktop:grid-cols-2
        laptop:grid-cols-2 laptop:gap-x-4">
            <div class="grid gap-y-5">
                <small>الاسم الشخصي <span class="text-error">*</span></small>
                <input value="{{ $employee->name }}" name="name" type="text" placeholder="{{ $employee->name }}" class="input w-auto
                desktop:max-w-[30rem]" />
                @error('name')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>البريد الإلكتروني <span class="text-error">*</span></small>
                <input value="{{ $employee->email }}" name="email" type="text" placeholder="{{ $employee->email }}" class="input w-auto
                desktop:max-w-[30rem]" />
                @error('email')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>المنصب</small>
                <input value="{{ $position }}" name="position" type="text" placeholder="{{ $position }}" class="input w-auto
                desktop:max-w-[30rem]" />
            </div>
            <div class="grid gap-y-5">
                <small>رقم الجوال</small>
                <input value="{{ $employee->phone_number }}" name="phone_number" type="text" placeholder="{{ $employee->phone_number }}" class="input w-auto
                desktop:max-w-[30rem]" />
                @error('phone_number')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>كلمة المرور</small>
                <input name="password" type="password" class="input w-auto
                desktop:max-w-[30rem]" />
                @error('password')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>تأكيد كلمة المرور</small>
                <input name="password_confirmation" type="password" class="input w-auto
                desktop:max-w-[30rem]" />
            </div>
        </div>

        <div class="grid mt-9">
            <h1 class="text-xl font-bold">مواقع التواصل الإجتماعي</h1>
            <div class="grid grid-cols-1 mt-6
            laptop:grid-cols-2 laptop:gap-x-4
            desktop:grid-cols-2">
                <div class="grid gap-y-5">
                    <small>منصة X</small>
                    <input value="{{ $employee->x }}" name="x" type="text" placeholder="{{ $employee->x }}" class="input w-auto
                    desktop:max-w-[30rem]" />
                    @error('url')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid gap-y-5">
                    <small>لنكد إن</small>
                    <input value="{{ $employee->linkedin }}" name="linkedin" type="text" placeholder="{{ $employee->linkedin }}" class="input w-auto
                    desktop:max-w-[30rem]" />
                    @error('url')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-[3.8rem]
        laptop:mx-72
        desktop:mx-[26rem]">
            <button type="submit" class="btn btn-sm text-white bg-cyan-600 font-bold text-base
            laptop:btn-wide laptop:btn laptop:bg-cyan-600
            desktop:btn-wide desktop:btn desktop:bg-cyan-600">تحديث البيانات</button>
        </div>
    </form>
</section>
@endsection