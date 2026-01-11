import {initializeTaskTable} from "@/dashboard/tasks/tasks-table.js";

document.addEventListener("DOMContentLoaded", () => {
    const chart = document.querySelector('.chart-placeholder');

    const total = chart.dataset.total;
    const completed = chart.dataset.completed;

    // HARD GUARD: no tasks → show 0%
    if (!total || total <= 0) {
        document.querySelector('.chart-placeholder').style.background =
            'conic-gradient(#e9ecef 0deg 360deg)';
        document.getElementById('taskPercent').textContent = '0%';
        return;
    }

    const percentage = Math.round((completed / total) * 100);
    const degrees = (completed / total) * 360;

    chart.style.background = `
        conic-gradient(
            #198754 0deg ${degrees}deg,
            #e9ecef ${degrees}deg 360deg
        )
    `;

    percentText.textContent = percentage + '%';
});

