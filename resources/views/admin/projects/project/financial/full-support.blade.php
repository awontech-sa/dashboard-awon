@if($supporter->supporter_number > 0)
<div class="supporter-div">
    @for($i=1; $i <= $supporter->supporter_number; $i++)
        <h1 class="font-bold text-base mt-4">بيانات الجهة الداعمة رقم {{$i}}</h1>

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
            <table class="w-full border mt-2">
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
                            <span class="label-text">تم استلام الدفعة</span>
                            <input type="checkbox" disabled class="checkbox"
                                {{ ($i->installment_receipt_status) === 1 ? 'checked' : '' }} />
                        </label>
                    </td>
                    <td><a href="{{ $i->receipt_proof ??  '' }}">عرض الملف</a></td>
                </tbody>
                @endforeach
                @endif
            </table>
        </div>

        <div class="grid grid-cols-2">
            <div class="installment-report my-4" id="installment_report_${i}">
                <div class="flex gap-x-4">
                    <p>تقارير للجهة الداعمة</p>
                </div>
                <input type="hidden" name="countReport" value="0">
            </div>

            <div class="installment-files my-4" id="installment_files_${i}">
                <div class="flex gap-x-4">
                    <p>أوامر الصرف</p>
                </div>
                <input type="hidden" name="paymentCountFiles" value="0">
            </div>
        </div>
        @endfor
</div>
@endif