<div class="container mt-4">
    <form method="POST" id="projects-form">
        @csrf

        <div class="mb-3">
            <div class="flex justify-between">
                <label for="select2Input" class="form-label">مشاريع الإدارة التقنية</label>
                <label class="form-label text-base font-normal text-gray-500">صلاحية تعديل وحذف</label>
            </div>
            <select class="form-select select2" multiple name="project_ids[]" id="select2Input">
                @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->p_name }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();

        let previousSelections = [];

        $('#select2Input').on('change', function(event) {
            event.preventDefault();

            const currentSelections = $(this).val();

            const addedProjects = currentSelections.filter(id => !previousSelections.includes(id));
            const removedProjects = previousSelections.filter(id => !currentSelections.includes(id));

            previousSelections = currentSelections;

            if (addedProjects.length > 0) {
                $.ajax({
                    url: "{{ route('admin.powers.store.tech', $id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        project_ids: addedProjects,
                        action: 'add'
                    },
                });
            }

            if (removedProjects.length > 0) {
                $.ajax({
                    url: "{{ route('admin.powers.store.tech', $id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        project_ids: removedProjects,
                        action: 'remove'
                    },
                });
            }
        });
    });
</script>
@endpush