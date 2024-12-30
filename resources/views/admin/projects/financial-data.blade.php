<form action="{{ route('admin.create.project', ['step' => $step]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="my-5">
        <div class="grid grid-cols-2 gap-x-6">
            <div>
                <label class="font-normal text-base mb-2">حالة الدعم</label>
                <div class="bg-white flex gap-x-4 p-2 rounded">
                    @foreach (App\Enums\SupportStatus::cases() as $status)
                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">{{ $status->value }}</span>
                            <input
                                type="radio"
                                name="support-status"
                                value="{{ $status->value }}"
                                class="radio"
                                id="support-status-{{ $status->value }}"
                                {{ old('support-status', $data['p_support_status'] ?? '') === $status->value ? 'checked' : '' }} />
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="support-type-form">
                <label class="font-normal text-base mb-2">نوع الدعم</label>
                <div class="bg-white flex gap-x-4 p-2 rounded">
                    @foreach (App\Enums\SupportType::cases() as $type)
                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">{{ $type->value }}</span>
                            <input type="radio" value="{{ $type->value }}" name="support-type" class="radio" id="support-type-{{ $type->value }}"
                                {{ old('support-type', $data['p_support_type'] ?? '') === $type->value ? 'checked' : '' }} />
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="external-support hidden">
                <label class="font-normal text-base mb-2">مالك المشروع</label>
                <div class="bg-white flex gap-x-4 p-2 rounded">
                    @foreach (App\Enums\SupportComp::cases() as $type)
                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">{{ $type->value }}</span>
                            <input type="radio" value="{{ $type->value }}" name="supporter" class="radio" id="support-comp-{{ $type->value }}"
                                {{ old('supporter', $data['supporter'] ?? '') === $status->value ? 'checked' : '' }} />
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="grid my-8 number-support-form">
                <label class="font-normal text-base mb-2">عدد الجهات الداعمة</label>
                <input type="number" min="0" class="input" name="number-support" id="number_support" />
            </div>
            <div class="grid my-8 cost-project-form">
                <label class="font-normal text-base mb-2">إجمالي تكلفة المشروع</label>
                <input type="number" min="0" class="input" name="project-income" value="{{ old('project-income', $data['total_cost'] ?? '') }}" />
            </div>
        </div>

        <div class="supporter-data hidden" id="supporterDataSection"></div>
        <div class="supporter-comp hidden" id="supporterDataSection"></div>

        <div class="finan-data-not-support hidden">
            <h1 class="font-bold text-base mt-4">البيانات المالية للجزء الغير مدعوم</h1>
            <div class="grid">
                <div class="grid grid-cols-2 gap-x-7">
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">تكلفة المشروع المتوقعة</label>
                        <input type="text" class="input" name="project-expected-income">
                    </div>
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">تكلفة المشروع الفعلية</label>
                        <input type="text" class="input" name="project-expected-real">
                    </div>
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">عدد المراحل</label>
                        <input type="number" class="input" name="stages-count" id="stages_count" min="0">
                    </div>
                </div>
                <div class="stages-table mt-4" id="stages_table"></div>
            </div>
        </div>
    </div>

    <div class="join grid grid-cols-2 w-1/4 float-left">
        @if($step == 2 && $step < 8)
            <a type="submit" href="{{ route('admin.create.project', ['step' => $step - 1]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
            hover:bg-cyan-700/30 hover:text-cyan-700">
            السابق
            </a>
            <button type="submit" href="{{ route('admin.create.project', ['step' => $step + 1]) }}" class="join-item btn bg-cyan-700 text-base text-white
            hover:bg-cyan-700">
                التالي
            </button>
            @endif
    </div>
</form>

@push('scripts')
<script>
    document.querySelectorAll('input[name="support-status"]').forEach(radio => {
        radio.addEventListener('change', displaySupporterData);
    });
    document.querySelectorAll('input[name="support-type"]').forEach(radio => {
        radio.addEventListener('change', displaySupporterData);
    });
    document.querySelectorAll('input[name="supporter"]').forEach(radio => {
        radio.addEventListener('change', displaySupporterData);
    });
    document.getElementById('number_support').addEventListener('input', displaySupporterData);

    let countReport = 0;
    let paymentCountFiles = 0

    function displaySupporterData() {
        let numSupport = document.getElementById('number_support').value;
        let supporterDataContainer = document.querySelector('.supporter-data');
        let notSupporterDataContainer = document.querySelector('.supporter-comp');
        let externalSupport = document.querySelector('.external-support');
        let costSupportForm = document.querySelector('.cost-project-form');
        let finanDataNotSupportForm = document.querySelector('.finan-data-not-support');
        let supportForm = document.querySelector('.support-type-form');
        let numberSupportForm = document.querySelector('.number-support-form');
        let isSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'مدعوم';
        let isNotSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'غير مدعوم';
        let isFullSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'كلي';
        let isPartSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'جزئي';
        let isExternalSupport = document.querySelector('input[name="supporter"]:checked')?.value === 'جهة خارجية';
        let isEnternalSupport = document.querySelector('input[name="supporter"]:checked')?.value === 'عون التقنية';

        if (isSupported) {
            supportForm.classList.remove('hidden');
            externalSupport.classList.add('hidden');
            numberSupportForm.classList.remove('hidden');
            costSupportForm.classList.remove('hidden');
            supporterDataContainer.classList.remove('hidden');
            notSupporterDataContainer.classList.add('hidden')
            finanDataNotSupportForm.classList.add('hidden');
        }

        if (isSupported && isFullSupport && numSupport >= 0) {
            supporterDataContainer.classList.remove('hidden');
            supporterDataContainer.innerHTML = '';

            for (let i = 1; i <= numSupport; i++) {
                let supporterDiv = document.createElement('div');

                let heading = document.createElement('h1');
                heading.classList.add('font-bold', 'text-base', 'mt-4');
                heading.textContent = `بيانات الجهة الداعمة رقم ${i}`;
                supporterDiv.appendChild(heading);

                let grid = document.createElement('div');
                grid.classList.add('grid', 'grid-cols-2', 'gap-x-7');
                supporterDiv.appendChild(grid);

                let compSupportDiv = document.createElement('div');
                compSupportDiv.classList.add('grid', 'my-2');
                let compSupportLabel = document.createElement('label');
                compSupportLabel.classList.add('font-normal', 'text-base', 'mb-2');
                compSupportLabel.textContent = 'الجهة الداعمة';
                let compSupportInput = document.createElement('input');
                compSupportInput.type = 'text';
                compSupportInput.classList.add('input');
                compSupportInput.name = `comp-support-${i}`;
                compSupportDiv.appendChild(compSupportLabel);
                compSupportDiv.appendChild(compSupportInput);
                grid.appendChild(compSupportDiv);

                let projectIncomeDiv = document.createElement('div');
                projectIncomeDiv.classList.add('grid', 'my-2');
                let projectIncomeLabel = document.createElement('label');
                projectIncomeLabel.classList.add('font-normal', 'text-base', 'mb-2');
                projectIncomeLabel.textContent = 'إجمالي مبلغ الدعم';
                let projectIncomeInput = document.createElement('input');
                projectIncomeInput.type = 'number';
                projectIncomeInput.min = 0
                projectIncomeInput.classList.add('input');
                projectIncomeInput.name = `project-income-total-${i}`;
                projectIncomeDiv.appendChild(projectIncomeLabel);
                projectIncomeDiv.appendChild(projectIncomeInput);
                grid.appendChild(projectIncomeDiv);

                let paymentCountDiv = document.createElement('div');
                paymentCountDiv.classList.add('grid', 'my-2');
                let paymentCountLabel = document.createElement('label');
                paymentCountLabel.classList.add('font-normal', 'text-base', 'mb-2');
                paymentCountLabel.textContent = 'عدد الدفعات';
                let paymentCountInput = document.createElement('input');
                paymentCountInput.type = 'number';
                paymentCountInput.min = 0
                paymentCountInput.classList.add('input');
                paymentCountInput.name = `payment-count-${i}`;
                paymentCountInput.id = `payment_count_${i}`;
                paymentCountDiv.appendChild(paymentCountLabel);
                paymentCountDiv.appendChild(paymentCountInput);
                grid.appendChild(paymentCountDiv);

                let installmentTable = document.createElement('div');
                installmentTable.classList.add('installment-table', 'mt-4');
                installmentTable.id = `installment_table_${i}`;
                supporterDiv.appendChild(installmentTable);

                let reportFilesGrid = document.createElement('div');
                reportFilesGrid.classList.add('grid', 'grid-cols-2');
                supporterDiv.appendChild(reportFilesGrid);

                let reportDiv = document.createElement('div');
                reportDiv.classList.add('installment-report', 'my-4');
                reportDiv.id = `installment_report_${i}`;
                let reportFlex = document.createElement('div');
                reportFlex.classList.add('flex', 'gap-x-4');
                let reportText = document.createElement('p');
                reportText.textContent = 'تقارير للجهة الداعمة';
                let addReportButton = document.createElement('button');
                addReportButton.type = 'button';
                addReportButton.classList.add('btn', 'btn-xs', 'font-normal', 'bg-white');
                addReportButton.textContent = 'إضافة تقرير جديد';
                addReportButton.name = 'add-report'
                addReportButton.id = 'add_report'
                addReportButton.onclick = () => {
                    let [reportFiles, reports, removeReportBtn] = addReportInput(countReport, i);
                    reportDiv.appendChild(reportFiles);
                    countReport = reports
                    hiddenCountReport.value = countReport


                    removeReportBtn.onclick = () => {
                        removeReport(reportFiles)
                        countReport--
                    }
                }


                let hiddenCountReport = document.createElement('input')
                hiddenCountReport.type = 'hidden'
                hiddenCountReport.name = 'countReport'
                hiddenCountReport.value = countReport

                reportFlex.appendChild(reportText);
                reportFlex.appendChild(addReportButton);
                reportDiv.appendChild(hiddenCountReport)
                reportDiv.appendChild(reportFlex);
                reportFilesGrid.appendChild(reportDiv);

                let fileDiv = document.createElement('div');
                fileDiv.classList.add('installment-files', 'my-4');
                fileDiv.id = `installment_files_${i}`;
                let fileFlex = document.createElement('div');
                fileFlex.classList.add('flex', 'gap-x-4');
                let fileText = document.createElement('p');
                fileText.textContent = 'أوامر الصرف';
                let addFileButton = document.createElement('button');
                addFileButton.type = 'button';
                addFileButton.classList.add('btn', 'btn-xs', 'font-normal', 'bg-white');
                addFileButton.textContent = 'إضافة أمر صرف جديد';
                addFileButton.onclick = () => {
                    let [pyamentFiles, payments, removeFileBtn] = addFileInput(paymentCountFiles, i)
                    fileDiv.appendChild(pyamentFiles);
                    paymentCountFiles = payments
                    hiddenCountFiles.value = paymentCountFiles

                    removeFileBtn.onclick = () => {
                        pyamentFiles.remove();
                    }
                };

                let hiddenCountFiles = document.createElement('input')
                hiddenCountFiles.type = 'hidden'
                hiddenCountFiles.name = 'paymentCountFiles'
                hiddenCountFiles.value = paymentCountFiles

                fileFlex.appendChild(fileText);
                fileFlex.appendChild(addFileButton);
                fileDiv.appendChild(fileFlex);
                fileDiv.appendChild(hiddenCountFiles)
                reportFilesGrid.appendChild(fileDiv);
                supporterDataContainer.appendChild(supporterDiv);

                document.getElementById(`payment_count_${i}`).addEventListener('input', function() {
                    generateInstallmentTable(i, this.value);
                });
            }
        } else if (isSupported && isPartSupport && numSupport >= 0) {
            supporterDataContainer.classList.remove('hidden');
            finanDataNotSupportForm.classList.remove('hidden');
            supporterDataContainer.innerHTML = '';

            for (let i = 1; i <= numSupport; i++) {
                let supporterDiv = document.createElement('div');

                let heading = document.createElement('h1');
                heading.classList.add('font-bold', 'text-base', 'mt-4');
                heading.textContent = `بيانات الجهة الداعمة رقم ${i}`;
                supporterDiv.appendChild(heading);

                let grid = document.createElement('div');
                grid.classList.add('grid', 'grid-cols-2', 'gap-x-7');
                supporterDiv.appendChild(grid);

                let compSupportDiv = document.createElement('div');
                compSupportDiv.classList.add('grid', 'my-2');
                let compSupportLabel = document.createElement('label');
                compSupportLabel.classList.add('font-normal', 'text-base', 'mb-2');
                compSupportLabel.textContent = 'الجهة الداعمة';
                let compSupportInput = document.createElement('input');
                compSupportInput.type = 'text';
                compSupportInput.classList.add('input');
                compSupportInput.name = `comp-support-${i}`;
                compSupportDiv.appendChild(compSupportLabel);
                compSupportDiv.appendChild(compSupportInput);
                grid.appendChild(compSupportDiv);

                let projectIncomeDiv = document.createElement('div');
                projectIncomeDiv.classList.add('grid', 'my-2');
                let projectIncomeLabel = document.createElement('label');
                projectIncomeLabel.classList.add('font-normal', 'text-base', 'mb-2');
                projectIncomeLabel.textContent = 'إجمالي مبلغ الدعم';
                let projectIncomeInput = document.createElement('input');
                projectIncomeInput.type = 'number';
                projectIncomeInput.min = 0
                projectIncomeInput.classList.add('input');
                projectIncomeInput.name = `project-income-total-${i}`;
                projectIncomeDiv.appendChild(projectIncomeLabel);
                projectIncomeDiv.appendChild(projectIncomeInput);
                grid.appendChild(projectIncomeDiv);

                let paymentCountDiv = document.createElement('div');
                paymentCountDiv.classList.add('grid', 'my-2');
                let paymentCountLabel = document.createElement('label');
                paymentCountLabel.classList.add('font-normal', 'text-base', 'mb-2');
                paymentCountLabel.textContent = 'عدد الدفعات';
                let paymentCountInput = document.createElement('input');
                paymentCountInput.type = 'number';
                paymentCountInput.min = 0
                paymentCountInput.classList.add('input');
                paymentCountInput.name = `payment-count-${i}`;
                paymentCountInput.id = `payment_count_${i}`;
                paymentCountDiv.appendChild(paymentCountLabel);
                paymentCountDiv.appendChild(paymentCountInput);
                grid.appendChild(paymentCountDiv);

                let installmentTable = document.createElement('div');
                installmentTable.classList.add('installment-table', 'mt-4');
                installmentTable.id = `installment_table_${i}`;
                supporterDiv.appendChild(installmentTable);

                let reportFilesGrid = document.createElement('div');
                reportFilesGrid.classList.add('grid', 'grid-cols-2');
                supporterDiv.appendChild(reportFilesGrid);

                let reportDiv = document.createElement('div');
                reportDiv.classList.add('installment-report', 'my-4');
                reportDiv.id = `installment_report_${i}`;
                let reportFlex = document.createElement('div');
                reportFlex.classList.add('flex', 'gap-x-4');
                let reportText = document.createElement('p');
                reportText.textContent = 'تقارير للجهة الداعمة';
                let addReportButton = document.createElement('button');
                addReportButton.type = 'button';
                addReportButton.classList.add('btn', 'btn-xs', 'font-normal', 'bg-white');
                addReportButton.textContent = 'إضافة تقرير جديد';
                addReportButton.name = 'add-report'
                addReportButton.id = 'add_report'
                addReportButton.onclick = () => {
                    let [reportFiles, reports, removeReportBtn] = addReportInput(countReport, i);
                    reportDiv.appendChild(reportFiles);
                    countReport = reports
                    hiddenCountReport.value = countReport

                    removeReportBtn.onclick = () => {
                        removeReport(reportFiles)
                        countReport--
                    }
                }

                let hiddenCountReport = document.createElement('input')
                hiddenCountReport.type = 'hidden'
                hiddenCountReport.name = 'countReport'
                hiddenCountReport.value = countReport

                reportFlex.appendChild(reportText);
                reportFlex.appendChild(addReportButton);
                reportDiv.appendChild(hiddenCountReport)
                reportDiv.appendChild(reportFlex);
                reportFilesGrid.appendChild(reportDiv);

                let fileDiv = document.createElement('div');
                fileDiv.classList.add('installment-files', 'my-4');
                fileDiv.id = `installment_files_${i}`;
                let fileFlex = document.createElement('div');
                fileFlex.classList.add('flex', 'gap-x-4');
                let fileText = document.createElement('p');
                fileText.textContent = 'أوامر الصرف';
                let addFileButton = document.createElement('button');
                addFileButton.type = 'button';
                addFileButton.classList.add('btn', 'btn-xs', 'font-normal', 'bg-white');
                addFileButton.textContent = 'إضافة أمر صرف جديد';
                addFileButton.onclick = () => {
                    let [pyamentFiles, payments, removeFileBtn] = addFileInput(paymentCountFiles, i)
                    fileDiv.appendChild(pyamentFiles);
                    paymentCountFiles = payments
                    hiddenCountFiles.value = paymentCountFiles

                    removeFileBtn.onclick = () => {
                        pyamentFiles.remove();
                    }
                };

                let hiddenCountFiles = document.createElement('input')
                hiddenCountFiles.type = 'hidden'
                hiddenCountFiles.name = 'paymentCountFiles'
                hiddenCountFiles.value = paymentCountFiles

                fileFlex.appendChild(fileText);
                fileFlex.appendChild(addFileButton);
                fileDiv.appendChild(fileFlex);
                fileDiv.appendChild(hiddenCountFiles)
                reportFilesGrid.appendChild(fileDiv);
                supporterDataContainer.appendChild(supporterDiv);

                document.getElementById(`payment_count_${i}`).addEventListener('input', function() {
                    generateInstallmentTable(i, this.value);
                });
            }
            document.getElementById(`stages_count`).addEventListener('input', function() {
                generateStagesTable(this.value);
            });
        }

        if (isNotSupported) {

            supportForm.classList.add('hidden');
            externalSupport.classList.remove('hidden');
            numberSupportForm.classList.add('hidden');
            costSupportForm.classList.add('hidden');
            supporterDataContainer.classList.add('hidden');
            notSupporterDataContainer.classList.remove('hidden')
        }

        if (isNotSupported && isExternalSupport) {
            notSupporterDataContainer.classList.remove('hidden');
            notSupporterDataContainer.innerHTML = '';

            let formContainer = document.createElement('div');
            formContainer.classList.add('grid', 'grid-cols-3', 'gap-x-4', 'mt-8');

            let nameLabelDiv = document.createElement('div');
            nameLabelDiv.classList.add('flex', 'items-center', 'gap-x-4')
            let nameLabel = document.createElement('label');
            nameLabel.textContent = 'اسم الجهة ';
            let nameInput = document.createElement('input');
            nameInput.classList.add('input');
            nameInput.name = 'comp-name'
            nameLabelDiv.appendChild(nameLabel);
            nameLabelDiv.appendChild(nameInput);

            let costLabelDiv = document.createElement('div');
            costLabelDiv.classList.add('flex', 'items-center', 'gap-x-4')
            let costLabel = document.createElement('label');
            costLabel.textContent = 'تكلفة المشروع ';
            let costInput = document.createElement('input');
            costInput.classList.add('input');
            costInput.name = 'income-project'
            costLabelDiv.appendChild(costLabel);
            costLabelDiv.appendChild(costInput);

            let installmentLabelDiv = document.createElement('div');
            installmentLabelDiv.classList.add('flex', 'items-center', 'gap-x-4')
            let installmentLabel = document.createElement('label');
            installmentLabel.textContent = 'عدد الدفعات ';
            let installmentInput = document.createElement('input');
            installmentInput.classList.add('input');
            installmentInput.type = 'number';
            installmentInput.min = 0
            installmentInput.id = 'num_not_support';
            installmentInput.name = 'num-not-support'
            installmentLabelDiv.appendChild(installmentLabel);
            installmentLabelDiv.appendChild(installmentInput);

            formContainer.appendChild(nameLabelDiv);
            formContainer.appendChild(costLabelDiv);
            formContainer.appendChild(installmentLabelDiv);

            notSupporterDataContainer.appendChild(formContainer);

            let tableContainer = document.createElement('div');
            tableContainer.classList.add('not-supported-table', 'mt-4');
            tableContainer.id = 'installment_table_0';

            notSupporterDataContainer.appendChild(tableContainer);

            document.getElementById('num_not_support').addEventListener('input', function() {
                generateInstallmentTable(0, this.value)
            });

        } else if (isNotSupported && isEnternalSupport) {
            notSupporterDataContainer.classList.remove('hidden')
            notSupporterDataContainer.innerHTML = ''
            notSupporterDataContainer.classList.remove('hidden');
            notSupporterDataContainer.innerHTML = '';

            let parentDiv = document.createElement('div');
            parentDiv.classList.add('mt-8');

            let gridContainer = document.createElement('div');
            gridContainer.classList.add('grid');

            let innerGrid = document.createElement('div');
            innerGrid.classList.add('grid', 'grid-cols-2', 'gap-x-7');

            let expectedCostField = document.createElement('div');
            expectedCostField.classList.add('grid', 'my-2');

            let expectedCostLabel = document.createElement('label');
            expectedCostLabel.classList.add('font-normal', 'text-base', 'mb-2');
            expectedCostLabel.innerHTML = 'تكلفة المشروع المتوقعة';

            let expectedCostInput = document.createElement('input');
            expectedCostInput.type = 'text';
            expectedCostInput.classList.add('input');
            expectedCostInput.name = 'project-expected-income-not-support';

            expectedCostField.appendChild(expectedCostLabel);
            expectedCostField.appendChild(expectedCostInput);

            let actualCostField = document.createElement('div');
            actualCostField.classList.add('grid', 'my-2');

            let actualCostLabel = document.createElement('label');
            actualCostLabel.classList.add('font-normal', 'text-base', 'mb-2');
            actualCostLabel.textContent = 'تكلفة المشروع الفعلية';

            let actualCostInput = document.createElement('input');
            actualCostInput.type = 'text';
            actualCostInput.classList.add('input');
            actualCostInput.name = 'project-real-income-not-support';

            actualCostField.appendChild(actualCostLabel);
            actualCostField.appendChild(actualCostInput);

            let stagesCountField = document.createElement('div');
            stagesCountField.classList.add('grid', 'my-2');

            let stagesCountLabel = document.createElement('label');
            stagesCountLabel.classList.add('font-normal', 'text-base', 'mb-2');
            stagesCountLabel.innerHTML = 'عدد المراحل';

            let stagesCountInput = document.createElement('input');
            stagesCountInput.min = 0
            stagesCountInput.type = 'number';
            stagesCountInput.classList.add('input');
            stagesCountInput.name = 'stages-count-not-support';
            stagesCountInput.id = 'stages_count_not_support';

            stagesCountField.appendChild(stagesCountLabel);
            stagesCountField.appendChild(stagesCountInput);

            innerGrid.appendChild(expectedCostField);
            innerGrid.appendChild(actualCostField);
            innerGrid.appendChild(stagesCountField);

            gridContainer.appendChild(innerGrid);

            let stagesTable = document.createElement('div');
            stagesTable.classList.add('stages-table', 'mt-4');
            stagesTable.id = 'stages_table';

            gridContainer.appendChild(stagesTable);

            parentDiv.appendChild(gridContainer);

            notSupporterDataContainer.appendChild(parentDiv);

            document.getElementById('stages_count_not_support').addEventListener('input', function() {
                generateStagesTable(this.value)
            });
        }
    }

    function generateInstallmentTable(supporterIndex, numInstallments) {
        let tableContainer = document.getElementById(`installment_table_${supporterIndex}`);
        tableContainer.innerHTML = ''; // Clear any existing content

        if (numInstallments > 0) {
            // Create table element
            let table = document.createElement('table');
            table.classList.add('w-full', 'border', 'mt-2');

            // Create thead
            let thead = document.createElement('thead');
            let headerRow = document.createElement('tr');
            let headers = ['الدفعة', 'قيمة الدفعة', 'حالة استلام الدفعة', 'اثبات استلام الدفعة'];

            headers.forEach(headerText => {
                let th = document.createElement('th');
                th.classList.add('border', 'px-4', 'py-2');
                th.textContent = headerText;
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Create tbody
            let tbody = document.createElement('tbody');

            for (let j = 1; j <= numInstallments; j++) {
                let row = document.createElement('tr');

                // دفعة
                let installmentCell = document.createElement('td');
                installmentCell.classList.add('border', 'px-4', 'py-2');
                installmentCell.textContent = j;
                row.appendChild(installmentCell);

                // قيمة الدفعة
                let amountCell = document.createElement('td');
                amountCell.classList.add('border', 'px-4', 'py-2');
                let amountInput = document.createElement('input');
                amountInput.type = 'number';
                amountInput.min = 0
                amountInput.name = `installment_amount_${supporterIndex}_${j}`;
                amountInput.classList.add('input', 'w-full');
                amountCell.appendChild(amountInput);
                row.appendChild(amountCell);

                // حالة استلام الدفعة
                let statusCell = document.createElement('td');
                statusCell.classList.add('border', 'px-4', 'py-2');
                let label = document.createElement('label');
                label.classList.add('cursor-pointer', 'label', 'flex', 'items-center', 'gap-x-4');
                let span = document.createElement('span');
                span.classList.add('label-text');
                span.textContent = 'تم استلام الدفعة';
                let checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.classList.add('checkbox', 'checkbox-lg', 'border', '[--chkbg:theme(colors.cyan.500)]', '[--chkfg:white]');
                checkbox.name = `installment_status_${supporterIndex}_${j}`;
                label.appendChild(checkbox);
                label.appendChild(span);
                statusCell.appendChild(label);
                row.appendChild(statusCell);

                // اثبات استلام الدفعة
                let proofCell = document.createElement('td');
                proofCell.classList.add('border', 'px-4', 'py-2');
                let proofInput = document.createElement('input');
                proofInput.type = 'file';
                proofInput.classList.add('input', 'file-input', 'my-5');
                proofInput.name = `installment_files_${supporterIndex}_${j}`;
                proofCell.appendChild(proofInput);
                row.appendChild(proofCell);

                tbody.appendChild(row);
            }

            table.appendChild(tbody);
            tableContainer.appendChild(table);
        }
    }

    function addReportInput(reports, i) {
        reports++

        let reportContentDiv = document.createElement('div');
        reportContentDiv.classList.add('my-4');

        let fileReport = document.createElement('input')
        fileReport.classList.add('input', 'file-input', 'my-2');
        fileReport.type = 'file'
        fileReport.name = `installment-report-${i}-${reports}`
        fileReport.id = `installment_report_file_${i}_${reports}`

        let removeReportButton = document.createElement('button');
        removeReportButton.type = 'button';
        removeReportButton.classList.add('btn', 'btn-xs', 'w-16', 'h-12', 'text-white', 'mx-4');
        removeReportButton.innerHTML = `<x-far-trash-can class="w-6 h-6 text-red-500" />`
        removeReportButton.name = 'remove-report';
        removeReportButton.id = 'remove_report';

        reportContentDiv.appendChild(fileReport)
        reportContentDiv.appendChild(removeReportButton)

        return [reportContentDiv, reports, removeReportButton]
    }

    function addFileInput(files, i) {
        files++
        let filesDivContent = document.createElement('div');
        filesDivContent.classList.add('my-4');

        let fileInput = document.createElement('input');
        fileInput.classList.add('input', 'file-input', 'my-2');
        fileInput.type = 'file';
        fileInput.name = `payment-report-${i}-${files}`
        fileInput.id = `payment_report_${i}_${files}`

        let removeFileButton = document.createElement('button')
        removeFileButton.classList.add('btn', 'btn-xs', 'w-16', 'h-12', 'text-white', 'mx-4');
        removeFileButton.type = 'button'
        removeFileButton.innerHTML = `<x-far-trash-can class="w-6 h-6 text-red-500" />`
        removeFileButton.name = 'remove-file'
        removeFileButton.id = 'remove_file'

        filesDivContent.appendChild(fileInput)
        filesDivContent.appendChild(removeFileButton)


        return [filesDivContent, files, removeFileButton]
    }

    function generateStagesTable(numStages) {
        let tableContainer = document.getElementById(`stages_table`);
        tableContainer.innerHTML = ''; // Clear any existing content

        if (numStages > 0) {
            // Create table element
            let table = document.createElement('table');
            table.classList.add('w-full', 'border', 'mt-2');

            // Create thead
            let thead = document.createElement('thead');
            let headerRow = document.createElement('tr');
            let headers = ['المرحلة', 'تكلفة المرحلة', 'حالة الصرف', 'اثبات الصرف'];

            headers.forEach(headerText => {
                let th = document.createElement('th');
                th.classList.add('border', 'px-4', 'py-2');
                th.textContent = headerText;
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Create tbody
            let tbody = document.createElement('tbody');

            for (let j = 1; j <= numStages; j++) {
                let row = document.createElement('tr');

                // المرحلة
                let stageCell = document.createElement('td');
                stageCell.classList.add('border', 'px-4', 'py-2');
                stageCell.textContent = j;
                row.appendChild(stageCell);

                // تكلفة المرحلة
                let amountCell = document.createElement('td');
                amountCell.classList.add('border', 'px-4', 'py-2');
                let amountInput = document.createElement('input');
                amountInput.type = 'number';
                amountInput.min = 0
                amountInput.name = `stages_amount_${j}`;
                amountInput.classList.add('input', 'w-full');
                amountCell.appendChild(amountInput);
                row.appendChild(amountCell);

                // حالة الصرف
                let statusCell = document.createElement('td');
                statusCell.classList.add('border', 'px-4', 'py-2');
                let label = document.createElement('label');
                label.classList.add('cursor-pointer', 'label', 'flex', 'gap-x-4', 'items-center');
                let span = document.createElement('span');
                span.classList.add('label-text');
                span.textContent = 'تم الصرف';
                let checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.classList.add('checkbox', 'checkbox-lg', 'border', '[--chkbg:theme(colors.cyan.500)]', '[--chkfg:white]');
                checkbox.name = `stages_status_${j}`;
                label.appendChild(checkbox);
                label.appendChild(span);
                statusCell.appendChild(label);
                row.appendChild(statusCell);

                // اثبات الصرف
                let proofCell = document.createElement('td');
                proofCell.classList.add('border', 'px-4', 'py-2');
                let proofInput = document.createElement('input');
                proofInput.type = 'file';
                proofInput.classList.add('input', 'file-input', 'my-5');
                proofInput.name = `stages_files_${j}`;
                proofCell.appendChild(proofInput);
                row.appendChild(proofCell);

                tbody.appendChild(row);
            }

            table.appendChild(tbody);
            tableContainer.appendChild(table);
        }
    }

    function removeReport(file) {
        file.remove()
    }
</script>
@endpush