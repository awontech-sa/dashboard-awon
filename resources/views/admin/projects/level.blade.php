<div class="flex justify-between">
    <label for="project-name">اختر مراحل المشروع المناسبة <span class="text-red-600">*</span></label>
    <a href="#my_modal_9" class="font-['Tajawal'] btn btn-sm bg-white shadow-none font-normal text-base mr-32 mb-5">
        إضافة مرحلة جديدة
        <x-fas-plus class="w-4 h-4 text-gray-600" />
    </a>
</div>

<div class="grid gap-y-7 top-list stage-checkbox" id="stages"></div>
<input type="hidden" name="array-stages">
<input type="hidden" name="stages-done">

<div class="my-8">
    <label for="project-name">اختر مراحل المشروع المنجزة <span class="text-red-600">*</span></label>
    <div class="mt-8 grid gap-y-7 bottom-list stages-done" id="stages-done"></div>
</div>

<div class="modal" role="dialog" id="my_modal_9">
    <div class="modal-box">
        <div class="modal-action justify-center">
            <div class="grid place-items-center">
                <h3 class="text-2xl font-bold">إضافة مرحلة</h3>
                <div class="grid mt-20 gap-y-5">
                    <label for="project-name">اسم المرحلة <span class="text-error">*</span></label>
                    <input type="text" class="input border" name="stage-name" id="stage_name" />
                </div>
                <div class="grid gap-y-5 mt-7">
                    <label for="project-name">ترتيب المرحلة <span class="text-error">*</span></label>
                    <input type="number" min="0" class="input border" name="stage-order" id="stage_order" />
                </div>
                <a href="#" class="btn btn-wide mt-28 bg-cyan-700 text-white font-bold text-base" onclick="addNewStage()">إضافة</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let stages = document.getElementById('stages');
    let stagesDone = document.getElementById('stages-done');
    let stageName = document.getElementById('stage_name');
    let stageOrder = document.getElementById('stage_order');
    let arrayStages = [];
    let doneStages = [];

    function addNewStage() {
        let nameValue = stageName.value.trim();
        let orderValue = stageOrder.value.trim();

        if (!nameValue || !orderValue || isNaN(orderValue)) {
            alert('يجب إدخال اسم المرحلة وترتيبها بشكل صحيح!');
            return;
        }

        let stageContainer = document.createElement('div');
        stageContainer.classList.add('flex', 'gap-x-4', 'draggable', 'new-stage');
        stageContainer.draggable = true;
        stageContainer.dataset.order = orderValue;

        // Create the form-control div
        let formControl = document.createElement('div');
        formControl.classList.add('form-control');

        // Create the label element
        let stageLabel = document.createElement('label');
        stageLabel.classList.add('label', 'cursor-pointer');

        // Create the span for the label text
        let stageSpan = document.createElement('span');
        stageSpan.classList.add('label-text');
        stageSpan.textContent = nameValue;

        // Create the input checkbox
        let checkStage = document.createElement('input');
        checkStage.type = 'checkbox';
        checkStage.name = 'stages[]';
        checkStage.value = orderValue;
        checkStage.classList.add('checkbox', 'border-gray-500', '[--chkbg:theme(colors.cyan.600)]', '[--chkfg:white]', 'stage-checked');
        checkStage.addEventListener('change', toggleStageDone);

        stageLabel.appendChild(stageSpan);
        stageLabel.appendChild(checkStage);

        formControl.appendChild(stageLabel);

        let deleteStage = document.createElement('button');
        deleteStage.type = 'button';
        deleteStage.innerHTML = `<x-far-trash-can class="w-6 h-6 text-red-500" />`;
        deleteStage.addEventListener('click', removeStage);

        stageContainer.appendChild(formControl);
        stageContainer.appendChild(deleteStage);

        stages.appendChild(stageContainer);

        arrayStages.push({
            stage_name: stageContainer.querySelector('span[class="label-text"]').textContent,
            stage_number: stageContainer.querySelector('input[name="stages[]"]').value
        })
        document.querySelector('input[name="array-stages"]').value = JSON.stringify(arrayStages);

        addDragAndDropListeners(stageContainer);

        stageName.value = '';
        stageOrder.value = '';
    }

    function toggleStageDone(event) {
        let checkbox = event.target;
        let parentContainer = checkbox.closest('.form-control');

        if (checkbox.checked) {
            let clone = parentContainer.cloneNode(true);
            let cloneCheckbox = clone.querySelector('input[type="checkbox"]');
            cloneCheckbox.checked = true;
            cloneCheckbox.disabled = true; // Disable the checkbox in the clone
            stagesDone.appendChild(clone);
            doneStages.push({
                stage_name: clone.querySelector('span[class="label-text"]').textContent,
                stage_number: clone.querySelector('input[name="stages[]"]').value
            })
            document.querySelector('input[name="stages-done"]').value = JSON.stringify(doneStages);
        } else {
            let doneStages = Array.from(stagesDone.children);
            doneStages.forEach(stage => {
                if (stage.querySelector('span').textContent === parentContainer.querySelector('span').textContent) {
                    stagesDone.removeChild(stage);
                    doneStages.pop({
                        stage_name: stage.querySelector('span[class="label-text"]').textContent,
                        stage_number: stage.querySelector('input[name="stages[]"]').value
                    })
                    document.querySelector('input[name="stages-done"]').value = JSON.stringify(doneStages);
                }
            });
        }
    }

    // Add drag-and-drop functionality
    function addDragAndDropListeners(element) {
        element.addEventListener('dragstart', dragStart);
        element.addEventListener('dragover', dragOver);
        element.addEventListener('drop', drop);
    }

    function dragStart(event) {
        event.dataTransfer.setData('text/plain', event.target.dataset.order);
        event.currentTarget.classList.add('dragging');
    }

    function dragOver(event) {
        event.preventDefault();
        let draggingElement = document.querySelector('.dragging');
        let targetElement = event.target.closest('.draggable');

        if (targetElement && targetElement !== draggingElement) {
            let bounding = targetElement.getBoundingClientRect();
            let offset = event.clientY - bounding.top;
            let middle = bounding.height / 2;

            if (offset > middle) {
                targetElement.after(draggingElement);
            } else {
                targetElement.before(draggingElement);
            }
        }
    }

    function drop(event) {
        event.preventDefault();
        let draggingElement = document.querySelector('.dragging');
        draggingElement.classList.remove('dragging');
    }

    function removeStage(event) {
        const deleteButton = event.target.closest('button');

        const stageToRemove = deleteButton.closest('.new-stage');

        if (stageToRemove) {
            const orderValue = stageToRemove.querySelector('input[name="stages[]"]').value;

            arrayStages = arrayStages.filter(stage => stage.stage_number !== orderValue);
            document.querySelector('input[name="array-stages"]').value = JSON.stringify(arrayStages);

            stageToRemove.remove();

        }

    }

    Array.from(stages.children).forEach(addDragAndDropListeners);
</script>
@endpush