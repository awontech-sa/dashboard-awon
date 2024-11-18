<div class="flex justify-between">
    <label for="project-name">اختر مراحل المشروع المناسبة <span class="text-red-600">*</span></label>
    <a href="#my_modal_8" class="font-['Tajawal'] btn btn-sm bg-white shadow-none font-normal text-base mr-32 mb-5">إضافة مشروع جديد <x-fas-plus class="w-4 h-4 text-gray-600" /></a>
</div>
<div class="grid gap-y-7 top-list stage-checkbox">
    @foreach($stages as $stage)
    <div class="form-control">
        <label class="label cursor-pointer">
            <span class="label-text">{{ $stage->stage_name }}</span>
            <input type="checkbox" value="{{ $stage->id }}" name="stages" class="checkbox border-gray-500 [--chkbg:theme(colors.cyan.600)] [--chkfg:white] stage-checked" />
        </label>
    </div>
    @endforeach
</div>
<div class="my-8">
    <label for="project-name">اختر مراحل المشروع المنجزة <span class="text-red-600">*</span></label>
    <div class="mt-8 grid gap-y-7 bottom-list stages-done"></div>
</div>

<div class="modal" role="dialog" id="my_modal_8">
    <div class="modal-box">
        <div class="modal-action">
            <a href="#" class="btn btn-circle">X</a>
        </div>
        <div class="grid place-items-center">
            <form action="{{ route('admin.create.project', 5) }}" method="POST" id="stage-form">
                @csrf
                <h3 class="text-2xl font-bold">إضافة مرحلة</h3>
                <div class="grid mt-20 gap-y-5">
                    <label for="project-name">اسم المرحلة <span class="text-red-600">*</span></label>
                    <input type="text" class="input border" name="stage-name" id="" />
                </div>
                <div class="grid gap-y-5 mt-7">
                    <label for="project-name">ترتيب المرحلة <span class="text-red-600">*</span></label>
                    <input type="number" class="input border" name="stage-order" id="" />
                </div>

                <button type="submit" class="btn btn-wide mt-28 bg-cyan-700 text-white font-bold text-base">إضافة</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let stagesDoneData = document.querySelector('.stages-done');
    let checkedStages = []; // Array to keep track of checked stages

    document.addEventListener('change', (e) => {
        if (e.target.checked === true) {
            checkedStages.push(e.target.value)
        } else {
            checkedStages = checkedStages.filter(stage => stage !== e.target.value);
            // checkedStages.pop(e.target.value);
        }

        stagesDoneData.innerHTML = '';
        checkedStages.forEach(stage => {
            // Create the container div for each checked stage
            let stageDiv = document.createElement('div');
            stageDiv.classList.add('form-control');

            // Create the label and checkbox elements
            let label = document.createElement('label');
            label.classList.add('label', 'cursor-pointer');

            let span = document.createElement('span');
            span.classList.add('label-text');
            span.textContent = stage;

            let checkbox = document.createElement('input');
            checkbox.disabled = true;
            checkbox.type = 'checkbox';
            checkbox.value = stage;
            checkbox.name = 'stages';
            checkbox.checked = true;
            checkbox.classList.add('checkbox', 'border-gray-500', '[--chkbg:theme(colors.cyan.600)]', '[--chkfg:white]', 'stage-checked');

            // Append the elements to the label and div
            label.appendChild(span);
            label.appendChild(checkbox);
            stageDiv.appendChild(label);

            // Append the div to stagesDoneData
            stagesDoneData.appendChild(stageDiv);

        });
        sendStagesToServer(checkedStages)
    });

    

    function sendStagesToServer(checkedStages) {
        $.ajax({
            url: "{{ route('admin.create.project', 5) }}", // Replace with your route
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                stages: checkedStages
            },
        });
    }
</script>
@endpush