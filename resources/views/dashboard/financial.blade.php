<div class="my-14">
    <h1 class="font-bold text-xl">البيانات المالية</h1>

    @if(isset($supporter) || !empty($supporter))
    <div class="grid grid-cols-2 gap-x-6 mt-[0.82rem]">
        <div>
            <label class="font-normal text-base mb-2">حالة الدعم <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $supporter->p_support_status ?? '' }}</span>
                        <input
                            type="radio"
                            name="support-status"
                            value="{{ $supporter->p_support_status ?? '' }}"
                            class="radio"
                            id="support-status-{{ $supporter->id ?? '' }}"
                            checked />
                    </label>
                </div>
            </div>
        </div>
        @if($supporter->p_support_type === 'كلي' || $supporter->p_support_type === 'جزئي')
        <div class="support-type-form">
            <label class="font-normal text-base mb-2">نوع الدعم <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $supporter->p_support_type ?? '' }}</span>
                        <input type="radio" value="{{ $supporter->p_support_type ?? '' }}" name="support-type" class="radio" id="support-type-{{ $supporter->id ?? '' }}" checked />
                    </label>
                </div>
            </div>
        </div>
        @else
        <div class="external-support">
            <label class="font-normal text-base mb-2">مالك المشروع <span class="text-red-600">*</span></label>
            <div class="bg-white flex gap-x-4 p-2 rounded">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ $supporter->p_support_type ?? '' }}</span>
                        <input type="radio" value="{{ $supporter->p_support_type ?? '' }}" name="supporter" class="radio" id="support-comp-{{ $supporter->id ?? '' }}" checked />
                    </label>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>