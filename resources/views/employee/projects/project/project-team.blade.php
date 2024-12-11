<section class="mt-14">
    <h1 class="font-bold text-xl">فريق العمل</h1>
    <div class="grid grid-cols-2 gap-x-[3.3rem] my-8 font-normal">
        <div class="grid gap-y-5">
            @php
            $manager = $team->firstWhere('role', 'manager');
            $subManager = $team->firstWhere('role', 'sub manager');
            $filteredTeam = $team->reject(function ($member) {
            return in_array($member['role'], ['manager', 'sub manager']);
            });
            @endphp
            <label class="text-base">مدير المشروع</label>
            <input class="input" type="text" disabled placeholder="{{ $manager['name'] ?? '' }}" />
        </div>
        <div class="grid gap-y-5">
            <label class="text-base">نائب مدير المشروع</label>
            <input class="input" type="text" disabled placeholder="{{ $subManager['name'] ?? '' }}" />
        </div>
    </div>

    <div class="my-8">
        <p>أعضاء فريق العمل</p>
        <div class="grid grid-cols-2 gap-x-[3.3rem] my-8 font-normal">
            @foreach($filteredTeam as $member)
            @if($member['role'] !== null)
            <div class="grid gap-y-5 my-4">
                <label class="text-base">اسم العضو</label>
                <input class="input" type="text" disabled placeholder="{{ $member['name'] ?? '' }}" />
            </div>
            <div class="grid gap-y-5">
                <label class="text-base">الدور</label>
                <input class="input" type="text" disabled placeholder="{{ $member['role'] ?? '' }}" />
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>