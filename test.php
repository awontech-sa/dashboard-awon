<div class="my-5">
    <div class="grid grid-cols-2 gap-x-6">
        <div>
            <label class="font-normal text-base mb-2">حالة الدعم <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                @foreach (App\Enums\SupportStatus::cases() as $status)
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $status->value }}</span>
                        <input type="radio" value="{{ $status->value }}" name="support-status" class="radio" id="support-status-{{ $status->value }}" />
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="support-type-form">
            <label class="font-normal text-base mb-2">نوع الدعم <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                @foreach (App\Enums\SupportType::cases() as $type)
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $type->value }}</span>
                        <input type="radio" value="{{ $type->value }}" name="support-type" class="radio" id="support-type-{{ $type->value }}" />
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="support-comp-form hidden">
            <label class="font-normal text-base mb-2">مالك المشروع <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                @foreach (App\Enums\SupportComp::cases() as $type)
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $type->value }}</span>
                        <input type="radio" value="{{ $type->value }}" name="support-type" class="radio" id="support-type-{{ $type->value }}" />
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid my-8 number-support-form">
            <label class="font-normal text-base mb-2">عدد الجهات الداعمة <span class="text-red-600">*</span></label>
            <input type="number" class="input" name="number-support" id="number_support" />
        </div>
        <div class="grid my-8 total-project-income">
            <label class="font-normal text-base mb-2">إجمالي تكلفة المشروع <span class="text-red-600">*</span></label>
            <input type="number" class="input" name="project-income" />
        </div>

    </div>
    <div class="supporter-data hidden"></div>
    <div class="supporter-comp hidden"></div>
</div>

<script>
    // Add event listeners for radio buttons to detect changes
    document.querySelectorAll('input[name="support-status"]').forEach(radio => {
        radio.addEventListener('change', displaySupporterData);
    });
    document.querySelectorAll('input[name="support-type"]').forEach(radio => {
        radio.addEventListener('change', displaySupporterData);
    });
    document.getElementById('number_support').addEventListener('input', displaySupporterData);

    function displaySupporterData() {
        let numSupport = document.getElementById('number_support').value;
        let supporterDataContainer = document.getElementById('supporterDataSection');
        let supportForm = document.querySelector('.support-type-form');
        let supportCompForm = document.querySelector('.support-comp-form');
        let numberSupportForm = document.querySelector('.number-support-form');
        let numberSupportInput = document.getElementById('number_support');
        let totalProjectIncome = document.querySelector('.total-project-income');

        // Get the selected support status and type values
        let isSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'مدعوم';
        let isNotSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'غير مدعوم';
        let isFullSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'كلي';
        let isPartSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'جزئي';

        // If "غير مدعوم" is selected, hide all support-related fields
        if (isNotSupported) {
            supportForm.classList.add('hidden');
            numberSupportForm.classList.add('hidden');
            supporterDataContainer.classList.add('hidden');
            totalProjectIncome.classList.add('hidden');

            supportCompForm.classList.remove('hidden');
            supporterDataContainer.innerHTML = ''; // Clear content if hidden


            supporterDataContainer.insertAdjacentHTML('beforeend', generateNotSupportForm(isNotSupported));
        }

        // Show support form and number input when "مدعوم" is selected
        supportForm.classList.remove('hidden');
        numberSupportForm.classList.remove('hidden');
        totalProjectIncome.classList.remove('hidden');

        supportCompForm.classList.add('hidden');

        // Show supporter data only if both "مدعوم" and "دعم كلي" or "دعم جزئي" are selected, with number > 0
        if (isSupported && numSupport > 0) {
            supporterDataContainer.classList.remove('hidden');
            supporterDataContainer.innerHTML = ''; // Clear previous content

            for (let i = 1; i <= numSupport; i++) {
                supporterDataContainer.insertAdjacentHTML('beforeend', generateSupporterForm(i, isFullSupport));

                // Add event listener for each payment count input for installment generation
                document.getElementById(`payment_count_${i}`).addEventListener('change', function() {
                    generateInstallmentTable(i, this.value);
                });

                if (!isFullSupport) {
                    // Add stage count for جزئي support type
                    document.getElementById(`stages_count_${i}`).addEventListener('change', function() {
                        generateStagesTable(i, this.value);
                    });
                }
            }
        } else {
            // Hide supporter data if conditions are not met
            supporterDataContainer.classList.add('hidden');
            supporterDataContainer.innerHTML = '';
        }
    }

    function generateInstallmentTable(supporterIndex, numInstallments) {
        const tableContainer = document.getElementById(`installment_table_${supporterIndex}`);
        tableContainer.innerHTML = '';

        if (numInstallments > 0) {
            let tableHTML = `
                <table class="w-full border mt-2">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">الدفعة</th>
                            <th class="border px-4 py-2">قيمة الدفعة</th>
                            <th class="border px-4 py-2">حالة استلام الدفعة</th>
                            <th class="border px-4 py-2">اثبات استلام الدفعة</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            for (let j = 1; j <= numInstallments; j++) {
                tableHTML += `
                    <tr>
                        <td class="border px-4 py-2">${j}</td>
                        <td class="border px-4 py-2">
                            <input type="number" name="installment_amount_${supporterIndex}_${j}" class="input w-full" />
                        </td>
                        <td class="border px-4 py-2">
                            <label class="cursor-pointer label">
                                <span class="label-text">تم استلام الدفعة</span>
                                <input type="checkbox" class="checkbox" name="installment_status_${supporterIndex}_${j}" />
                            </label>
                        </td>
                    </tr>
                `;
            }

            tableHTML += `
                    </tbody>
                </table>
            `;

            tableContainer.insertAdjacentHTML('beforeend', tableHTML);
        }
    }

    function addReportInput(index) {
        const reportContainer = document.getElementById(`installment_report_${index}`);
        reportContainer.insertAdjacentHTML('beforeend', '<input class="input file-input my-5" type="file" />');
    }

    function addFileInput(index) {
        const fileContainer = document.getElementById(`installment_files_${index}`);
        fileContainer.insertAdjacentHTML('beforeend', '<input class="input file-input my-5" type="file" />');
    }

    function generateSupporterForm(index, isFullSupport) {
        const commonFields = `
        <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم ${index}</h1>
        <div class="grid grid-cols-2 gap-x-7">
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">الجهة الداعمة<span class="text-red-600">*</span></label>
                <input type="text" class="input" name="comp-support-${index}" />
            </div>
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم<span class="text-red-600">*</span></label>
                <input type="number" class="input" name="project-income-total-${index}" />
            </div>
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">عدد الدفعات<span class="text-red-600">*</span></label>
                <input type="number" class="input" name="payment-count-${index}" id="payment_count_${index}" />
            </div>
        </div>
        <div class="installment-table mt-4" id="installment_table_${index}"></div>
        <div class="grid grid-cols-2">
            <div class="installment-report my-4" id="installment_report_${index}">
                <div class="flex gap-x-4">
                    <p>تقارير للجهة الداعمة</p>
                    <button type="button" onclick="addReportInput(${index})" class="btn btn-xs font-normal bg-white">إضافة تقرير جديد</button>
                </div>
                <input class="input file-input my-5" type="file" />
            </div>
            <div class="installment-files my-4" id="installment_files_${index}">
                <div class="flex gap-x-4">
                    <p>أوامر الصرف</p>
                    <button type="button" onclick="addFileInput(${index})" class="btn btn-xs font-normal bg-white">إضافة أمر صرف جديد</button>
                </div>
                <input class="input file-input my-5" type="file" />
            </div>
        </div>`;

        const partialSupportFields = `
        <div>
            <h1 class="font-bold text-base mt-4">البيانات المالية للجزء الغير مدعوم</h1>
            <div class="grid grid-cols-2 gap-x-7">
                <div class="grid my-2">
                    <label class="font-normal text-base mb-2">تكلفة المشروع المتوقعة<span class="text-red-600">*</span></label>
                    <input type="text" class="input" name="project-expected-income-${index}" />
                </div>
                <div class="grid my-2">
                    <label class="font-normal text-base mb-2">تكلفة المشروع الفعلية</label>
                    <input type="text" class="input" name="project-real-income-${index}" />
                </div>
                <div class="grid my-2">
                    <label class="font-normal text-base mb-2">عدد المراحل<span class="text-red-600">*</span></label>
                    <input type="number" class="input" name="stages-count-${index}" id="stages_count_${index}" />
                </div>
            </div>
            <div class="stages-table mt-4" id="stages_table_${index}"></div>
        </div>`;

        return isFullSupport ? commonFields : commonFields + partialSupportFields;
    }

    function generateNotSupportForm(isNotSupport) {
        const notSupportForm = `
        <div class="grid grid-cols-3 gap-x-4">
            <div class="grid">
                <label for="">اسم الجهة <span class="text-red-600">*</span></label>
                <input type="text" class="input" />
            </div>
            <div class="grid">
                <label for="">تكلفة المشروع <span class="text-red-600">*</span></label>
                <input type="text" class="input" />
            </div>
            <div class="grid">
                <label for="">عدد الدفعات <span class="text-red-600">*</span></label>
                <input type="number" class="input" />
            </div>
        </div>`
    }
</script>