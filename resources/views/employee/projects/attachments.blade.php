<form action="{{ route('employee.create.project', ['step' => $step]) }}" id="attachmentForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex justify-between">
        <h1 class="font-bold text-xl">مرفقات</h1>
        <a href="#my_modal_8" class="font-['Tajawal'] btn btn-sm bg-white shadow-none font-normal text-base mr-32 mb-5">إضافة مرفق جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>
    </div>
    <div id="attachment-files"></div>

    <div class="modal" role="dialog" id="my_modal_8">
        <div class="modal-box">
            <div class="modal-action justify-center">
                <div class="grid">
                    <h3 class="text-2xl font-bold">إضافة مرفق</h3>
                    <div class="grid mt-20 gap-y-5">
                        <label for="project-name">اسم المرفق <span class="text-error">*</span></label>
                        <input type="text" class="input border" name="attachment-name" id="attachment_name" />
                    </div>
                    <a href="#" type="button" class="btn btn-wide mt-28 bg-cyan-700 text-white font-bold text-base" onclick="addAttachment()">إضافة</a>
                </div>
            </div>
        </div>
    </div>
    <div class="join grid grid-cols-2 w-1/4 float-left">
        @if($step == 3 && $step < 8)
            <a type="submit" href="{{ route('employee.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
            hover:bg-cyan-700/30 hover:text-cyan-700">
            السابق
            </a>
            <button type="submit" href="{{ route('employee.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                التالي
            </button>
            @endif
    </div>
</form>

@push('scripts')
<script>
    let attachments = document.getElementById('attachment-files');
    let attachmentName = document.getElementById('attachment_name');

    document.getElementById('attachmentForm').onsubmit = function(e) {
        if (!fileExist()) {
            e.preventDefault();
        }
    };

    function addAttachment() {
        let nameValue = attachmentName.value.trim();
        if (!nameValue) {
            alert('يجب إدخال اسم المرفق!');
            return;
        }

        let fileContainer = document.createElement('div');
        fileContainer.classList.add('my-8', 'grid', 'gap-y-5');

        let fileLabel = document.createElement('label');
        fileLabel.classList.add('text-base', 'font-normal');
        fileLabel.textContent = nameValue;
        fileContainer.appendChild(fileLabel);

        let fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.classList.add('input', 'file-input');
        fileInput.name = 'attachment-file[]';
        fileContainer.appendChild(fileInput);

        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'file-name[]';
        hiddenInput.value = nameValue; // Set the name of the file
        fileContainer.appendChild(hiddenInput);

        let fileError = document.createElement('label');
        fileError.classList.add('text-error', 'errorLabel');
        fileError.name = 'fileError';
        fileContainer.appendChild(fileError);

        attachments.appendChild(fileContainer);

        attachmentName.value = '';
    }

    function fileExist() {
        let fileInputs = document.querySelectorAll('input[name="attachment-file[]"]');
        for (let i = 0; i < fileInputs.length; i++) {
            if (fileInputs[i].value === '') {
                document.querySelectorAll('.errorLabel')[i].textContent = 'الرجاء إرفاق ملف';
                return false;
            }
        }
        document.querySelectorAll('.errorLabel').forEach(label => (label.textContent = ''));
        return true;
    }
</script>
@endpush