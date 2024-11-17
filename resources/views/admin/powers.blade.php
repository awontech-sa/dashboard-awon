@extends('layouts.admin-sidebar')

@section('admin-content')
<section class="font-['Tajawal'] mx-[3.8rem]
max-md:mx-6">
    <h1 class="font-bold text-xl">الصلاحيات</h1>

    <div class="grid my-[3.2rem] grid-cols-1 gap-y-[3.2rem]
    md:mx-20
    2xl:w-fit 2xl:mx-auto 2xl:gap-x-16 2xl:grid-cols-2
    xl:grid-cols-2">
        @foreach($sections as $section)
        <div class="grid gap-y-5">
            <small class="font-medium text-xl">{{ $section->ps_name }}</small>
            <div class="bg-white w-fit h-24 rounded-xl border flex">
                @foreach (App\Enums\PermissionsEnum::cases() as $status)
                <div class="form-control my-auto mx-2">
                    <label class="cursor-pointer label flex items-center gap-x-5">
                        <input
                            onchange="updatePermission(this, '{{ $id }}', '{{ $section->id }}', '{{ $status->value }}')"
                            type="checkbox"
                            class="checkbox checkbox-lg border [--chkbg:theme(colors.cyan.500)] [--chkfg:white]
                            max-md:checkbox-xs"
                        />
                        <span class="label-text">{{ $status->value }}</span>
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection

<script>
    function updatePermission(checkbox, userId, sectionId, permission) {
        const action = checkbox.checked ? 'add' : 'remove'; // Determine action

        // Prepare data for the request
        const data = {
            user_id: userId,
            section_id: sectionId,
            permission: permission,
            action: action
        };

        fetch("{{ route('admin.powers.update', $id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });
    }
</script>