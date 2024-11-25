<div class="mt-8" id="parentDiv">
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
            <table class="w-full border mt-2">
                <th class="border px-4 py-2">المرحلة</th>
                <th class="border px-4 py-2">تكلفة المرحلة</th>
                <th class="border px-4 py-2">حالة الصرف</th>
                <th class="border px-4 py-2">اثبات الصرف</th>

                <tbody>
                    <tr class="border px-4 py-2"></tr>
                    <tr class="border px-4 py-2"></tr>
                    <tr class="border px-4 py-2"></tr>
                    <tr class="border px-4 py-2"></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>