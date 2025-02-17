@foreach($dashboard as $project)
<form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="my-5">
        @foreach($project->supporter->unique('projects_id') as $supporter)
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

            <div class="grid my-8 number-support-form">
                <label class="font-normal text-base mb-2">عدد الجهات الداعمة</label>
                <input type="number" min="0" value="{{ $supporter->supporter_number }}" class="input" name="number-support" id="number_support" />
            </div>
            <div class="grid my-8 cost-project-form">
                <label class="font-normal text-base mb-2">إجمالي تكلفة المشروع</label>
                <input type="number" min="0" class="input" name="project-income" value="{{ $project->total_cost }}" />
            </div>
        </div>
        @endforeach

        <div class="supporter-data-full hidden" id="supporterDataSection">
            @foreach($project->supporter as $key => $supporter)
            @if($supporter->supporter_number > 0)
            <div class="supporter-div" id="supporter_div">
                <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم {{ $key + 1  }}</h1>

                <div class="grid grid-cols-2 gap-x-7">
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">الجهة الداعمة</label>
                        <input class="input" name="comp-support-{{ $key+1 }}" value="{{ $supporter->supporter_name }}">
                    </div>

                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم</label>
                        <input class="input" name="project-income-total-{{ $key+1 }}" value="{{ $supporter->support_amount }}">
                    </div>

                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">عدد الدفعات</label>
                        <input class="input" type="number" min="0" id="payment_count_{{ $key+1 }}" name="payment-count-{{ $key+1 }}" value="{{ $supporter->installments_count }}">
                    </div>
                </div>

                <div class="mt-4">
                    <table class="w-full border mt-2 font-medium text-base table text-center">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">الدفعة</th>
                                <th class="border px-4 py-2">قيمة الدفعة</th>
                                <th class="border px-4 py-2">حالة استلام الدفعة</th>
                                <th class="border px-4 py-2">اثبات استلام الدفعة</th>
                            </tr>
                        </thead>
                        <tbody id="payment-table-{{ $key+1 }}">
                            @if($supporter->installments_count > 0)
                            @foreach($installment[$supporter->id] as $index => $i)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">
                                    <input type="number" name="payments[{{ $key+1 }}][{{ $index+1 }}][amount]" min="0" class="input" value="{{ $i->installment_amount }}" />
                                </td>
                                <td class="border px-4 py-2">
                                    <label class="label cursor-pointer">
                                        <input type="checkbox" name="payments[{{ $key+1 }}][{{ $index+1 }}][status]" class="checkbox"
                                            {{ $i->installment_receipt_status === 1 ? 'checked' : '' }} />
                                        <span class="label-text">تم استلام الدفعة</span>
                                    </label>
                                </td>
                                <td class="border px-4 py-2">
                                    @if(preg_match('/\.(jpg|jpeg|png|pdf)$/i', basename($i->reciept_proof)))
                                    <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]"
                                        href="{{ $i->reciept_proof }}" download="">عرض الملف</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-2 my-14 text-base font-normal gap-x-9">
                    <div class="installment-report my-4" id="installment_report_${i}">
                        <div class="flex gap-x-4 my-7">
                            <p>تقارير للجهة الداعمة</p>
                        </div>
                        <div class="grid gap-y-4">
                            @if($supporter->report_files)
                            @foreach(json_decode($supporter->report_files) as $report)
                            <div class="h-[4.1rem] bg-white rounded flex justify-between">
                                <div class="flex gap-x-5 p-4 items-center">
                                    <img src="{{ asset("assets/icons/pdf.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                                </div>
                                <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $report->report }}" download="">عرض الملف</a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="installment-files my-4" id="installment_files_${i}">
                        <div class="flex gap-x-4 my-7">
                            <p>أوامر الصرف</p>
                        </div>
                        <div class="grid gap-y-4">
                            @if($supporter->payment_order_files)
                            @foreach(json_decode($supporter->payment_order_files) as $file)
                            <div class="h-[4.1rem] bg-white rounded flex justify-between">
                                <div class="flex gap-x-5 p-4 items-center">
                                    <img src="{{ asset("assets/icons/pdf.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                                </div>
                                <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $file->payment_order ?? '' }}" download="">عرض الملف</a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="supporter-data-part hidden" id="partSupporterDataSection">
            @foreach($project->supporter as $key => $supporter)
            @if($supporter->supporter_number > 0)
            <div class="supporter-div">
                <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم {{ $key + 1 }}</h1>

                <div class="grid grid-cols-2 gap-x-7">
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">الجهة الداعمة</label>
                        <input class="input" value="{{ $supporter->supporter_name }}">
                    </div>

                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم</label>
                        <input class="input" value="{{ $supporter->support_amount }}">
                    </div>

                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">عدد الدفعات</label>
                        <input class="input" value="{{ $supporter->installments_count }}">
                    </div>
                </div>

                <div class="mt-4">
                    <table class="w-full border mt-2 font-medium text-base table text-center">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">الدفعة</th>
                                <th class="border px-4 py-2">قيمة الدفعة</th>
                                <th class="border px-4 py-2">حالة استلام الدفعة</th>
                                <th class="border px-4 py-2">اثبات استلام الدفعة</th>
                            </tr>
                        </thead>
                        <tbody id="payment-table-{{ $key+1 }}">
                            @if($supporter->installments_count > 0)
                            @foreach($installment[$supporter->id] as $index => $i)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">
                                    <input type="number" name="payments[{{ $key+1 }}][{{ $index+1 }}][amount]" min="0" class="input" value="{{ $i->installment_amount }}" />
                                </td>
                                <td class="border px-4 py-2">
                                    <label class="label cursor-pointer">
                                        <input type="checkbox" name="payments[{{ $key+1 }}][{{ $index+1 }}][status]" class="checkbox"
                                            {{ $i->installment_receipt_status === 1 ? 'checked' : '' }} />
                                        <span class="label-text">تم استلام الدفعة</span>
                                    </label>
                                </td>
                                <td class="border px-4 py-2">
                                    @if(preg_match('/\.(jpg|jpeg|png|pdf)$/i', basename($i->reciept_proof)))
                                    <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]"
                                        href="{{ $i->reciept_proof }}" download="">عرض الملف</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-2 my-14 text-base font-normal gap-x-9">
                    <div class="installment-report my-4" id="installment_report_${i}">
                        <div class="flex gap-x-4 my-7">
                            <p>تقارير للجهة الداعمة</p>
                        </div>
                        <div class="grid gap-y-4">
                            @if($supporter->report_files)
                            @foreach(json_decode($supporter->report_files) as $report)
                            <div class="h-[4.1rem] bg-white rounded flex justify-between" key="{{ $i }}">
                                <div class="flex gap-x-5 p-4 items-center">
                                    <img src="{{ asset("assets/icons/pdf.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                                </div>
                                <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $report->report }}" download="">عرض الملف</a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="installment-files my-4">
                        <div class="flex gap-x-4 my-7">
                            <p>أوامر الصرف</p>
                        </div>
                        <div class="grid gap-y-4">
                            @if($supporter->payment_order_files)
                            @foreach(json_decode($supporter->payment_order_files) as $file)
                            <div class="h-[4.1rem] bg-white rounded flex justify-between">
                                <div class="flex gap-x-5 p-4 items-center">
                                    <img src="{{ asset("assets/icons/pdf.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                                </div>
                                <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $file->payment_order ?? '' }}" download="">عرض الملف</a>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="financ-part-support">
            <h1 class="font-bold text-base mt-4">البيانات المالية للجزء الغير مدعوم</h1>
            <div class="grid">
                <div class="grid grid-cols-2 gap-x-7">
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">
                            تكلفة المشروع المتوقعة
                            <span class="text-red-600">*</span>
                        </label>
                        <input type="number" min="0" name="project-expected-income" class="input" value="{{ $project->expected_cost }}">
                    </div>
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">
                            تكلفة المشروع الفعلية
                            <span class="text-red-600">*</span>
                        </label>
                        <input type="number" min="0" class="input" name="project-expected-real" value="{{ $project->actual_cost }}">
                    </div>
                    <div class="grid my-2">
                        <label class="font-normal text-base mb-2">
                            عدد المراحل
                            <span class="text-red-600">*</span>
                        </label>
                        <input type="number" name="stages-count" min="0" class="input" value="{{ $phases->last()->stages_count ?? 0 }}" id="stages_count">
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

                        <tbody id="phases_table">
                            @foreach($phases as $key => $phase)
                            @if($phase->stages_count > 0)
                            <tr>
                                <td class="border px-4 py-2">{{ $key + 1}}</td>
                                <td class="border px-4 py-2">
                                    <input type="number" value="{{ $phase->phase_cost }}" name="stages[{{ $key+1 }}][amount]" min="0" class="input" />
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="checkbox" name="stages[{{ $key+1 }}][status]" class="checkbox"
                                        {{ $phase->disbursement_status === 1 ? 'checked' : '' }} />
                                </td>
                                <td class="border px-4 py-2">
                                    @if(preg_match('/\.(jpg|jpeg|png|pdf)$/i', basename($phase->disbursement_proof)))
                                    <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]"
                                        href="{{ $phase->disbursement_proof }}" download="">عرض الملف</a>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="supporter-comp-external hidden">
            @foreach($project->supporter as $key => $supporter)
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
                        @if(isset($installment[$supporter->id]))
                        @foreach($installment[$supporter->id] as $key => $i)
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
                                @if(preg_match('/\.(jpg|jpeg|png|pdf)$/i', basename($i->receipt_proof)))
                                <div class="h-[4.1rem] bg-white rounded flex items-center justify-between">
                                    <a class="btn btn-md bg-[#FBFDFE] text-[#0F91D2]" href="{{ $i->receipt_proof }}" download>عرض الملف</a>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>

        <div class="supporter-comp-internal hidden">
            <div class="mt-8">
                <div class="grid">
                    <div class="grid grid-cols-2 gap-x-7">
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">تكلفة المشروع المتوقعة</label>
                            <input type="text" class="input" value="{{ $project->expected_cost }}" name="project-expected-income-not-support">
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">تكلفة المشروع الفعلية</label>
                            <input type="text" class="input" value="{{ $project->total_cost }}" name="project-real-income-not-support">
                        </div>
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">عدد المراحل</label>
                            <input type="number" min="0" class="input" value="{{ $phases->last()->stages_count ?? 0 }}" name="stages-count-not-support" id="stages_count_not_support">
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
            let financePartSupport = document.querySelector('.financ-part-support');

            // Logic to show/hide forms
            if (supportStatus === 'مدعوم') {
                supportTypeForm?.classList.remove('hidden');
                externalSupportForm?.classList.add('hidden');
                if (supportType === 'كلي') {
                    costSupportForm?.classList.remove('hidden')
                    numberSupportForm?.classList.remove('hidden')
                    supporterFullDataContainer?.classList.remove('hidden');
                    externalSupportContainer?.classList.add('hidden');
                    externalSupportForm?.classList.add('hidden');
                    internalSupportContainer?.classList.add('hidden');
                    financePartSupport.classList.add('hidden')
                } else if (supportType === 'جزئي') {
                    supporterPartDataContainer?.classList.remove('hidden');
                    financePartSupport.classList.remove('hidden')
                }
            } else if (supportStatus === 'غير مدعوم') {
                supportTypeForm?.classList.add('hidden');
                externalSupportForm?.classList.remove('hidden');
                if (supporter === 'جهة خارجية') {
                    financePartSupport.classList.add('hidden')
                    costSupportForm?.classList.add('hidden')
                    numberSupportForm?.classList.add('hidden')
                    supporterFullDataContainer?.classList.add('hidden');
                    externalSupportForm?.classList.remove('hidden');
                    internalSupportContainer?.classList.add('hidden');
                    externalSupportContainer?.classList.remove('hidden');
                } else if (supporter === 'عون التقنية') {
                    costSupportForm?.classList.add('hidden')
                    numberSupportForm?.classList.add('hidden')
                    supporterFullDataContainer?.classList.add('hidden');
                    externalSupportForm?.classList.remove('hidden');
                    internalSupportContainer?.classList.remove('hidden');
                    externalSupportContainer?.classList.add('hidden');
                    financePartSupport.classList.remove('hidden')
                }
            }
        }
        document.querySelectorAll('input[name="support-status"]').forEach(radio => {
            radio.addEventListener('change', toggleForms);
        });

        document.querySelectorAll('input[name="support-type"]').forEach(radio => {
            radio.addEventListener('change', toggleForms);
        });

        document.querySelectorAll('input[name="supporter"]').forEach(radio => {
            radio.addEventListener('change', toggleForms);
        });
        toggleForms();

        let installmentCountInput = document.getElementById("installments-count");
        let installmentsTable = document.getElementById("installments-table");

        function updateTableRows() {
            let newCount = parseInt(installmentCountInput.value) || 0;
            let currentCount = installmentsTable.children.length;
            for (let i = currentCount; i < newCount; i++) {
                let row = document.createElement("tr");
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
                    <input type="file" name="installments[${i}][proof]" class="file-input" />
                </td>
            `;
                installmentsTable.appendChild(row);
            }

            // Remove rows if the count decreases
            for (let i = currentCount - 1; i >= newCount; i--) {
                installmentsTable.removeChild(installmentsTable.children[i]);
            }
        }
        installmentCountInput.addEventListener("input", updateTableRows);

        let numSupport = document.getElementById('number_support') //عدد الجهات الداعمة

        let supporterContainer = document.getElementById("supporterDataSection")

        let partSupporterContainer = document.getElementById('partSupporterDataSection')

        function updatePartSupport() {
            let newCount = parseInt(numSupport.value) || 0;
            let currentCount = partSupporterContainer.children.length;
            for (let i = currentCount; i < newCount; i++) {
                let container = document.createElement("div")
                container.innerHTML = `
                    <div class="supporter-div">
                    <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم ${i+1}</h1>

                    <div class="grid grid-cols-2 gap-x-7">
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">الجهة الداعمة</label>
                            <input class="input" name="comp-support-${i+1}">
                        </div>

                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم</label>
                            <input class="input" name="project-income-total-${i+1}">
                        </div>

                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">عدد الدفعات</label>
                            <input class="input" name="payment-count-${i+1}" id="payment_count_${i+1}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <table class="w-full border mt-2 font-medium text-base table text-center">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">الدفعة</th>
                                    <th class="border px-4 py-2">قيمة الدفعة</th>
                                    <th class="border px-4 py-2">حالة استلام الدفعة</th>
                                    <th class="border px-4 py-2">اثبات استلام الدفعة</th>
                                </tr>
                            </thead>
                            <tbody id="payment-table-${i+1}"></tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-2 my-14 text-base font-normal gap-x-9">
                        <div class="grid grid-cols-2 my-14 text-base font-normal gap-x-9">
                            <div class="installment-report my-4" id="installment_report_${i+1}">
                                <div class="flex gap-x-4 my-7">
                                    <p>تقارير للجهة الداعمة</p>
                                </div>
                                <div class="grid gap-y-4">
                                <input type="file" name="payments[${i+1}][report]" class="file-input" />
                                </div>
                            </div>

                            <div class="installment-files my-4" id="installment_files_${i+1}">
                                <div class="flex gap-x-4 my-7">
                                    <p>أوامر الصرف</p>
                                </div>
                                <div class="grid gap-y-4">
                                <input type="file" name="payments[${i+1}][order]" class="file-input" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `
                partSupporterContainer.appendChild(container)
            }
            for (let i = currentCount - 1; i >= newCount; i--) {
                partSupporterContainer.removeChild(partSupporterContainer.children[i]);
            }
        }
        numSupport.addEventListener("input", updatePartSupport)

        function updateSupportContainer() {
            let newCount = parseInt(numSupport.value) || 0;
            let currentCount = supporterContainer.children.length;
            for (let i = currentCount; i < newCount; i++) {
                let container = document.createElement("div")
                container.innerHTML = `
                <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم ${i + 1}</h1>

                    <div class="grid grid-cols-2 gap-x-7">
                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">الجهة الداعمة</label>
                            <input class="input" name="comp-support-${i+1}">
                        </div>

                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم</label>
                            <input class="input" name="project-income-total-${i+1}">
                        </div>

                        <div class="grid my-2">
                            <label class="font-normal text-base mb-2">عدد الدفعات</label>
                            <input class="input" min="0" type="number" id="payment_count_${i+1}" name="payment-count-${i+1}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <table class="w-full border mt-2 font-medium text-base table text-center">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">الدفعة</th>
                                    <th class="border px-4 py-2">قيمة الدفعة</th>
                                    <th class="border px-4 py-2">حالة استلام الدفعة</th>
                                    <th class="border px-4 py-2">اثبات استلام الدفعة</th>
                                </tr>
                            </thead>
                            <tbody id="payment-table-${i+1}"></tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-2 my-14 text-base font-normal gap-x-9">
                        <div class="installment-report my-4" id="installment_report_${i+1}">
                            <div class="flex gap-x-4 my-7">
                                <p>تقارير للجهة الداعمة</p>
                            </div>
                            <div class="grid gap-y-4">
                            <input type="file" name="payments[${i+1}][report]" class="file-input" />
                            </div>
                        </div>

                        <div class="installment-files my-4" id="installment_files_${i+1}">
                            <div class="flex gap-x-4 my-7">
                                <p>أوامر الصرف</p>
                            </div>
                            <div class="grid gap-y-4">
                            <input type="file" name="payments[${i+1}][order]" class="file-input" />
                            </div>
                        </div>
                    </div>
                `
                let paymentCountInput = document.getElementById(`payment_count_${i+1}`)
                let paymentSupportTable = document.getElementById(`payment-table-${i+1}`)
                
                paymentCountInput.addEventListener("input", function() {
                    let newCountPayment = parseInt(paymentCountInput.value) || 0
                    let currentCountPayment = paymentSupportTable.children.length
                    for (let j = currentCountPayment; j < newCountPayment; j++) {
                        let tableContainer = document.createElement('tr')
                        tableContainer.classList.add('mt-4')
                        tableContainer.innerHTML = `
                            <td class="border px-4 py-2">${ j + 1 }</td>
                            <td class="border px-4 py-2">
                                <input type="number" name="payments[${i+1}][${j+1}][amount]" min="0" class="input" />
                            </td>
                            <td class="border px-4 py-2">
                                <label class="label cursor-pointer">
                                    <input type="checkbox" name="payments[${i+1}][${j+1}][status]" class="checkbox" />
                                    <span class="label-text">تم استلام الدفعة</span>
                                </label>
                            </td>
                            <td class="border">
                                <input type="file" name="payments[${i+1}][${j+1}][proof]" class="file-input" />
                            </td>
                        `
                        paymentSupportTable.appendChild(tableContainer)
                        container.appendChild(paymentSupportTable)
                    }
                    supporterContainer.appendChild(container);
                    for (let index = currentCountPayment - 1; index >= newCountPayment; index--) {
                        paymentSupportTable.removeChild(paymentSupportTable.children[index])
                    }
                })
            }
            for (let i = currentCount - 1; i >= newCount; i--) {
                supporterContainer.removeChild(supporterContainer.children[i]);
            }
        }
        numSupport.addEventListener("input", updateSupportContainer)

        let paymentCountInput = document.getElementById(`stages_count`)
        let paymentTable = document.getElementById(`phases_table`)

        function updatePhasePartRows() {
            let newCount = parseInt(paymentCountInput.value) || 0;
            let currentCount = paymentTable.children.length;


            for (let i = currentCount; i < newCount; i++) {
                let row = document.createElement("tr");
                row.innerHTML = `
                <td class="border px-4 py-2">${i+1}</td>
                <td class="border px-4 py-2">
                    <input type="number" name="phases[${i+1}][amount]" min="0" class="input" />
                </td>
                <td class="border px-4 py-2">
                    <label class="label cursor-pointer">
                        <input type="checkbox" name="phases[${i+1}][status]" class="checkbox" />
                        <span class="label-text">تم استلام الصرف</span>
                    </label>
                </td>
                <td class="border">
                    <input type="file" name="phases[${i+1}][proof]" class="file-input" />
                </td>
            `;
                paymentTable.appendChild(row);
            }
            for (let i = currentCount - 1; i >= newCount; i--) {
                paymentTable.removeChild(paymentTable.children[i]);
            }
        }
        paymentCountInput.addEventListener("input", updatePhasePartRows)

        let phasesCountInput = document.getElementById("stages_count_not_support");
        let phasesTable = document.getElementById(`phases-table`);

        function updatePhaseRows() {
            let newCount = parseInt(phasesCountInput.value) || 0;
            let currentCount = phasesTable.children.length;
            for (let i = currentCount; i < newCount; i++) {
                let row = document.createElement("tr");
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
                    <input type="file" name="phases[${i}][proof]" class="file-input" />
                </td>
            `;
                phasesTable.appendChild(row);
            }

            // Remove rows if the count decreases
            for (let i = currentCount - 1; i >= newCount; i--) {
                phasesTable.removeChild(phasesTable.children[i]);
            }
        }
        phasesCountInput.addEventListener("input", updatePhaseRows);
    });
</script>
@endpush