<form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">

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
                        <div class="h-[4.1rem] bg-white rounded flex justify-between">
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

    <div class="join grid grid-cols-2 w-1/4 float-left">
        @if($step == 2 && $step < 8)
            <a type="submit" href="{{ route('admin.update.project', ['step' => $step - 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700/30 text-base text-cyan-700
            hover:bg-cyan-700/30 hover:text-cyan-700">
            السابق
            </a>
            <button type="submit" href="{{ route('admin.update.project', ['step' => $step + 1, 'id' => $project->id]) }}" class="join-item btn bg-cyan-700 text-base text-white
            hover:bg-cyan-700">
                التالي
            </button>
            @endif
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
                    <input type="number" name="installments[${i}][amount]" min="0" class="input" value="" />
                </td>
                <td class="border px-4 py-2">
                    <label class="label cursor-pointer">
                        <input type="checkbox" name="installments[${i}][status]" class="checkbox" />
                        <span class="label-text">تم استلام الدفعة</span>
                    </label>
                </td>
                <td class="border px-4 py-2">
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

        // Add event listener to handle input change
        installmentCountInput.addEventListener("input", updateTableRows);
    });
</script>
@endpush