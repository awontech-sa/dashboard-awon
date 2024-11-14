<div class="grid grid-cols-2 gap-x-[3.3rem] my-8">
    <div class="grid gap-y-5">
        <label for="type-benef">مدير المشروع <span class="text-red-600">*</span></label>
        <select class="select select-bordered w-full max-w-xs" name="type-benef" value="{{ old('type-benef', $data['type-benef'] ?? '') }}">
            @foreach($typeBenef as $tp)
            <option id="{{ $tp->id }}">{{ $tp->tb_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid gap-y-5">
        <label for="benef_number">نائب مدير المشروع <span class="text-red-600">*</span></label>
        <select class="select select-bordered w-full max-w-xs" name="type-benef" value="{{ old('type-benef', $data['type-benef'] ?? '') }}">
            @foreach($typeBenef as $tp)
            <option id="{{ $tp->id }}">{{ $tp->tb_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="flex gap-x-4">
    <p>أعضاء فريق العمل</p>
    <button type="button" class="btn btn-xs font-normal bg-white" onclick="addMember()">إضافة عضو</button>
</div>
<div id="new-member"></div>

<script>
    function addMember() {
        let fileContainer = document.getElementById(`new-member`);

        const uniqueId = `member-${Date.now()}`;

        fileContainer.insertAdjacentHTML('beforeend', `
        <div class="grid grid-cols-3 gap-x-20" id="${uniqueId}">
            <div class="grid gap-y-5">
                <label for="type-benef">إسم العضو <span class="text-red-600">*</span></label>
                <select class="select select-bordered w-full max-w-xs" name="type-benef" value="">
                    <option id=></option>
                </select>
            </div>
            <div class="grid gap-y-5">
                <label for="benef_number">الدور <span class="text-red-600">*</span></label>
                <input id="project-duration" name="project-duration" value="" class="input text-center text-base" type="text" placeholder="" />
            </div>
            <button onclick="removeMember('${uniqueId}')" class="btn bg-[#FAFBFD]"><x-far-trash-can class="w-6 h-6 text-red-500" /></button>
        </div>
        `);
    }

    function removeMember(uniqueId) {
        const memberElement = document.getElementById(uniqueId);
        if (memberElement) {
            memberElement.remove();
        }
    }
</script>



<script>
    function addMember() {
        let fileContainer = document.getElementById('new-member');

        // Create a unique ID for each new entry container
        const uniqueId = `member-${Date.now()}`;

        // Insert the new entry with a wrapper div and a unique ID
        fileContainer.insertAdjacentHTML('beforeend', `
        <div class="grid grid-cols-3 gap-y-5 items-center mb-4" id="${uniqueId}">
            <div class="grid gap-y-5">
                <label for="type-benef">إسم العضو <span class="text-red-600">*</span></label>
                <select class="select select-bordered w-full max-w-xs" name="type-benef" value="">
                    <option id=></option>
                </select>
            </div>
            <div class="grid gap-y-5">
                <label for="benef_number">الدور <span class="text-red-600">*</span></label>
                <input id="project-duration" name="project-duration" value="" class="input text-center text-base" type="text" placeholder="" />
            </div>
            <button class="btn bg-[#FAFBFD]" onclick="removeMember('${uniqueId}')">
                <x-far-trash-can class="w-6 h-6 text-red-500" />
            </button>
        </div>
        `);
    }

    // Function to remove a specific member entry by its ID
    function removeMember(uniqueId) {
        const memberElement = document.getElementById(uniqueId);
        if (memberElement) {
            memberElement.remove();
        }
    }
</script>