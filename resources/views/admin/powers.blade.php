@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] mx-[3.8rem]">
    <h1 class="font-bold text-xl">الصلاحيات</h1>

    <div class="grid grid-cols-2 my-[3.2rem]">
        <div class="grid">
            <small class="font-medium text-xl">الحسابات</small>
            <div class="bg-white w-[30.9rem] h-24 flex">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">مشاهدة</span>
                        <input type="checkbox" checked="checked" class="checkbox" />
                    </label>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection