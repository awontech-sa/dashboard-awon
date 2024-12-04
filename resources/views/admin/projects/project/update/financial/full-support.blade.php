@if($supporter->supporter_number > 0)
<div class="supporter-div">
    @for($i=1; $i <= $supporter->supporter_number; $i++)
        <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم {{ $i }}</h1>

        <div class="grid grid-cols-2 gap-x-7">
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">الجهة الداعمة</label>
                <input class="input" disabled value="{{ $supporter->supporter_name }}">
            </div>

            <div class="grid my-2">
                <label class="font-normal text-base mb-2">إجمالي مبلغ الدعم</label>
                <input class="input" disabled value="{{ $supporter->support_amount }}">
            </div>

            <div class="grid my-2">
                <label class="font-normal text-base mb-2">عدد الدفعات</label>
                <input class="input" disabled value="{{ $supporter->installments_count }}">
            </div>
        </div>

        <div class="mt-4">
            <table class="w-full border mt-2 font-medium text-base table text-center">
                <th class="border px-4 py-2">الدفعة</th>
                <th class="border px-4 py-2">قيمة الدفعة</th>
                <th class="border px-4 py-2">حالة استلام الدفعة</th>
                <th class="border px-4 py-2">اثبات استلام الدفعة</th>
                @if($supporter->installments_count > 0)
                @foreach($installment as $i)
                <tbody>
                    <td class="border px-4 py-2">{{ $i->id }}</td>
                    <td class="border px-4 py-2">{{ $i->installment_amount }}</td>
                    <td class="border px-4 py-2">
                        <label class="label cursor-pointer">
                            <input type="checkbox" disabled class="checkbox"
                                {{ $i->installment_receipt_status === 1 ? 'checked' : '' }} />
                            <span class="label-text">تم استلام الدفعة</span>
                        </label>
                    </td>
                    <td>
                        @if( $i->receipt_proof !== null )
                        <div class="h-[4.1rem] bg-white rounded flex justify-between">
                            <div class="flex gap-x-5 p-4 items-center">
                                <img src="{{ asset("assets/icons/pdf.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                            </div>
                            <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $i->receipt_proof ?? '' }}" download="">عرض الملف</a>
                        </div>
                        @endif
                    </td>
                </tbody>
                @endforeach
                @endif
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
        @endfor
</div>
@endif