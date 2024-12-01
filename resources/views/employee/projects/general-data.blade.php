<form action="{{ route('employee.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="grid font-normal text-base my-6 gap-y-5">
        <label for="project-name">اسم المشروع</label>
        <input type="text" name="project-name" class="input" />
    </div>

    <div class="grid grid-cols-2 gap-x-[3.3rem]">
        <div class="grid gap-y-5">
            <label for="start-project">تاريخ بداية المشروع</label>
            <input id="start-project" class="input text-center text-base" type="date" name="start-project" />
        </div>
        <div class="grid gap-y-5">
            <label for="end-project">تاريخ نهاية المشروع</label>
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
        <label for="project-description">نبذة عن المشروع <span class="text-gray-400 text-base font-normal">بحد أقصى 1000 حرف</span></label>
        <textarea name="project-description" id="project_description" class="textarea textarea-lg" oninput="validateTextArea()"></textarea>
        <label class="text-error" for="error" id="error"></label>
    </div>

    <div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
        <div class="grid gap-y-5
        2xl:w-auto">
            <label for="type-benef">نوع المستفيدين من المشروع</label>
            <select class="select select-bordered w-full" name="type-benef">
                @foreach (App\Enums\TypeBenefEnum::cases() as $status)
                <option>{{ $status->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid gap-y-5">
            <label for="benef_number">عدد المستفيدين</label>
            <input class="input text-center text-base" min="0" type="number" name="benef_number" />
        </div>
    </div>

    <div class="join grid float-left w-1/4">
        @if($step == 1)
        <button type="submit" href="{{ route('employee.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
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