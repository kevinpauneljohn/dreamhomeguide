import {initializeTaskTable} from "@/dashboard/tasks/tasks-table.js";

document.addEventListener("DOMContentLoaded", () => {
    const chart = document.querySelector('.chart-placeholder');
    if (!chart) return;

    // Convert dataset values to numbers
    const total = Number(chart.dataset.total || 0);
    const completed = Number(chart.dataset.completed || 0);

    const percentText = document.getElementById('taskPercent');

    // HARD GUARD: no tasks or invalid data
    if (!total || total <= 0) {
        chart.style.background = 'conic-gradient(#e9ecef 0deg 360deg)';
        percentText.textContent = '0%';
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


