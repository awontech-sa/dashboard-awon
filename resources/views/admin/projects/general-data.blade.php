<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="project-name">اسم المشروع <span class="text-red-600">*</span></label>
    <input type="text" name="project-name" class="input" />
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem]">
    <div class="grid gap-y-5">
        <label for="start-project">تاريخ بداية المشروع <span class="text-red-600">*</span></label>
        <input id="start-project" class="input text-center text-base" type="date" name="start-project" />
    </div>
    <div class="grid gap-y-5">
        <label for="end-project">تاريخ نهاية المشروع <span class="text-red-600">*</span></label>
        <input id="end-project" class="input text-center text-base" type="date" name="end-project" />
    </div>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="project-duration">مدة المشروع</label>
        <input id="project-duration" name="project-duration" class="input text-center text-base input-disabled" type="text" readonly />
    </div>
    <div class="grid gap-y-5">
        <label for="remaining-duration">المدة المتبقية</label>
        <input id="remaining-duration" name="project-remaining" class="input text-center text-base input-disabled" type="text" readonly />
    </div>
</div>


<div class="grid font-normal text-base my-6 gap-y-5">
    <label for="project-description">نبذة عن المشروع <span class="text-red-600">*</span> <span class="text-gray-400 text-base font-normal">بحد أقصى 1000 حرف</span></label>
    <textarea name="project-description" id="project_description" class="textarea textarea-lg" oninput="validateTextArea()"></textarea>
    <label class="text-error" for="error" id="error"></label>
</div>

<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="type-benef">نوع المستفيدين من المشروع <span class="text-red-600">*</span></label>
        <select class="select select-bordered w-full max-w-xs" name="type-benef">
            @foreach (App\Enums\TypeBenefEnum::cases() as $status)
            <option id="{{ $status->value }}">{{ $status->value }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid gap-y-5">
        <label for="benef_number">عدد المستفيدين <span class="text-red-600">*</span></label>
        <input class="input text-center text-base" type="number" name="benef_number" />
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('start-project').addEventListener('change', calculateDurations);
    document.getElementById('end-project').addEventListener('change', calculateDurations);
    let error = document.getElementById('error')
    let textAreaContent = document.getElementById('project_description')
    let maxChar = 1000

    function calculateDurations() {
        const startDate = new Date(document.getElementById('start-project').value);
        const endDate = new Date(document.getElementById('end-project').value);
        const today = new Date();

        if (!isNaN(startDate) && !isNaN(endDate)) {
            let projectDuration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));

            if (projectDuration < 0) {
                document.getElementById('project-duration').value = 'يجب أن يكون تاريخ النهاية بعد تاريخ البداية المحدد'
                document.getElementById('remaining-duration').value = ''
            } else if (projectDuration > 0) {
                document.getElementById('project-duration').value = projectDuration + ' يوم';
                const remainingDuration = Math.ceil((endDate - today) / (1000 * 60 * 60 * 24));
                document.getElementById('remaining-duration').value = remainingDuration >= 0 ? remainingDuration + ' يوم' : 'انتهى المشروع';
            }
        } else {
            document.getElementById('project-duration').value = '';
            document.getElementById('remaining-duration').value = '';
        }
    }

    function validateTextArea() {
        (textAreaContent.value.length > maxChar) ? error.innerHTML = `لا يمكن إدخال أكثر من ${maxChar} حرفًا`: error.innerHTML = ''
    }
</script>
@endpush