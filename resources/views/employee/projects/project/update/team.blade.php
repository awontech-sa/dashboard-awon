<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <input type="hidden" name="array-members" value="[]" />
    <input type="hidden" name="delete-members" value="[]" />
    <div class="grid gap-y-5">
        <label for="type-benef">مدير المشروع</label>
        <select class="select select-bordered w-full max-w-xs" name="manager" value="">
            @foreach($users as $user)
            <option {{ isset($bigBoss) && $user->name === $bigBoss->project_manager ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="grid gap-y-5">
        <label for="benef_number">نائب مدير المشروع</label>
        <select class="select select-bordered w-full max-w-xs" name="sub-manager" value="">
            @foreach($users as $user)
            <option {{ isset($bigBoss) && $user->name === $bigBoss->project_manager ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="flex gap-x-4 my-8">
    <p>أعضاء فريق العمل</p>
    <button type="button" class="btn btn-xs font-normal bg-white" onclick="addMember({{ json_encode($users) }})">إضافة عضو</button>
</div>
<div id="new-member">
    @foreach($team as $member)
    <div class="grid grid-cols-3 gap-x-5 items-center mb-4" id="{{ $member['id'] }}">
        <!-- Member Name -->
        <div class="grid gap-y-5">
            <label>إسم العضو</label>
            <select class="select select-bordered w-full max-w-xs" name="member-select">
                @foreach($users as $user)
                <option {{ $user->name === $member['name'] ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        <!-- Member Role -->
        <div class="grid gap-y-5">
            <label>الدور</label>
            <input type="text" name="member-role" class="input text-center text-base" value="{{ $member['role'] }}" />
        </div>
        <!-- Remove Button -->
        <button type="button" class="btn bg-[#FAFBFD] w-fit mt-auto" onclick="removeMember('{{ $member['id'] }}')">
            <x-far-trash-can class="w-6 h-6 text-red-500" />
        </button>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
    let arrayMembers = [];
    let removeMembers = []

    function addMember(users) {
        let fileContainer = document.getElementById('new-member');

        // إنشاء حاوية العضو
        let memberContainer = document.createElement('div');
        memberContainer.classList.add('grid', 'grid-cols-3', 'gap-x-5', 'items-center', 'mb-4');

        // حقل اختيار العضو
        let memberNameContainer = document.createElement('div');
        memberNameContainer.classList.add('grid', 'gap-y-5');
        let memberNameLabel = document.createElement('label');
        memberNameLabel.textContent = 'إسم العضو';
        let memberSelect = document.createElement('select');
        memberSelect.classList.add('select', 'select-bordered', 'w-full', 'max-w-xs');
        memberSelect.name = 'member-select';
        let firstOption = document.createElement('option');
        memberSelect.appendChild(firstOption);
        users.forEach(user => {
            let memberOption = document.createElement('option');
            memberOption.value = user.id;
            memberOption.textContent = user.name;
            memberSelect.appendChild(memberOption);
        });
        memberNameContainer.appendChild(memberNameLabel);
        memberNameContainer.appendChild(memberSelect);
        memberContainer.appendChild(memberNameContainer);

        // حقل إدخال الدور
        let memberRoleContainer = document.createElement('div');
        memberRoleContainer.classList.add('grid', 'gap-y-5');
        let memberRoleLabel = document.createElement('label');
        memberRoleLabel.textContent = 'الدور';
        let memberRoleInput = document.createElement('input');
        memberRoleInput.name = 'member-role';
        memberRoleInput.classList.add('input', 'text-center', 'text-base');
        memberRoleInput.type = 'text';
        memberRoleContainer.appendChild(memberRoleLabel);
        memberRoleContainer.appendChild(memberRoleInput);
        memberContainer.appendChild(memberRoleContainer);

        // زر الحذف
        let removeMemberBtn = document.createElement('button');
        removeMemberBtn.classList.add('btn', 'bg-[#FAFBFD]', 'w-fit', 'mt-auto');
        removeMemberBtn.innerHTML = `<x-far-trash-can class="w-6 h-6 text-red-500" />`;
        removeMemberBtn.onclick = () => {
            removeMember(memberContainer.id.value);
        };
        memberContainer.appendChild(removeMemberBtn);

        fileContainer.appendChild(memberContainer);

        // عند اختيار العضو
        memberSelect.addEventListener('change', function() {
            let memberId = memberSelect.value;
            let memberName = memberSelect.selectedOptions[0].textContent.trim();

            // إضافة العضو إلى المصفوفة مع الدور الفارغ مؤقتاً
            let memberObject = {
                id: memberId,
                member: memberName,
                role: ''
            };
            arrayMembers.push(memberObject);

            updateHiddenInput();
        });

        // عند تعديل الدور
        memberRoleInput.addEventListener('blur', function() {
            let memberId = memberSelect.value;
            let existingMember = arrayMembers.find(member => member.id === memberId);

            if (existingMember) {
                existingMember.role = memberRoleInput.value.trim();
            }


            updateHiddenInput();
        });


    }

    // حذف العضو
    function removeMember(uniqueId) {
        let memberElement = document.getElementById(uniqueId);
        if (memberElement) {
            let memberName = memberElement.querySelector('select[name="member-select"] option:checked').textContent.trim();
            let memberRole = memberElement.querySelector('input[name="member-role"]').value;

            removeMembers.push({
                name: memberName,
                role: memberRole
            });
            memberElement.remove();
            updateHiddenInput();
        }
    }


    // تحديث الحقل المخفي
    function updateHiddenInput() {
        document.querySelector('input[name="array-members"]').value = JSON.stringify(arrayMembers);
        document.querySelector('input[name="delete-members"]').value = JSON.stringify(removeMembers);
    }
</script>
@endpush