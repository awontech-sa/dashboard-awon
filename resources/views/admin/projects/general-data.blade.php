<form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="grid font-normal text-base my-6 gap-y-5">
        <label for="project-name">اسم المشروع <span class="text-red-600">*</span></label>
        <input type="text" name="project-name" value="{{ old('project-name', $data['p_name'] ?? '') }}" class="input" />
    </div>

    <div class="grid grid-cols-2 gap-x-[3.3rem]">
        <div class="grid gap-y-5">
            <label for="start-project">تاريخ بداية المشروع <span class="text-red-600">*</span></label>
            <input id="start-project" class="input text-center text-base" type="date" name="start-project" value="{{ old('start-project', $data['p_date_start'] ?? '') }}" />
        </div>
        <div class="grid gap-y-5">
            <label for="end-project">تاريخ نهاية المشروع <span class="text-red-600">*</span></label>
            <input id="end-project" class="input text-center text-base" type="date" name="end-project" value="{{ old('end-project', $data['p_date_end'] ?? '') }}" />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
        <div class="grid gap-y-5">
            <label for="project-duration">مدة المشروع</label>
            <input id="project-duration" name="project-duration" value="{{ old('project-duration', $data['p_duration'] ?? '') }}" class="input text-center text-base input-disabled" type="text" readonly />
        </div>
        <div class="grid gap-y-5">
            <label for="remaining-duration">المدة المتبقية</label>
            <input id="remaining-duration" value="{{ old('project-remaining', $data['p_remaining'] ?? '') }}" name="project-remaining" class="input text-center text-base input-disabled" type="text" readonly />
        </div>
    </div>


    <div class="grid font-normal text-base my-6 gap-y-5">
        <label for="project-description">نبذة عن المشروع <span class="text-red-600">*</span> <span class="text-gray-400 text-base font-normal">بحد أقصى 1000 حرف</span></label>
        <textarea name="project-description" id="project_description" class="textarea textarea-lg" oninput="validateTextArea()">{{ old('project-description', $data['p_description'] ?? '') }}</textarea>
        <label class="text-error" for="error" id="error"></label>
    </div>

    <div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
        <div class="grid gap-y-5
        2xl:w-auto">
            <label for="type-benef">نوع المستفيدين من المشروع <span class="text-red-600">*</span></label>
            <select class="select select-bordered w-full" name="type-benef">
                @foreach (App\Enums\TypeBenefEnum::cases() as $status)
                <option value="{{ $status->value }}" {{ old('type-benef', $data['type_benef'] ?? '') == $status->value ? 'selected' : '' }}>{{ $status->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid gap-y-5">
            <label for="benef_number">عدد المستفيدين <span class="text-red-600">*</span></label>
            <input class="input text-center text-base" min="0" type="number" name="benef_number" value="{{ old('benef_number', $data['p_num_beneficiaries'] ?? '') }}" />
        </div>
    </div>

    <div class="join grid grid-cols-2 w-1/4">
        @if($step == 1)
        <button type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
            التالي
        </button>
        @endif
    </div>
</form>

@push('scripts')
<script>
    document.getElementById('start-project').addEventListener('change', calculateDurations);
    document.getElementById('end-project').addEventListener('change', calculateDurations);
    let error = document.getElementById('error')
    let textAreaContent = document.getElementById('project_description')
    let maxChar = 1000

    document.getElementById('myForm').onsubmit = function(e) {
        if (!validateTextArea()) {
            e.preventDefault();
        }

        if (!calculateDurations()) {
            e.preventDefault()
        }
    };

    function calculateDurations() {
        const startDate = new Date(document.getElementById('start-project').value);
        const endDate = new Date(document.getElementById('end-project').value);
        const today = new Date();

        if (!isNaN(startDate) && !isNaN(endDate)) {
            let projectDuration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));

            if (projectDuration < 0) {
                document.getElementById('project-duration').value = 'يجب أن يكون تاريخ النهاية بعد تاريخ البداية المحدد'
                document.getElementById('remaining-duration').value = ''
                return false
            } else if (projectDuration > 0) {
                document.getElementById('project-duration').value = projectDuration + ' يوم';
                const remainingDuration = Math.ceil((endDate - today) / (1000 * 60 * 60 * 24));
                document.getElementById('remaining-duration').value = remainingDuration >= 0 ? remainingDuration + ' يوم' : 'انتهى المشروع';
                return true
            }
        } else {
            document.getElementById('project-duration').value = '';
            document.getElementById('remaining-duration').value = '';
            return false
        }
    }

    function validateTextArea() {
        if (textAreaContent.value.length > maxChar) {
            error.innerHTML = `لا يمكن إدخال أكثر من ${maxChar} حرفًا`;
            return false;
        } else {
            error.innerHTML = '';
            return true;
        }
    }
</script>
@endpush