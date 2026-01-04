document.getElementById('taskSearch').addEventListener('keyup', function () {
    const search = this.value.toLowerCase();
    const rows = document.querySelectorAll('.task-table tbody tr');

    rows.forEach(row => {
        const taskNumber = row.querySelector('.task-number')?.innerText.toLowerCase() || '';
        const taskTitle  = row.querySelector('strong')?.innerText.toLowerCase() || '';

        row.style.display =
            taskNumber.includes(search) || taskTitle.includes(search)
                ? ''
                : 'none';
    });
});
