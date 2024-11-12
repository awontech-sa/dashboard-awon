<h1>here</h1>

<script>
    document.getElementById('start-project').addEventListener('change', calculateDurations);
    document.getElementById('end-project').addEventListener('change', calculateDurations);

    function calculateDurations() {
        const startDate = new Date(document.getElementById('start-project').value);
        const endDate = new Date(document.getElementById('end-project').value);
        const today = new Date();

        if (!isNaN(startDate) && !isNaN(endDate)) {
            const projectDuration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            document.getElementById('project-duration').value = projectDuration + ' يوم';

            const remainingDuration = Math.ceil((endDate - today) / (1000 * 60 * 60 * 24));
            document.getElementById('remaining-duration').value = remainingDuration >= 0 ? remainingDuration + ' يوم' : 'انتهى المشروع';
        } else {
            document.getElementById('project-duration').value = '';
            document.getElementById('remaining-duration').value = '';
        }
    }
</script>