<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="start-project">لغة البرمجة</label>
        <input value="{{ old('program-language', $data['program_language'] ?? '') }}" class="input text-center text-base" type="text" name="program-language" />
    </div>
    <div class="grid gap-y-5">
        <label for="end-project">إطار البرمجة</label>
        <input value="{{ old('framework', $data['framework'] ?? '') }}" class="input text-center text-base" type="text" name="framework" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="github">رابط GitHub</label>
        <input id="github" value="{{ old('github', $data['github'] ?? '') }}" name="github" class="input text-center text-base" type="text" placeholder="" />
    </div>
    <div class="grid gap-y-5">
        <label for="link">رابط الموقع</label>
        <input id="link" value="{{ old('link', $data['link'] ?? '') }}" name="link" class="input text-center text-base" type="text" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="ios">رابط التطبيق على IOS</label>
        <input id="ios" value="{{ old('ios', $data['ios'] ?? '') }}" class="input text-center text-base" type="text" name="ios" />
    </div>
    <div class="grid gap-y-5">
        <label for="android">رابط التطبيق على Android</label>
        <input id="android" value="{{ old('android', $data['android'] ?? '') }}" class="input text-center text-base" type="text" name="android" />
    </div>
</div>

<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="dashboard">رابط لوحة التحكم</label>
    <input type="text" value="{{ old('dashboard', $data['dashboard'] ?? '') }}" name="dashboard" class="input" />
</div>