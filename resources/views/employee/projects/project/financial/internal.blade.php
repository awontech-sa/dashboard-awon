<div class="mt-14" id="parentDiv">
    <div class="grid">
        <div class="grid grid-cols-2 gap-x-7">
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">تكلفة المشروع المتوقعة</label>
                <input type="text" disabled placeholder="{{ $project->expected_cost ?? 0 }}" class="input" />
            </div>
            <div class="grid my-2">
                <label class="font-normal text-base mb-2">تكلفة المشروع الفعلية</label>
                <input type="text" disabled placeholder="{{ $project->actual_cost ?? 0 }}" class="input" />
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
                        <td class="border px-4 py-2">{{ $key + 1}}</td>
                        <td class="border px-4 py-2">{{ $phase->phase_cost }}</td>
                        <td class="border px-4 py-2">
                            <label class="label cursor-pointer">
                                <input type="checkbox" disabled class="checkbox"
                                    {{ $phase->disbursement_status === 1 ? 'checked' : '' }} />
                                <span class="label-text">تم استلام الصرف</span>
                            </label>
                        </td>
                        <td>
                            @if( $phase->disbursement_proof !== null )
                            <div class="h-[4.1rem] bg-white rounded flex justify-between">
                                <div class="flex gap-x-5 p-4 items-center">
                                    <img src="{{ asset("assets/icons/pdf.png") }}" class="w-[1.4rem] h-7" alt="pdf" />
                                </div>
                                <a class="btn m-2 btn-md bg-[#FBFDFE] rounded-md border-[#0F91D2] text-[#0F91D2]" href="{{ $phase->disbursement_proof ?? '' }}" download="">عرض الملف</a>
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