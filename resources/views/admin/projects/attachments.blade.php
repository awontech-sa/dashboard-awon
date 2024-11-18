<div class="grid my-8">
    <label class="font-normal text-base mb-2">العرض الفني للمشروع <span class="text-red-600">*</span></label>
    <input class="file-input" type="file" name="tech-offer" id="" value="{{ old('tech-offer', $data['tech_offer'] ?? '') }}" />
</div>
<div class="grid mb-8">
    <label class="font-normal text-base mb-2">العرض المالي للمشروع <span class="text-red-600">*</span></label>
    <input class="file-input" type="file" name="financial-offer" id="" value="{{ old('financial-offer', $data['financial_offer'] ?? '') }}" />
</div>
<div class="grid mb-8">
    <label class="font-normal text-base mb-2">عقد المشروع <span class="text-red-600">*</span></label>
    <input class="file-input" type="file" name="project-contract" id="" value="{{ old('project-contract', $data['project_contract'] ?? '') }}" />
</div>
<div class="grid mb-8">
    <label class="font-normal text-base mb-2">ملف تعريفي <span class="text-red-600">*</span></label>
    <input class="file-input" type="file" name="profile" id="" value="{{ old('profile', $data['profile'] ?? '') }}" />
</div>
<div class="grid mb-8">
    <label class="font-normal text-base mb-2">فيديو تعريفي <span class="text-red-600">*</span></label>
    <input class="file-input" type="file" name="video" id="" value="{{ old('video', $data['video'] ?? '') }}" />
</div>