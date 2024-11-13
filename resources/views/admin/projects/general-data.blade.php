<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="project-name">اسم المشروع <span class="text-red-600">*</span></label>
    <input type="text" name="project-name" value="{{ old('project-name', $data['project-name'] ?? '') }}" class="input" />
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="start-project">تاريخ بداية المشروع <span class="text-red-600">*</span></label>
        <input id="start-project" class="input text-center text-base" value="{{ old('start-project', $data['start-project'] ?? '') }}" type="date" name="start-project" />
    </div>
    <div class="grid gap-y-5">
        <label for="end-project">تاريخ نهاية المشروع <span class="text-red-600">*</span></label>
        <input id="end-project" value="{{ old('end-project', $data['end-project'] ?? '') }}" class="input text-center text-base" type="date" name="end-project" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="project-duration">مدة المشروع</label>
        <input id="project-duration" name="project-duration" value="{{ old('project-duration', $data['project-duration'] ?? '') }}" class="input text-center text-base input-disabled" type="text" placeholder="" />
    </div>
    <div class="grid gap-y-5">
        <label for="remaining-duration">المدة المتبقية</label>
        <input id="remaining-duration" name="project-remaining" class="input text-center text-base input-disabled" type="text" value="{{ old('project-remaining', $data['project-remaining'] ?? '') }}" />
    </div>
</div>


<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="project-desription">نبذة عن المشروع <span class="text-red-600">*</span> <span class="text-gray-400 text-base font-normal">بحد أقصى 1000 حرف</span></label>
    <textarea name="project-desription" class="textarea textarea-lg" value="{{ old('project-description', $data['project-description'] ?? '') }}"></textarea>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="type-benef">نوع المستفيدين من المشروع <span class="text-red-600">*</span></label>
        <select class="select select-bordered w-full max-w-xs" name="type-benef" value="{{ old('type-benef', $data['type-benef'] ?? '') }}">
            @foreach($typeBenef as $tp)
            <option id="{{ $tp->id }}">{{ $tp->tb_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid gap-y-5">
        <label for="benef_number">عدد المستفيدين <span class="text-red-600">*</span></label>
        <input class="input text-center text-base" type="number" name="benef_number" value="{{ old('benef_number', $data['benef_number'] ?? '') }}" />
    </div>
</div>

<script>
    document.getElementById('start-project').addEventListener('change', calculateDurations);
    document.getElementById('end-project').addEventListener('change', calculateDurations);

    function calculateDurations() {
        const startDate = new Date(document.getElementById('start-project').value);
        const endDate = new Date(document.getElementById('end-project').value);
        const today = new Date();

        if (!isNaN(startDate) && !isNaN(endDate)) {
            const projectDuration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            document.getElementById('project-duration').value = projectDuration + ' يوم';

            const remainingDuration = Math.ceil((endDate - today) / (1000 * 60 * 60 * 24));
            document.getElementById('remaining-duration').value = remainingDuration >= 0 ? remainingDuration + ' يوم' : 'انتهى المشروع';
        } else {
            document.getElementById('project-duration').value = '';
            document.getElementById('remaining-duration').value = '';
        }
    }
</script>