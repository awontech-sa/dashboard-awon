<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="start-project">لغة البرمجة</label>
        <input value="{{ $project->details->program_language ?? '' }}" class="input text-center text-base" type="text" name="program-language" />
    </div>
    <div class="grid gap-y-5">
        <label for="end-project">إطار البرمجة</label>
        <input value="{{ $project->details->framework ?? '' }}" class="input text-center text-base" type="text" name="framework" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="github">رابط GitHub</label>
        <input id="github" value="{{ $project->details->github ?? '' }}" name="github" class="input text-center text-base" type="text" placeholder="" />
    </div>
    <div class="grid gap-y-5">
        <label for="link">رابط الموقع</label>
        <input id="link" value="{{ $project->details->link ?? '' }}" name="link" class="input text-center text-base" type="text" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="ios">رابط التطبيق على IOS</label>
        <input id="ios" value="{{ $project->details->ios ?? '' }}" class="input text-center text-base" type="text" name="ios" />
    </div>
    <div class="grid gap-y-5">
        <label for="android">رابط التطبيق على Android</label>
        <input id="android" value="{{ $project->details->android ?? '' }}" class="input text-center text-base" type="text" name="android" />
    </div>
</div>

<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="dashboard">رابط لوحة التحكم</label>
    <input type="text" value="{{ $project->details->dashboard ?? '' }}" name="dashboard" class="input" />
</div>