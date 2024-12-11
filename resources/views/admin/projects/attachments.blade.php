<form action="{{ route('admin.create.project', ['step' => $step]) }}" id="attachmentForm" method="POST" enctype="multipart/form-data">
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
                    <h3 class="text-2xl font-bold text-center">إضافة مرفق</h3>
                    <div class="grid mt-20 gap-y-2">
                        <label for="project-name">اسم المرفق <span class="text-error">*</span></label>
                        <input type="text" class="input border" name="attachment-name" id="attachment_name" />
                    </div>
                    <div class="grid mt-20 gap-y-2">
                        <label for="project-name">إذا كان المرفق ملف</label>
                        <input type="file" class="input file-input border" name="attachment-file[]" id="attachment_file" />
                    </div>
                    <div class="grid mt-20 gap-y-2">
                        <label for="project-name">إذا كان المرفق رابط</label>
                        <input type="text" class="input border" name="attachment-link[]" id="attachment_link" />
                    </div>
                    <a href="#" type="button" class="btn btn-wide mt-28 bg-cyan-700 text-white font-bold text-base mx-auto" onclick="addAttachment()">إضافة</a>
                </div>
            </div>
        </div>
    </div>
    <div class="join grid grid-cols-2 w-1/4 float-left">
        @if($step == 3 && $step < 8)
            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
            hover:bg-cyan-700/30 hover:text-cyan-700">
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
    let attachmentLink = document.getElementById('attachment_link')
    let attachmentFile = document.getElementById('attachment_file')

    function addAttachment() {
        let nameValue = attachmentName.value.trim();
        let link = attachmentLink.value.trim();
        let file = attachmentFile.files[0]; // Use files array for file input

        if (!nameValue) {
            alert('يجب إدخال اسم المرفق!');
            return;
        }

        if (!link && !file) {
            alert('يجب إدخال ملف أو رابط للمرفق!');
            return;
        }

        let container = document.createElement('div');
        container.classList.add('w-auto', 'h-[4.1rem]', 'bg-white', 'rounded', 'flex', 'justify-between', 'mb-4');

        let leftSection = document.createElement('div');
        leftSection.classList.add('flex', 'gap-x-5', 'p-4', 'items-center');

        let paragraph = document.createElement('p');
        paragraph.classList.add('font-normal', 'text-base');
        paragraph.textContent = nameValue;

        leftSection.appendChild(paragraph);
        container.appendChild(leftSection);

        let anchor = document.createElement('a');
        anchor.classList.add('btn', 'm-2', 'btn-md', 'bg-[#FBFDFE]', 'rounded-md', 'border-[#0F91D2]', 'text-[#0F91D2]');
        anchor.href = link || '#'; // Use '#' if no link is provided
        anchor.download = '';
        anchor.textContent = 'عرض';
        container.appendChild(anchor);

        // Hidden input for file name
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'attachment-name[]';
        hiddenInput.value = nameValue;
        container.appendChild(hiddenInput);

        // Hidden input for link
        if (link) {
            let linkInput = document.createElement('input');
            linkInput.type = 'hidden';
            linkInput.name = 'attachment-link[]';
            linkInput.value = link;
            container.appendChild(linkInput);
        }

        // Append the container to the attachments section
        attachments.appendChild(container);

        // Clear inputs
        attachmentName.value = '';
        attachmentLink.value = '';
        attachmentFile.value = '';
    }
</script>
@endpush