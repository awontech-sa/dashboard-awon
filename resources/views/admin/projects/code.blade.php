<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="start-project">لغة البرمجة</label>
        <input id="start-project" class="input text-center text-base" value="{{ old('start-project', $data['start-project'] ?? '') }}" type="date" name="start-project" />
    </div>
    <div class="grid gap-y-5">
        <label for="end-project">إطار البرمجة</label>
        <input id="end-project" value="{{ old('end-project', $data['end-project'] ?? '') }}" class="input text-center text-base" type="date" name="end-project" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="project-duration">رابط GitHub</label>
        <input id="project-duration" name="project-duration" value="{{ old('project-duration', $data['project-duration'] ?? '') }}" class="input text-center text-base input-disabled" type="text" placeholder="" />
    </div>
    <div class="grid gap-y-5">
        <label for="remaining-duration">رابط الموقع</label>
        <input id="remaining-duration" name="project-remaining" class="input text-center text-base input-disabled" type="text" value="{{ old('project-remaining', $data['project-remaining'] ?? '') }}" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="start-project">رابط التطبيق على IOS</label>
        <input id="start-project" class="input text-center text-base" value="{{ old('start-project', $data['start-project'] ?? '') }}" type="date" name="start-project" />
    </div>
    <div class="grid gap-y-5">
        <label for="end-project">رابط التطبيق على Android</label>
        <input id="end-project" value="{{ old('end-project', $data['end-project'] ?? '') }}" class="input text-center text-base" type="date" name="end-project" />
    </div>
</div>

<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="project-name">رابط لوحة التحكم</label>
    <input type="text" name="project-name" value="{{ old('project-name', $data['project-name'] ?? '') }}" class="input" />
</div>