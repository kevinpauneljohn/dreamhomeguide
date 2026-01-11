import {initializeTaskTable} from "@/dashboard/tasks/tasks-table.js";

document.addEventListener("DOMContentLoaded", () => {
    const chart = document.querySelector('.chart-placeholder');

    const total = chart.dataset.total;
    const completed = chart.dataset.completed;

    if (total === 0) return;

    const percentage = Math.round((completed / total) * 100);
    const degrees = (completed / total) * 360;


    const percentText = document.getElementById('taskPercent');

    chart.style.background = `
        conic-gradient(
            #198754 0deg ${degrees}deg,
            #e9ecef ${degrees}deg 360deg
        )
    `;

    percentText.textContent = percentage + '%';
});

