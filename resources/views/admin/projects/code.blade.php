<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="start-project">لغة البرمجة</label>
        <input id="start-project" class="input text-center text-base" value="{{ old('program-language', $data['program_language'] ?? '') }}" type="text" name="program-language" />
    </div>
    <div class="grid gap-y-5">
        <label for="end-project">إطار البرمجة</label>
        <input id="end-project" value="{{ old('framework', $data['framework'] ?? '') }}" class="input text-center text-base" type="text" name="framework" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="github">رابط GitHub</label>
        <input id="github" name="github" value="{{ old('github', $data['github'] ?? '') }}" class="input text-center text-base" type="text" placeholder="" />
    </div>
    <div class="grid gap-y-5">
        <label for="link">رابط الموقع</label>
        <input id="link" name="link" class="input text-center text-base" type="text" value="{{ old('link', $data['link'] ?? '') }}" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="ios">رابط التطبيق على IOS</label>
        <input id="ios" class="input text-center text-base" value="{{ old('ios', $data['ios'] ?? '') }}" type="text" name="ios" />
    </div>
    <div class="grid gap-y-5">
        <label for="android">رابط التطبيق على Android</label>
        <input id="android" value="{{ old('android', $data['android'] ?? '') }}" class="input text-center text-base" type="text" name="android" />
    </div>
</div>

<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="dashboard">رابط لوحة التحكم</label>
    <input type="text" name="dashboard" value="{{ old('dashboard', $data['dashboard'] ?? '') }}" class="input" />
</div>