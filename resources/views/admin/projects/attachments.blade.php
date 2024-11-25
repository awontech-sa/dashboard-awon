<form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex justify-between">
        <h1 class="font-bold text-xl">مرفقات</h1>
        <a href="#my_modal_8" class="font-['Tajawal'] btn btn-sm bg-white shadow-none font-normal text-base mr-32 mb-5">إضافة مرفق جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>
    </div>
    <div id="attachment-files"></div>
    <input type="hidden" name="file-name[]">

    <div class="modal" role="dialog" id="my_modal_8">
        <div class="modal-box">
            <div class="modal-action">
                <a href="#" class="btn btn-circle">X</a>
            </div>
            <div class="grid place-items-center">
                <h3 class="text-2xl font-bold">إضافة مرفق</h3>
                <div class="grid mt-20 gap-y-5">
                    <label for="project-name">اسم المرفق <span class="text-red-600">*</span></label>
                    <input type="text" class="input border" name="attachment-name" id="attachment_name" />
                </div>
                <button type="button" class="btn btn-wide mt-28 bg-cyan-700 text-white font-bold text-base" onclick="addAttachment()">إضافة</button>
            </div>
        </div>
    </div>
    <div class="join grid grid-cols-2 w-1/4">
        @if($step == 3 && $step < 8)
            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
            السابق
            </a>
            <button type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                التالي
            </button>
            @endif
    </div>
</form>

@push('scripts')
<script>
    let attachments = document.getElementById('attachment-files');
    let attachmentName = document.getElementById('attachment_name');
    let arrayFileContainer = []

    function addAttachment() {
        let fileContainer = document.createElement('div')
        fileContainer.classList.add('my-8', 'grid', 'gap-y-5')

        let fileLabel = document.createElement('label')
        fileLabel.classList.add('text-base', 'font-normal')
        fileLabel.textContent = `${attachmentName.value}`
        fileContainer.appendChild(fileLabel)

        let fileInput = document.createElement('input')
        fileInput.type = 'file'
        fileInput.classList.add('input', 'file-input')
        fileInput.id = 'attachment_file'
        fileInput.name = 'attachment-file[]'
        fileContainer.appendChild(fileInput)

        attachments.appendChild(fileContainer)

        document.querySelector('input[name="file-name[]"]').value = fileContainer.querySelector('label').textContent;

        attachmentName.value = ''
    }
</script>
@endpush