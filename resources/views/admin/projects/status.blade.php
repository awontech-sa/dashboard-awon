<div class="my-5">
    <div class="grid grid-cols-2 gap-x-6">
        <div class="grid my-8 gap-y-5">
            <label for="start-project">تاريخ بداية المشروع <span class="text-red-600">*</span></label>
            <select class="select select-bordered select-lg w-full max-w-xs" name="project-status" value="{{ old('type-benef', $data['type_benef_id'] ?? '') }}">
                @foreach (App\Enums\ProjectStatus::cases() as $status)
                <option>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid my-8 gap-y-5">
            <label for="start-project">ملاحظات</label>
            <input type="text" name="comment" class="input" placeholder="اكتب هنا.." value="{{ old('comment', $data['comment'] ?? '') }}" />
        </div>
    </div>
</div>