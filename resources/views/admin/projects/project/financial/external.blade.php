<div class="grid grid-cols-2 gap-x-4 mt-8 gap-y-10 font-normal text-base">
    <div class="grid gap-y-5">
        <label>اسم الجهة</label>
        <input type="text" disabled placeholder="{{ $supporter->supporter_name ?? '' }}" class="input" />
    </div>
    <div class="grid gap-y-5">
        <label>تكلفة المشروع</label>
        <input type="text" disabled placeholder="{{ $project->total_cost ?? 0 }}" class="input" />
    </div>
    <div class="grid gap-y-5">
        <label>عدد الدفعات</label>
        <input type="number" min="0" disabled placeholder="{{ $supporter->installments_count ?? 0 }}" class="input" />
    </div>
</div>

<div class="mt-4">
    <table class="w-full border mt-2 font-medium text-base table text-center">
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
    </table>
</div>