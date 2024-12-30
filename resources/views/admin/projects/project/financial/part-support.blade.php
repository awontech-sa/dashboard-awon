@foreach($supporter as $key => $s)
@if($s->supporter_number > 0)
<div class="supporter-div">
    <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم {{ $key+1 }}</h1>

    <div class="grid grid-cols-2 gap-x-7">
        <div class="grid my-2">
            <label class="font-normal text-base mb-2">الجهة الداعمة</label>
            <input class="input" disabled value="{{ $s->supporter_name }}">
        </div>

        <div class="grid my-2">
            <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم</label>
            <input class="input" disabled value="{{ $s->support_amount }}">
        </div>

        <div class="grid my-2">
            <label class="font-normal text-base mb-2">عدد الدفعات</label>
            <input class="input" disabled value="{{ $s->installments_count }}">
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
            <tbody>
                @if(isset($installment[$s->id]))
                @foreach($installment[$s->id] as $key => $i)
                <tr>
                    <td class="border px-4 py-2">{{ $key + 1 }}</td>
                    <td class="border px-4 py-2">{{ $i->installment_amount }}</td>
                    <td class="border px-4 py-2">
                        <label class="label cursor-pointer">
                            <input type="checkbox" disabled class="checkbox"
                                {{ $i->installment_receipt_status ? 'checked' : '' }} />
                            <span class="label-text">تم استلام الدفعة</span>
                        </label>
                    </td>
                    <td class="border px-4 py-2">
                        @if(preg_match('/\.(jpg|jpeg|png|pdf)$/i', basename($i->receipt_proof)))
                        <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]"
                            href="{{ $i->receipt_proof }}" download="">عرض الملف</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4" class="border px-4 py-2">لا توجد دفعات</td>
                </tr>
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
                @if($s->report_files)
                @foreach(json_decode($s->report_files) as $report)
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
                @if($s->payment_order_files)
                @foreach(json_decode($s->payment_order_files) as $file)
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
    @endif
    <h1 class="font-bold text-base mt-4">البيانات المالية للجزء الغير مدعوم</h1>
    <div class="grid">
        <div class="grid grid-cols-2 gap-x-7">
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">
                    تكلفة المشروع المتوقعة
                    <span class="text-red-600">*</span>
                </label>
                <input type="text" class="input" placeholder="{{ $s->expected_cost }}">
            </div>
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">
                    تكلفة المشروع الفعلية
                    <span class="text-red-600">*</span>
                </label>
                <input type="text" class="input" placeholder="{{ $s->real_cost }}">
            </div>
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">
                    عدد المراحل
                    <span class="text-red-600">*</span>
                </label>
                <input type="number" class="input" placeholder="" id="stages_count_${i}">
            </div>
        </div>
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
        <tbody>
            @foreach($phases as $key => $phase)
            <tr>
                <td class="border px-4 py-2">{{ $key + 1 }}</td>
                <td class="border px-4 py-2">{{ $phase->phase_cost }}</td>
                <td class="border px-4 py-2">
                    <label class="label cursor-pointer">
                        <input type="checkbox" disabled class="checkbox"
                            {{ $phase->disbursement_status ? 'checked' : '' }} />
                        <span class="label-text">تم استلام الصرف</span>
                    </label>
                </td>
                <td class="border px-4 py-2">
                    @if(preg_match('/\.(jpg|jpeg|png|pdf)$/i', basename($phase->disbursement_proof)))
                    <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]"
                        href="{{ $phase->disbursement_proof }}" download="">عرض الملف</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endforeach