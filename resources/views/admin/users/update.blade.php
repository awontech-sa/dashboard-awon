@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] m-[5.7rem]">
    <h1 class="font-bold text-xl">البيانات الشخصية</h1>

    @if(session('success_message'))
    @include('layouts.success-message')
    @elseif(session('error_message'))
    @include('layouts.error-message')
    @endif

    <form action="{{ route('admin.update.user', $id) }}" class="relative z-0" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="my-6 grid gap-y-3">
            <input value="{{ $user["p_image"] }}" name="profile-image" type="file" class="file-input rounded-full w-20 h-20
            max-md:file-input-sm" />
            <small class="mx-3">رفع صورة</small>
            @error('profile_image')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="grid grid-cols-1 mt-6 gap-y-7
        2xl:grid-cols-2
        xl:grid-cols-2 xl:gap-x-4">
            <div class="grid gap-y-5">
                <small>الاسم الشخصي <span class="text-error">*</span></small>
                <input value="{{ $user["name"] }}" name="name" type="text" placeholder="{{ $user["name"] }}" class="input w-full" />
                @error('name')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>البريد الإلكتروني <span class="text-error">*</span></small>
                <input value="{{ $user["email"] }}" name="email" type="text" placeholder="{{ $user["email"] }}" class="input w-full" />
                @error('email')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>المنصب</small>
                <input value="{{ $position }}" name="position" type="text" placeholder="{{ $position }}" class="input w-full" />
            </div>
            <div class="grid gap-y-5">
                <small>رقم الجوال</small>
                <input value="{{ $user["phone_number"] }}" name="phone-number" type="text" placeholder="{{ $user["phone_number"] }}" class="input w-full" />
                @error('phone_number')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>كلمة المرور</small>
                <input name="password" type="password" class="input w-full" />
                @error('password')
                <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid gap-y-5">
                <small>تأكيد كلمة المرور</small>
                <input name="password_confirmation" type="password" class="input w-full" />
            </div>
        </div>

        <div class="grid mt-9">
            <h1 class="text-xl font-bold">مواقع التواصل الإجتماعي</h1>
            <div class="grid grid-cols-1 mt-6 gap-y-7
            2xl:grid-cols-2
            xl:grid-cols-2 xl:gap-x-4">
                <div class="grid gap-y-5">
                    <small>منصة X</small>
                    <input value="{{ $user["x"] }}" name="x" type="text" placeholder="{{ $user["x"] }}" class="input w-full" />
                    @error('url')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid gap-y-5">
                    <small>لنكد إن</small>
                    <input value="{{ $user["linkedin"] }}" name="linkedin" type="text" placeholder="{{ $user["linkedin"] }}" class="input w-full" />
                    @error('url')
                    <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-[3.8rem] mx-40
        max-md:mx-0
        2xl:mx-[40rem]
        xl:mx-80">
            <button type="submit" class="btn btn-wide text-white bg-cyan-700 font-bold text-base">تحديث البيانات</button>
        </div>
    </form>
</section>
@endsection