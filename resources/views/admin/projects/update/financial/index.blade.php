@foreach($dashboard as $project)
<form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="my-5">
        @foreach($project->supporter as $supporter)
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
                                {{ $supporter->p_support_status === $status->value ? 'checked' : '' }} />
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="support-type-form hidden">
                <label class="font-normal text-base mb-2">نوع الدعم</label>
                <div class="bg-white flex gap-x-4 p-2 rounded">
                    @foreach (App\Enums\SupportType::cases() as $type)
                    <div class="form-control">
                        <label class="label cursor-pointer">
                            <span class="label-text">{{ $type->value }}</span>
                            <input type="radio" value="{{ $type->value }}" name="support-type" class="radio" id="support-type-{{ $type->value }}"
                                {{ $supporter->p_support_type === $type->value ? 'checked' : '' }} />
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
                                {{ $supporter->p_support_type === $type->value ? 'checked' : '' }} />
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <div class="supporter-data-full hidden" id="supporterDataSection">
        </div>
        <div class="supporter-data-part hidden" id="supporterDataSection">
        </div>
        <div class="supporter-comp-external hidden" id="supporterDataSection">
            <div class="grid grid-cols-2 gap-x-4 mt-8 gap-y-10 font-normal text-base">
                <div class="grid gap-y-5">
                    <label>اسم الجهة</label>
                    <input type="text" name="comp-name" value="{{ $supporter->supporter_name }}" class="input" />
                </div>
                <div class="grid gap-y-5">
                    <label>تكلفة المشروع</label>
                    <input type="text" name="income-project" value="{{ $project->total_cost }}" class="input" />
                </div>
                <div class="grid gap-y-5">
                    <label>عدد الدفعات</label>
                    <input type="number" id="installments-count" name="num-not-support" min="0" value="{{ $supporter->installments_count }}" class="input" />
                </div>
            </div>

            <div class="mt-4">
                <table class="w-full border mt-2 font-medium text-base table text-center">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">الدفعة</th>
                            <th class="border px-4 py-2">قيمة الدفعة</th>
                            <th class="border px-4 py-2">حالة استلام الدفعة</th>
                            <th class="border px-4 py-2">إثبات استلام الدفعة</th>
                        </tr>
                    </thead>
                    <tbody id="installments-table">
                        @foreach($installment as $key => $i)
                        <tr>
                            <td class="border px-4 py-2">{{ $key + 1 }}</td>
                            <td class="border px-4 py-2">
                                <input type="number" name="installments[{{ $key }}][amount]" min="0" class="input" value="{{ $i->installment_amount }}" />
                            </td>
                            <td class="border px-4 py-2">
                                <label class="label cursor-pointer">
                                    <input type="checkbox" name="installments[{{ $key }}][status]" class="checkbox" {{ $i->installment_receipt_status === 1 ? 'checked' : '' }} />
                                    <span class="label-text">تم استلام الدفعة</span>
                                </label>
                            </td>
                            <td class="border px-4 py-2">
                                @if($i->receipt_proof)
                                <div class="h-[4.1rem] bg-white rounded flex items-center justify-between">
                                    <div class="flex gap-x-5 p-4 items-center">
                                        <img src="{{ asset('assets/icons/pdf.png') }}" class="w-[1.4rem] h-7" alt="pdf" />
                                    </div>
                                    <a class="btn btn-md bg-[#FBFDFE] text-[#0F91D2]" href="{{ $i->receipt_proof }}" download>عرض الملف</a>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="supporter-comp-internal hidden" id="supporterDataSection">
            <div class="mt-8">
                <div class="grid">
                    <div class="grid grid-cols-2 gap-x-7">
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">تكلفة المشروع المتوقعة</label>
                            <input type="text" class="input" value="{{ $project->expected_cost }}" name="project-expected-income-not-support">
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">تكلفة المشروع الفعلية</label>
                            <input type="text" class="input" value="{{ $project->actual_cost }}" name="project-real-income-not-support">
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">عدد المراحل</label>
                            <input type="number" min="0" class="input" value="{{ $phases->last()->stages_count }}" name="stages-count-not-support" id="stages_count_not_support">
                        </div>
                    </div>
                    <div class="mt-4">
                        <table class="w-full border mt-2 table text-center">
                            <tr>
                                <th class="border px-4 py-2">المرحلة</th>
                                <th class="border px-4 py-2">تكلفة المرحلة</th>
                                <th class="border px-4 py-2">حالة الصرف</th>
                                <th class="border px-4 py-2">اثبات الصرف</th>
                            </tr>

                            <tbody id="phases-table">
                                @foreach( $phases as $key => $phase )
                                <tr class="border px-4 py-2">
                                    <td class="border px-4 py-2">{{ $key + 1 }}</td>
                                    <td class="border px-4 py-2">
                                        <input type="number" name="phases[{{ $key }}][amount]" min="0" class="input" value="{{ $phase->phase_cost }}" />
                                    </td>
                                    <td class="border px-4 py-2">
                                        <label class="label cursor-pointer">
                                            <input type="checkbox" name="phases[{{ $key }}][status]" class="checkbox" {{ $phase->disbursement_status === 1 ? 'checked' : '' }} />
                                            <span class="label-text">تم استلام الصرف</span>
                                        </label>
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($phase->disbursement_proof)
                                        <div class="h-[4.1rem] bg-white rounded flex items-center justify-between">
                                            <div class="flex gap-x-5 p-4 items-center">
                                                <img src="{{ asset('assets/icons/pdf.png') }}" class="w-[1.4rem] h-7" alt="pdf" />
                                            </div>
                                            <a class="btn btn-md bg-[#FBFDFE] text-[#0F91D2]" href="{{ $phase->disbursement_proof }}" download>عرض الملف</a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="join grid grid-cols-2 w-1/4 float-left">
        @if($step == 2 && $step < 8)
            <a type="submit" href="{{ route('admin.update.project', ['step' => $step - 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
            hover:bg-cyan-700/30 hover:text-cyan-700">
            السابق
            </a>
            <button type="submit" href="{{ route('admin.update.project', ['step' => $step + 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700 text-base text-white hover:bg-cyan-700">
                التالي
            </button>
            @endif
    </div>
</form>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function toggleForms() {
            let supportStatus = document.querySelector('input[name="support-status"]:checked')?.value;
            let supportType = document.querySelector('input[name="support-type"]:checked')?.value;
            let supporter = document.querySelector('input[name="supporter"]:checked')?.value;

            // Form containers
            let externalSupportForm = document.querySelector('.external-support');
            let supporterFullDataContainer = document.querySelector('.supporter-data-full');
            let supporterPartDataContainer = document.querySelector('.supporter-data-part');
            let externalSupportContainer = document.querySelector('.supporter-comp-external');
            let internalSupportContainer = document.querySelector('.supporter-comp-internal');
            let supportTypeForm = document.querySelector('.support-type-form');
            let numberSupportForm = document.querySelector('.number-support-form');
            let costSupportForm = document.querySelector('.cost-project-form');

            // Logic to show/hide forms
            if (supportStatus === 'مدعوم') {
                supportTypeForm?.classList.remove('hidden');
                externalSupportForm?.classList.add('hidden');
                if (supportType === 'كلي') {
                    supporterFullDataContainer?.classList.remove('hidden');
                } else if (supportType === 'جزئي') {
                    supporterPartDataContainer?.classList.remove('hidden');
                }
            } else if (supportStatus === 'غير مدعوم') {
                supportTypeForm?.classList.add('hidden');
                if (supporter === 'جهة خارجية') {
                    externalSupportForm?.classList.remove('hidden');
                    internalSupportContainer?.classList.add('hidden');
                    externalSupportContainer?.classList.remove('hidden');
                } else if (supporter === 'عون التقنية') {
                    externalSupportForm?.classList.remove('hidden');
                    externalSupportContainer?.classList.add('hidden');
                    internalSupportContainer?.classList.remove('hidden');
                }
            }
        }

        // Add event listeners
        document.querySelectorAll('input[name="support-status"]').forEach(radio => {
            radio.addEventListener('change', toggleForms);
        });

        document.querySelectorAll('input[name="support-type"]').forEach(radio => {
            radio.addEventListener('change', toggleForms);
        });

        document.querySelectorAll('input[name="supporter"]').forEach(radio => {
            radio.addEventListener('change', toggleForms);
        });

        // Initial call
        toggleForms();

        const installmentCountInput = document.getElementById("installments-count");
        const installmentsTable = document.getElementById("installments-table");
        let existingRows = @json($installment); // Existing installments from the database

        // Function to update the table rows dynamically
        function updateTableRows() {
            const newCount = parseInt(installmentCountInput.value) || 0;
            const currentCount = installmentsTable.children.length;

            // Add new rows if the count increases
            for (let i = currentCount; i < newCount; i++) {
                const row = document.createElement("tr");
                row.innerHTML = `
                <td class="border px-4 py-2">${i + 1}</td>
                <td class="border px-4 py-2">
                    <input type="number" name="installments[${i}][amount]" min="0" class="input" />
                </td>
                <td class="border px-4 py-2">
                    <label class="label cursor-pointer">
                        <input type="checkbox" name="installments[${i}][status]" class="checkbox" />
                        <span class="label-text">تم استلام الدفعة</span>
                    </label>
                </td>
                <td class="border">
                    <input type="file" name="installments[${i}][proof]" class="file-input file-input-md" />
                </td>
            `;
                installmentsTable.appendChild(row);
            }

            // Remove rows if the count decreases
            for (let i = currentCount - 1; i >= newCount; i--) {
                installmentsTable.removeChild(installmentsTable.children[i]);
            }
        }

        // Add event listener to handle input change
        installmentCountInput.addEventListener("input", updateTableRows);

        const phasesCountInput = document.getElementById("stages_count_not_support");
        const phasesTable = document.getElementById("phases-table");
        let existingPhaseRows = @json($phases);

        function updatePhaseRows() {
            const newCount = parseInt(phasesCountInput.value) || 0;
            const currentCount = phasesTable.children.length;

            for (let i = currentCount; i < newCount; i++) {
                const row = document.createElement("tr");
                row.innerHTML = `
                <td class="border px-4 py-2">${ i + 1 }</td>
                <td class="border px-4 py-2">
                    <input type="number" name="phases[${ i }][amount]" min="0" class="input" />
                </td>
                <td class="border px-4 py-2">
                    <label class="label cursor-pointer">
                        <input type="checkbox" name="phases[${ i }][status]" class="checkbox" />
                        <span class="label-text">تم استلام الصرف</span>
                    </label>
                </td>
                <td class="border">
                    <input type="file" name="phases[${i}][proof]" class="file-input file-input-md" />
                </td>
            `;
                phasesTable.appendChild(row);
            }

            // Remove rows if the count decreases
            for (let i = currentCount - 1; i >= newCount; i--) {
                phasesTable.removeChild(phasesTable.children[i]);
            }
        }

        // Add event listener to handle input change
        phasesCountInput.addEventListener("input", updatePhaseRows);
    });
</script>
@endpush