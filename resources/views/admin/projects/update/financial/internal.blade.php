<form action="{{ route('admin.update.project', ['step' => $step, 'id' => $project->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf

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
                    <input type="number" min="0" class="input" name="stages-count-not-support" id="stages_count_not_support">
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
        const phasesCountInput = document.getElementById("stages_count_not_support");
        const phasesTable = document.getElementById("phases-table");
        let existingRows = @json($phases);

        function updateTableRows() {
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
        phasesCountInput.addEventListener("input", updateTableRows);
    });
</script>
@endpush