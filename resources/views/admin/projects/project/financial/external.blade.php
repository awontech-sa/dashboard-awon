<div class="grid grid-cols-2 gap-x-4 mt-8 gap-y-10 font-normal text-base">
    <div class="grid gap-y-5">
        <label>اسم الجهة</label>
        <input type="text" disabled placeholder="{{ $supporter->supporter_name }}" class="input" />
    </div>
    <div class="grid gap-y-5">
        <label>تكلفة المشروع</label>
        <input type="text" disabled placeholder="{{ $project->total_cost }}" class="input" />
    </div>
    <div class="grid gap-y-5">
        <label>عدد الدفعات</label>
        <input type="number" disabled placeholder="{{ $supporter->installments_count }}" class="input" />
    </div>
</div>

<div class="mt-4">
    <table class="w-full border mt-2">
        <th class="border px-4 py-2">الدفعة</th>
        <th class="border px-4 py-2">قيمة الدفعة</th>
        <th class="border px-4 py-2">حالة استلام الدفعة</th>
        <th class="border px-4 py-2">اثبات استلام الدفعة</th>

        @foreach($installment as $i)
        <tbody>
            <td class="border px-4 py-2">{{ $i->id }}</td>
            <td class="border px-4 py-2">{{ $i->installment_amount }}</td>
            <td class="border px-4 py-2">
                <label class="label cursor-pointer">
                    <span class="label-text">تم استلام الدفعة</span>
                    <input type="checkbox" class="checkbox"
                        {{ ($i->installment_receipt_status) === 1 ? 'checked' : '' }} />
                </label>
            </td>
            <td><a href="{{ $i->receipt_proof }}">عرض الملف</a></td>
        </tbody>
        @endforeach
    </table>
</div>