<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <input type="hidden" name="array-members" value="[]" />
    <div class="grid gap-y-5">
        <label for="type-benef">مدير المشروع <span class="text-red-600">*</span></label>
        <select class="select select-bordered w-full max-w-xs" name="manager" value="">
            <option></option>
            @foreach($users as $user)
            <option id="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid gap-y-5">
        <label for="benef_number">نائب مدير المشروع <span class="text-red-600">*</span></label>
        <select class="select select-bordered w-full max-w-xs" name="sub-manager" value="">
            <option></option>
            @foreach($users as $user)
            <option id="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="flex gap-x-4 my-8">
    <p>أعضاء فريق العمل</p>
    <button type="button" class="btn btn-xs font-normal bg-white" onclick="addMember({{ json_encode($users) }})">إضافة عضو</button>
</div>
<div id="new-member"></div>

@push('scripts')
<script>
    let arrayMembers = []

    function addMember(users) {
        let fileContainer = document.getElementById('new-member');
        let uniqueId = `member-${Date.now()}`;

        let memberContainer = document.createElement('div');
        memberContainer.classList.add('grid', 'grid-cols-3', 'gap-x-5', 'items-center', 'mb-4');
        memberContainer.id = uniqueId;

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

        let removeMemberBtn = document.createElement('button');
        removeMemberBtn.classList.add('btn', 'bg-[#FAFBFD]', 'w-fit', 'mt-auto');
        removeMemberBtn.innerHTML = `<x-far-trash-can class="w-6 h-6 text-red-500" />`;
        removeMemberBtn.onclick = () => {
            removeMember(uniqueId);
        };
        memberContainer.appendChild(removeMemberBtn);

        fileContainer.appendChild(memberContainer);
        memberSelect.addEventListener('change', function() {
            let selectedOption = memberSelect.selectedOptions[0];
            let memberId = selectedOption.value;
            arrayMembers.push({
                id: memberId,
                member: selectedOption.textContent,
                role: '' // Placeholder for the role (to be filled later)
            });
        });

        memberRoleInput.addEventListener('input', function() {
            let selectedOption = memberSelect.selectedOptions[0];
            let memberId = selectedOption.value;

            let existingMember = arrayMembers.find(member => member.id === memberId);

            existingMember.role = memberRoleInput.value; // Update the role in the array

            document.querySelector('input[name="array-members"]').value = JSON.stringify(arrayMembers);
        });
    }

    function removeMember(uniqueId) {
        let memberElement = document.getElementById(uniqueId);
        if (memberElement) {
            memberElement.remove();

            arrayMembers.pop(memberElement)

            document.querySelector('input[name="array-members"]').value = JSON.stringify(arrayMembers);
        }
    }
</script>
@endpush