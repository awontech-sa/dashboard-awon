@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] mx-[3.8rem]">
    <h1 class="font-bold text-xl">الصلاحيات</h1>

    <div class="grid grid-cols-2 gap-x-12 gap-y-[3.2rem] my-[3.2rem]">
        @foreach($userPermissions as $value)
        <form action="{{ route('admin.powers.update', $id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hidden fields to pass the section ID and user ID -->
            <input type="hidden" name="user_id" value="{{ $id }}">
            <input type="hidden" name="section_id" value="{{ $value['section_id'] }}"> <!-- Assuming section_id is in your data -->

            <small class="font-medium text-xl">{{ $value['section'] }}</small>
            <div class="bg-white h-24 flex mt-5">
                <div role="tablist" class="tabs items-center">
                    <input
                        type="radio"
                        {{ $value['permission'] == "مشاهدة" ? "checked" : "" }}
                        name="permission"
                        value="مشاهدة"
                        class="tab mx-2 tab-power font-normal text-base"
                        onchange="this.form.submit();"
                        aria-label="مشاهدة" />
                </div>
                <div role="tablist" class="tabs items-center">
                    <input
                        type="radio"
                        {{ $value['permission'] == "تعديل" ? "checked" : "" }}
                        name="permission"
                        value="تعديل"
                        class="tab mx-2 tab-power font-normal text-base"
                        onchange="this.form.submit();"
                        aria-label="تعديل" />
                </div>
                <div role="tablist" class="tabs items-center">
                    <input
                        type="radio"
                        {{ $value['permission'] == "حذف" ? "checked" : "" }}
                        name="permission"
                        onchange="this.form.submit();"
                        value="حذف"
                        class="tab mx-2 tab-power font-normal text-base"
                        aria-label="حذف" />
                </div>
            </div>
        </form>
        @endforeach
        @include('layouts.list-tech-projects', ['projects' => $projects, 'id' => $id])
        @include('layouts.list-resource-dev', ['projects' => $projects, 'id' => $id])
    </div>
</section>
@endsection