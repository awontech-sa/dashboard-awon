<div class="my-14">
    <div class="grid grid-cols-2 gap-x-6">
        <div>
            <label class="font-normal text-base mb-2">حالة الدعم <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $supporter->p_support_status ?? '' }}</span>
                        <input
                            type="radio"
                            name="support-status"
                            value="{{ $supporter->p_support_status ?? '' }}"
                            class="radio"
                            id="support-status-{{ $supporter->id }}"
                            checked />
                    </label>
                </div>
            </div>
        </div>
        @if($supporter->p_support_type === 'كلي' || $supporter->p_support_type === 'جزئي')
        <div class="support-type-form">
            <label class="font-normal text-base mb-2">نوع الدعم <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $supporter->p_support_type ?? '' }}</span>
                        <input type="radio" value="{{ $supporter->p_support_type ?? '' }}" name="support-type" class="radio" id="support-type-{{ $supporter->id }}" checked />
                    </label>
                </div>
            </div>
        </div>
        @else
        <div class="external-support">
            <label class="font-normal text-base mb-2">مالك المشروع <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $supporter->p_support_type ?? '' }}</span>
                        <input type="radio" value="{{ $supporter->p_support_type ?? '' }}" name="supporter" class="radio" id="support-comp-{{ $supporter->id }}" checked />
                    </label>
                </div>
            </div>
        </div>
        @endif

        @if($supporter->p_support_type === 'كلي' || $supporter->p_support_type === 'جزئي')
        <div class="grid my-8 number-support-form">
            <label class="font-normal text-base mb-2">عدد الجهات الداعمة <span class="text-red-600">*</span></label>
            <input disabled type="number" min="0" class="input" name="number-support" id="number_support" />
        </div>
        <div class="grid my-8 cost-project-form">
            <label class="font-normal text-base mb-2">إجمالي تكلفة المشروع <span class="text-red-600">*</span></label>
            <input disabled type="number" min="0" class="input" name="project-income" />
        </div>
        @endif
    </div>
    @if($supporter->p_support_status === 'غير مدعوم' && $supporter->p_support_type === 'عون التقنية')
    @include('admin.projects.project.financial.internal')
    @elseif($supporter->p_support_status === 'غير مدعوم' && $supporter->p_support_type === 'جهة خارجية')
    @include('admin.projects.project.financial.external')
    @endif
</div>

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
        let supportForm = document.querySelector('.support-type-form');
        let numberSupportForm = document.querySelector('.number-support-form');
        let isSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'مدعوم';
        let isNotSupported = document.querySelector('input[name="support-status"]:checked')?.value === 'غير مدعوم';
        let isFullSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'كلي';
        let isPartSupport = document.querySelector('input[name="support-type"]:checked')?.value === 'جزئي';
        let isExternalSupport = document.querySelector('input[name="supporter"]:checked')?.value === 'جهة خارجية';
        let isEnternalSupport = document.querySelector('input[name="supporter"]:checked')?.value === 'عون التقنية'

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
                    let [reportFiles, reports, removeReportBtn] = addReportInput(countReport);
                    reportDiv.appendChild(reportFiles);
                    countReport = reports
                    hiddenCountReport.value = countReport

                    removeReportBtn.onclick = () => {
                        removeReport(reportFiles)
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
                    let [pyamentFiles, payments, removeFileBtn] = addFileInput(paymentCountFiles)
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
                    let [reportFiles, reports, removeReportBtn] = addReportInput(countReport);
                    reportDiv.appendChild(reportFiles);
                    countReport = reports
                    hiddenCountReport.value = countReport

                    removeReportBtn.onclick = () => {
                        removeReport(reportFiles)
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
                    let [pyamentFiles, payments, removeFileBtn] = addFileInput(paymentCountFiles)
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

                let finanDataNotSupport = document.createElement('div')
                let finanDataNotSupportHeading = document.createElement('h1');
                finanDataNotSupportHeading.classList.add('font-bold', 'text-base', 'mt-4')
                finanDataNotSupportHeading.textContent = 'البيانات المالية للجزء الغير مدعوم'
                finanDataNotSupport.appendChild(finanDataNotSupportHeading)
                supporterDataContainer.appendChild(finanDataNotSupport)

                let finanDataContainer = document.createElement('div')
                finanDataContainer.classList.add('grid')
                let finanData = document.createElement('div')
                finanData.classList.add('grid', 'grid-cols-2', 'gap-x-7')
                let projectExpectIncomeContainer = document.createElement('div')
                projectExpectIncomeContainer.classList.add('grid', 'my-2')
                let projectExpectIncomeLabel = document.createElement('label')
                projectExpectIncomeLabel.classList.add('font-normal', 'text-base', 'mb-2')
                projectExpectIncomeLabel.textContent = 'تكلفة المشروع المتوقعة'
                let projectExpectIncomeImportant = document.createElement('span')
                projectExpectIncomeImportant.classList.add('text-red-600')
                projectExpectIncomeImportant.textContent = '*'
                projectExpectIncomeLabel.appendChild(projectExpectIncomeImportant)
                let projectExpectIncomeInput = document.createElement('input')
                projectExpectIncomeInput.type = 'text'
                projectExpectIncomeInput.classList.add('input')
                projectExpectIncomeInput.name = `project-expected-income-${i}`
                projectExpectIncomeContainer.appendChild(projectExpectIncomeLabel)
                projectExpectIncomeContainer.appendChild(projectExpectIncomeInput)
                finanData.appendChild(projectExpectIncomeContainer)

                let projectExpectRealContainer = document.createElement('div')
                projectExpectRealContainer.classList.add('grid', 'my-2')
                let projectExpectRealLabel = document.createElement('label')
                projectExpectRealLabel.classList.add('font-normal', 'text-base', 'mb-2')
                projectExpectRealLabel.textContent = 'تكلفة المشروع الفعلية'
                let projectExpectRealImportant = document.createElement('span')
                projectExpectRealImportant.classList.add('text-red-600')
                projectExpectRealImportant.textContent = '*'
                projectExpectRealLabel.appendChild(projectExpectRealImportant)
                let projectExpectRealInput = document.createElement('input')
                projectExpectRealInput.type = 'text'
                projectExpectRealInput.classList.add('input')
                projectExpectRealInput.name = `project-expected-real-${i}`
                projectExpectRealContainer.appendChild(projectExpectRealLabel)
                projectExpectRealContainer.appendChild(projectExpectRealInput)
                finanData.appendChild(projectExpectRealContainer)

                let stagesNumberContainer = document.createElement('div')
                stagesNumberContainer.classList.add('grid', 'my-2')
                let stagesNumberLabel = document.createElement('label')
                stagesNumberLabel.classList.add('font-normal', 'text-base', 'mb-2')
                stagesNumberLabel.textContent = 'عدد المراحل'
                let stagesNumberImportant = document.createElement('span')
                stagesNumberImportant.classList.add('text-red-600')
                stagesNumberImportant.textContent = '*'
                stagesNumberLabel.appendChild(stagesNumberImportant)
                let stagesNumberInput = document.createElement('input')
                stagesNumberInput.type = 'number'
                stagesNumberInput.classList.add('input')
                stagesNumberInput.name = `stages-count-${i}`
                stagesNumberInput.id = `stages_count_${i}`
                stagesNumberContainer.appendChild(stagesNumberLabel)
                stagesNumberContainer.appendChild(stagesNumberInput)
                finanData.appendChild(stagesNumberContainer)

                finanDataContainer.appendChild(finanData)

                let stagesTable = document.createElement('div')
                stagesTable.classList.add('stages-table', 'mt-4')
                stagesTable.id = `stages_table_${i}`
                finanDataContainer.appendChild(stagesTable)

                finanDataNotSupport.appendChild(finanDataContainer)

                document.getElementById(`stages_count_${i}`).addEventListener('input', function() {
                    generateStagesTable(i, this.value);
                });
                document.getElementById(`payment_count_${i}`).addEventListener('input', function() {
                    generateInstallmentTable(i, this.value);
                });
            }
        }

        if (isNotSupported && isExternalSupport) {
            notSupporterDataContainer.classList.remove('hidden');
            notSupporterDataContainer.innerHTML = '';

            let formContainer = document.createElement('div');
            formContainer.classList.add('grid', 'grid-cols-3', 'gap-x-4', 'mt-8');

            let nameLabelDiv = document.createElement('div');
            let nameLabel = document.createElement('label');
            nameLabel.textContent = 'اسم الجهة ';
            let requiredSpan1 = document.createElement('span');
            requiredSpan1.classList.add('text-red-600');
            requiredSpan1.textContent = '*';
            nameLabel.appendChild(requiredSpan1);
            let nameInput = document.createElement('input');
            nameInput.classList.add('input');
            nameInput.name = 'comp-name'
            nameLabelDiv.appendChild(nameLabel);
            nameLabelDiv.appendChild(nameInput);

            let costLabelDiv = document.createElement('div');
            let costLabel = document.createElement('label');
            costLabel.textContent = 'تكلفة المشروع ';
            let requiredSpan2 = document.createElement('span');
            requiredSpan2.classList.add('text-red-600');
            requiredSpan2.textContent = '*';
            costLabel.appendChild(requiredSpan2);
            let costInput = document.createElement('input');
            costInput.classList.add('input');
            costInput.name = 'income-project'
            costLabelDiv.appendChild(costLabel);
            costLabelDiv.appendChild(costInput);

            let installmentLabelDiv = document.createElement('div');
            let installmentLabel = document.createElement('label');
            installmentLabel.textContent = 'عدد الدفعات ';
            let requiredSpan3 = document.createElement('span');
            requiredSpan3.classList.add('text-red-600');
            requiredSpan3.textContent = '*';
            installmentLabel.appendChild(requiredSpan3);
            let installmentInput = document.createElement('input');
            installmentInput.classList.add('input');
            installmentInput.type = 'number';
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

        }
    }

    function addReportInput(reports) {
        reports++

        let reportContentDiv = document.createElement('div');
        reportContentDiv.classList.add('my-4');

        let fileReport = document.createElement('input')
        fileReport.classList.add('input', 'file-input', 'my-2');
        fileReport.type = 'file'
        fileReport.name = `installment-report-${reports}`
        fileReport.id = `installment_report_file_${reports}`

        let removeReportButton = document.createElement('button');
        removeReportButton.type = 'button';
        removeReportButton.classList.add('btn', 'btn-error', 'btn-xs', 'w-16', 'h-12', 'text-white', 'mx-4');
        removeReportButton.textContent = 'حذف'
        removeReportButton.name = 'remove-report';
        removeReportButton.id = 'remove_report';

        reportContentDiv.appendChild(fileReport)
        reportContentDiv.appendChild(removeReportButton)

        return [reportContentDiv, reports, removeReportButton]
    }

    function addFileInput(files) {
        files++
        let filesDivContent = document.createElement('div');
        filesDivContent.classList.add('my-4');

        let fileInput = document.createElement('input');
        fileInput.classList.add('input', 'file-input', 'my-2');
        fileInput.type = 'file';
        fileInput.name = `payment-report-${files}`
        fileInput.id = `payment_report_${files}`

        let removeFileButton = document.createElement('button')
        removeFileButton.classList.add('btn', 'btn-error', 'btn-xs', 'w-16', 'h-12', 'text-white', 'mx-4');
        removeFileButton.type = 'button'
        removeFileButton.textContent = 'حذف'
        removeFileButton.name = 'remove-file'
        removeFileButton.id = 'remove_file'

        filesDivContent.appendChild(fileInput)
        filesDivContent.appendChild(removeFileButton)


        return [filesDivContent, files, removeFileButton]
    }

    function generateStagesTable(supporterIndex, numStages) {
        let tableContainer = document.getElementById(`stages_table_${supporterIndex}`);
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
                amountInput.name = `stages_amount_${supporterIndex}_${j}`;
                amountInput.classList.add('input', 'w-full');
                amountCell.appendChild(amountInput);
                row.appendChild(amountCell);

                // حالة الصرف
                let statusCell = document.createElement('td');
                statusCell.classList.add('border', 'px-4', 'py-2');
                let label = document.createElement('label');
                label.classList.add('cursor-pointer', 'label');
                let span = document.createElement('span');
                span.classList.add('label-text');
                span.textContent = 'تم الصرف';
                let checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.classList.add('checkbox');
                checkbox.name = `stages_status_${supporterIndex}_${j}`;
                label.appendChild(span);
                label.appendChild(checkbox);
                statusCell.appendChild(label);
                row.appendChild(statusCell);

                // اثبات الصرف
                let proofCell = document.createElement('td');
                proofCell.classList.add('border', 'px-4', 'py-2');
                let proofInput = document.createElement('input');
                proofInput.type = 'file';
                proofInput.classList.add('input', 'file-input', 'my-5');
                proofInput.name = `stages_files_${supporterIndex}_${j}`;
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