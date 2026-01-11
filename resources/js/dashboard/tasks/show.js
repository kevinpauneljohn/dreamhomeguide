import {deleteTask} from "@/dashboard/tasks/delete.js";
const params = new URLSearchParams(window.location.search);

const success = params.get('success');

if(params.get('success'))
{
    console.log(success);
}

document.addEventListener('DOMContentLoaded', () => {
    flashSuccess()
})

const removeUrlParams = () => {
    const cleanUrl = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, cleanUrl);
};

const flashSuccess = () => {
    const alert = document.getElementById('success-alert');
    if (!alert) return;

    setTimeout(() => {
        alert.classList.add('fade-out');

        // Remove after fade completes
        setTimeout(() => {
            alert.classList.add('d-none');
            removeUrlParams();
        }, 500);
    }, 5000);
}
