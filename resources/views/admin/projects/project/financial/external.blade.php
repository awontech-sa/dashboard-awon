@foreach($supporter as $s)
<div class="grid grid-cols-2 gap-x-4 mt-8 gap-y-10 font-normal text-base">
    <div class="grid gap-y-5">
        <label>اسم الجهة</label>
        <input type="text" disabled placeholder="{{ $s->supporter_name ?? '' }}" class="input" />
    </div>
    <div class="grid gap-y-5">
        <label>تكلفة المشروع</label>
        <input type="text" disabled placeholder="{{ $project->total_cost ?? 0 }}" class="input" />
    </div>
    <div class="grid gap-y-5">
        <label>عدد الدفعات</label>
        <input type="number" min="0" disabled placeholder="{{ $s->installments_count ?? 0 }}" class="input" />
    </div>
</div>
@endforeach

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
                <td class="border px-4 py-2">{{ $key+1 }}</td>
                <td class="border px-4 py-2">{{ $i->installment_amount }}</td>
                <td class="border px-4 py-2">
                    <label class="label cursor-pointer">
                        <input type="checkbox" disabled class="checkbox"
                            {{ $i->installment_receipt_status === 1 ? 'checked' : '' }} />
                        <span class="label-text">تم استلام الدفعة</span>
                    </label>
                </td>
                <td>
                    @if(preg_match('/\.(jpg|jpeg|png|pdf)$/i', basename($i->receipt_proof)))
                    <div class="h-[4.1rem] bg-white rounded flex justify-between">
                        <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $i->receipt_proof ?? '' }}" download="">عرض الملف</a>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>