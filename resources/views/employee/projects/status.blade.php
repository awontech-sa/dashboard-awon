<div class="my-5">
    <div class="grid grid-cols-2 gap-x-6">
        <div class="grid my-8 gap-y-5">
            <label for="start-project">حالة المشروع</label>
            <select class="select select-bordered select-lg w-full max-w-xs" name="project-status">
                @foreach (App\Enums\ProjectStatus::cases() as $status)
                <option value="{{ $status->value }}" {{ old('project-status', $data['project_status'] ?? '') == $status->value ? 'selected' : '' }}>
                    {{ $status->value }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="grid my-8 gap-y-5">
            <label for="start-project">ملاحظات</label>
            <input type="text" name="comment" class="input" placeholder="اكتب هنا.." value="{{ old('comment', $data['comment'] ?? '') }}" />
        </div>
    </div>
</div>