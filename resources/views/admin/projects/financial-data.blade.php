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

        <div class="external-support hidden">
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
        <div class="grid my-8 cost-project-form">
            <label class="font-normal text-base mb-2">إجمالي تكلفة المشروع <span class="text-red-600">*</span></label>
            <input type="number" class="input" name="project-income" />
        </div>

    </div>
    <div class="supporter-data hidden" id="supporterDataSection"></div>
    <div class="supporter-comp hidden" id="supporterDataSection"></div>
</div>

<script>
    document.querySelectorAll('input[name="support-status"]').forEach(radio => {
        radio.addEventListener('change', displaySupporterData);
    });
    document.querySelectorAll('input[name="support-type"]').forEach(radio => {
        radio.addEventListener('change', displaySupporterData);
    });
    document.getElementById('number_support').addEventListener('input', displaySupporterData);

    function displaySupporterData() {
        let numSupport = document.getElementById('number_support').value;
        let supporterDataContainer = document.querySelector('.supporter-data');
        let notSupporterDataContainer = document.querySelector('.supporter-comp');
        let externalSupport = document.querySelector('.external-support');
        let costSupportForm = document.querySelector('.cost-project-form');
        let supportForm = document.querySelector('.support-type-form');
        let numberSupportForm = document.querySelector('.number-support-form');
        let isSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'مدعوم';
        let isNotSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'غير مدعوم';
        let isFullSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'كلي';
        let isPartSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'جزئي';
        let isExternalSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'جهة خارجية';
        let isEnternalSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'عون التقنية';
        let numberSupportInput = document.getElementById('number_support');

        // Only display the supporter data form when both "مدعوم" and "دعم كلي" are selected and the number is > 0
        if (isSupported) {
            supportForm.classList.remove('hidden');
            externalSupport.classList.add('hidden');
            numberSupportForm.classList.remove('hidden');
            costSupportForm.classList.remove('hidden');
            supporterDataContainer.classList.remove('hidden');
            notSupporterDataContainer.classList.add('hidden')
        }

        if (isNotSupported) {
            supportForm.classList.add('hidden');
            externalSupport.classList.remove('hidden');
            numberSupportForm.classList.add('hidden');
            costSupportForm.classList.add('hidden');
            supporterDataContainer.classList.add('hidden');
            notSupporterDataContainer.classList.remove('hidden')
        }

        if (isSupported && isFullSupport && numSupport >= 0) {
            supporterDataContainer.classList.remove('hidden');
            supporterDataContainer.innerHTML = ''; // Clear previous content

            for (let i = 1; i <= numSupport; i++) {
                supporterDataContainer.insertAdjacentHTML('beforeend', `
                    <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم ${i}</h1>
                    <div class="grid grid-cols-2 gap-x-7">
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">الجهة الداعمة<span class="text-red-600">*</span></label>
                            <input type="text" class="input" name="comp-support-${i}" />
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم<span class="text-red-600">*</span></label>
                            <input type="number" class="input" name="project-income-total-${i}" />
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">عدد الدفعات<span class="text-red-600">*</span></label>
                            <input type="number" class="input" name="payment-count-${i}" id="payment_count_${i}" />
                        </div>
                    </div>
                    
                    <!-- Table for Installments -->
                    <div class="installment-table mt-4" id="installment_table_${i}"></div>

                    <!-- Supporter Reports Section -->
                    <div class="grid grid-cols-2">
                        <div class="installment-report my-4" id="installment_report_${i}">
                            <div class="flex gap-x-4">
                                <p>تقارير للجهة الداعمة</p>
                                <button type="button" onclick="addReportInput(${i})" class="btn btn-xs font-normal bg-white">إضافة تقرير جديد</button>
                            </div>
                            <input class="input file-input my-5" type="file" />
                        </div>
                        
                        <!-- Supporter Files Section -->
                        <div class="installment-files my-4" id="installment_files_${i}">
                            <div class="flex gap-x-4">
                                <p>أوامر الصرف</p>
                                <button type="button" onclick="addFileInput(${i})" class="btn btn-xs font-normal bg-white">إضافة أمر صرف جديد</button>
                            </div>
                            <input class="input file-input my-5" type="file" />
                        </div>
                    </div>
                `);

                document.getElementById(`payment_count_${i}`).addEventListener('change', function() {
                    generateInstallmentTable(i, this.value);
                });
            }
        } else if (isSupported && isPartSupport && numSupport >= 0) {
            supporterDataContainer.classList.remove('hidden');
            supporterDataContainer.innerHTML = ''; // Clear previous content

            for (let i = 1; i <= numSupport; i++) {
                supporterDataContainer.insertAdjacentHTML('beforeend', `
                    <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم ${i}</h1>
                    <div class="grid grid-cols-2 gap-x-7">
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">الجهة الداعمة<span class="text-red-600">*</span></label>
                            <input type="text" class="input" name="comp-support-${i}" />
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم<span class="text-red-600">*</span></label>
                            <input type="number" class="input" name="project-income-total-${i}" />
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">عدد الدفعات<span class="text-red-600">*</span></label>
                            <input type="number" class="input" name="payment-count-${i}" id="payment_count_${i}" />
                        </div>
                    </div>
                    
                    <!-- Table for Installments -->
                    <div class="installment-table mt-4" id="installment_table_${i}"></div>

                    <!-- Supporter Reports Section -->
                    <div class="grid grid-cols-2">
                        <div class="stages-report my-4" id="stages_report_${i}">
                            <div class="flex gap-x-4">
                                <p>تقارير للجهة الداعمة</p>
                                <button type="button" onclick="addReposrtStages(${i})" class="btn btn-xs font-normal bg-white">إضافة تقرير جديد</button>
                            </div>
                            <input class="input file-input my-5" type="file" />
                        </div>
                        
                        <!-- Supporter Files Section -->
                        <div class="stages-files my-4" id="stages_files_${i}">
                            <div class="flex gap-x-4">
                                <p>أوامر الصرف</p>
                                <button type="button" onclick="addFileStages(${i})" class="btn btn-xs font-normal bg-white">إضافة أمر صرف جديد</button>
                            </div>
                            <input class="input file-input my-5" type="file" />
                        </div>

                    </div>
                    <div>
                        <h1 class="font-bold text-base mt-4">البيانات المالية للجزء الغير مدعوم</h1>
                        <div class="grid">
                            <div class="grid grid-cols-2 gap-x-7">
                                <div class="grid my-2">
                                    <label class="font-normal text-base mb-2">تكلفة المشروع المتوقعة<span class="text-red-600">*</span></label>
                                    <input type="text" class="input" name="project-expected-income-${i}" />
                                </div>
                                <div class="grid my-2">
                                    <label class="font-normal text-base mb-2">تكلفة المشروع الفعلية</label>
                                    <input type="text" class="input" name="project-real-income-${i}" />
                                </div>
                                <div class="grid my-2">
                                    <label class="font-normal text-base mb-2">عدد المراحل<span class="text-red-600">*</span></label>
                                    <input type="number" class="input" name="stages-count-${i}" id="stages_count_${i}" />
                                </div>
                            </div>
                            <div class="stages-table mt-4" id="stages_table_${i}"></div>
                        </div>
                    </div>
                `);

                document.getElementById(`stages_count_${i}`).addEventListener('change', function() {
                    generateStagesTable(i, this.value);
                });
                document.getElementById(`payment_count_${i}`).addEventListener('change', function() {
                    generateInstallmentTable(i, this.value);
                });
            }
        }

        if (isNotSupported && isExternalSupport) {
            notSupporterDataContainer.classList.remove('hidden')
            notSupporterDataContainer.innerHTML = ''
            notSupporterDataContainer.insertAdjacentHTML('beforeend', `
            <div class="grid grid-cols-3 gap-x-4 mt-8">
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
                    <input type="number" class="input" id="num_not_support" />
                </div>
            </div>
            <div class="not-supported-table mt-4" id="not_supported_table"></div>
            `)

            document.getElementById('num_not_support').addEventListener('change', function() {
                notSupportedTable(this.value)
            });

        } else if (isNotSupported && isEnternalSupport) {
            notSupporterDataContainer.classList.remove('hidden')
            notSupporterDataContainer.innerHTML = ''
            notSupporterDataContainer.insertAdjacentHTML('beforeend', `
            <div class="mt-8">
                <div class="grid">
                    <div class="grid grid-cols-2 gap-x-7">
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">تكلفة المشروع المتوقعة<span class="text-red-600">*</span></label>
                            <input type="text" class="input" name="project-expected-income-not-support" />
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">تكلفة المشروع الفعلية</label>
                            <input type="text" class="input" name="project-real-income-not-support" />
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">عدد المراحل<span class="text-red-600">*</span></label>
                            <input type="number" class="input" name="stages-count-not-support" id="stages_count_not_support" />
                        </div>
                    </div>
                    <div class="stages-table mt-4" id="stages_table_not_support"></div>
                </div>
            </div>
        `)

            document.getElementById('stages_count_not_support').addEventListener('change', function() {
                notSupportedStagesTable(this.value)
            });
        }
    }

    function generateInstallmentTable(supporterIndex, numInstallments) {
        let tableContainer = document.getElementById(`installment_table_${supporterIndex}`);
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
                        <td class="border px-4 py-2">
                            <input class="input file-input my-5" type="file" name="installment_files_${supporterIndex}_${j}" />
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

    function notSupportedTable(numInstallments) {
        let tableContainer = document.getElementById(`not_supported_table`);
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
                            <input type="number" name="not_supported_amount_${j}" class="input w-full" />
                        </td>
                        <td class="border px-4 py-2">
                            <label class="cursor-pointer label">
                                <span class="label-text">تم استلام الدفعة</span>
                                <input type="checkbox" class="checkbox" name="not_supported_status_${j}" />
                            </label>
                        </td>
                        <td class="border px-4 py-2">
                            <input class="input file-input my-5" type="file" name="not_supported_files_${j}" />
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
        let reportContainer = document.getElementById(`installment_report_${index}`);
        reportContainer.insertAdjacentHTML('beforeend', '<input class="input file-input my-5" type="file" />');
    }

    function addFileInput(index) {
        let fileContainer = document.getElementById(`installment_files_${index}`);
        fileContainer.insertAdjacentHTML('beforeend', '<input class="input file-input my-5" type="file" />');
    }

    function addReposrtStages(index) {
        let reportContainer = document.getElementById(`stages_report_${index}`);
        reportContainer.insertAdjacentHTML('beforeend', '<input class="input file-input my-5" type="file" />');
    }

    function addFileStages(index) {
        let fileContainer = document.getElementById(`stages_files_${index}`);
        fileContainer.insertAdjacentHTML('beforeend', '<input class="input file-input my-5" type="file" />');
    }

    function generateStagesTable(supporterIndex, numStages) {
        let tableContainer = document.getElementById(`stages_table_${supporterIndex}`);
        tableContainer.innerHTML = '';

        if (numStages > 0) {
            let tableHTML = `
                <table class="w-full border mt-2">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">المرحلة</th>
                            <th class="border px-4 py-2">تكلفة المرحلة</th>
                            <th class="border px-4 py-2">حالة الصرف</th>
                            <th class="border px-4 py-2">اثبات الصرف</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            for (let j = 1; j <= numStages; j++) {
                tableHTML += `
                    <tr>
                        <td class="border px-4 py-2">${j}</td>
                        <td class="border px-4 py-2">
                            <input type="number" name="stages_amount_${supporterIndex}_${j}" class="input w-full" />
                        </td>
                        <td class="border px-4 py-2">
                            <label class="cursor-pointer label">
                                <span class="label-text">تم الصرف</span>
                                <input type="checkbox" class="checkbox" name="stages_status_${supporterIndex}_${j}" />
                            </label>
                        </td>
                        <td class="border px-4 py-2">
                            <input class="input file-input my-5" type="file" name="stages_files_${supporterIndex}_${j}" />
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

    function notSupportedStagesTable(numStages) {
        let tableContainer = document.getElementById(`stages_table_not_support`);
        tableContainer.innerHTML = '';

        if (numStages > 0) {
            let tableHTML = `
                <table class="w-full border mt-2">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">المرحلة</th>
                            <th class="border px-4 py-2">تكلفة المرحلة</th>
                            <th class="border px-4 py-2">حالة الصرف</th>
                            <th class="border px-4 py-2">اثبات الصرف</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            for (let j = 1; j <= numStages; j++) {
                tableHTML += `
                    <tr>
                        <td class="border px-4 py-2">${j}</td>
                        <td class="border px-4 py-2">
                            <input type="number" name="stages_amountnot_support_${j}" class="input w-full" />
                        </td>
                        <td class="border px-4 py-2">
                            <label class="cursor-pointer label">
                                <span class="label-text">تم الصرف</span>
                                <input type="checkbox" class="checkbox" name="stages_statusnot_support_${j}" />
                            </label>
                        </td>
                        <td class="border px-4 py-2">
                            <input class="input file-input my-5" type="file" name="stages_filesnot_support_${j}" />
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
</script>