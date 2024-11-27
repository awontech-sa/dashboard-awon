<section class="mt-14">
    <h1 class="font-bold text-xl">فريق العمل</h1>
    <div class="grid grid-cols-2 gap-x-[3.3rem] my-8 font-normal">
        <div class="grid gap-y-5">
            <label>مدير المشروع</label>
            <input class="input" type="text" disabled placeholder="{{ $bigBoss->project_manager ?? '' }}" />
        </div>
        <div class="grid gap-y-5">
            <label>نائب مدير المشروع</label>
            <input class="input" type="text" disabled placeholder="{{ $bigBoss->sub_project_manager ?? '' }}" />
        </div>
    </div>

    <div class="my-8">
        <p>أعضاء فريق العمل</p>
        <div class="grid grid-cols-2 gap-x-[3.3rem] my-8 font-normal">
            @foreach($team as $member)
            @if($member['role'] !== null)
            <div class="grid gap-y-5 my-4">
                <label>اسم العضو</label>
                <input class="input" type="text" disabled placeholder="{{ $member['name'] ?? '' }}" />
            </div>
            <div class="grid gap-y-5">
                <label>الدور</label>
                <input class="input" type="text" disabled placeholder="{{ $member['role'] ?? '' }}" />
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>