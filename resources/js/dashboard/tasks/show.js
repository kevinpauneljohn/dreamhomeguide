import {deleteTask} from "@/dashboard/tasks/delete.js";
import {Toast} from "@/toast.js";
import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import {getTaskActivities} from "@/dashboard/task-activities/task-activity-table.js";

const changeStatusButton = document.getElementById('change-status-button');
const taskData = document.getElementById('task-data');
const taskId = taskData.dataset.taskId;
const taskActivityModal = document.getElementById('taskActivityModal');
const modal = bootstrap.Modal.getOrCreateInstance(taskActivityModal);
const statusUpdateForm = document.getElementById('status-update-form');
const badgeStatus = document.getElementById('badge-status');

let taskStatus = null;
const setTaskStatus = (status) => {
    taskStatus = status;

    // Reset base classes
    changeStatusButton.className = 'btn';
    badgeStatus.className = 'badge';

    const statusMap = {
        'pending': {
            buttonClass: 'btn-success',
            buttonText: '✓ Mark as Completed',
            badgeClass: 'bg-secondary',
            badgeText: 'Pending'
        },
        'in progress': {
            buttonClass: 'btn-success',
            buttonText: '✓ Mark as Completed',
            badgeClass: 'bg-primary',
            badgeText: 'In Progress'
        },
        'overdue': {
            buttonClass: 'btn-success',
            buttonText: '✓ Mark as Completed',
            badgeClass: 'bg-danger',
            badgeText: 'Overdue'
        },
        'completed': {
            buttonClass: 'btn-danger',
            buttonText: '↺ Reopen Task',
            badgeClass: 'bg-success',
            badgeText: 'Completed'
        }
    };

    const config = statusMap[status];

    if (!config) {
        console.warn(`Unknown task status: ${status}`);
        return;
    }

    // Apply button state
    changeStatusButton.classList.add(config.buttonClass);
    changeStatusButton.innerHTML = config.buttonText;

    // Apply badge state
    badgeStatus.classList.add(config.badgeClass);
    badgeStatus.textContent = config.badgeText;

    //set the input type status value
    document.getElementById('task_status').value = taskStatus;
};



const getTaskStatus = () => {
    return taskStatus;
}

const taskInfo = (task) => {
    setTaskStatus(task.status);
}

changeStatusButton.addEventListener('click', () => {
    const textarea = document.getElementById('accomplishment');
    if(getTaskStatus() === 'pending')
    {
        taskActivityModal.querySelector('.modal-title').textContent = 'Write your accomplishments to mark this task as completed';
        textarea.placeholder =
            'Describe the work completed or notes related to this task...';
    }
    else if(getTaskStatus() === 'completed')
    {
        taskActivityModal.querySelector('.modal-title').textContent = 'Write your reasons to reopen this task';
        textarea.placeholder =
            'Describe the reason and notes for reopening this task...';
    }
    modal.show();
})

statusUpdateForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    statusUpdateForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    statusUpdateForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    const submitBtn = statusUpdateForm.querySelector('[type="submit"]');

    if (!taskStatus) {
        Toast.fire({
            icon: 'warning',
            title: 'Task status not initialized.'
        });
        return;
    }

    const formData = new FormData(statusUpdateForm);
    submitBtn.disabled = true;
    setLoading(submitBtn, 'Submitting...');

    try {
        const { data } = await axios.post('/task-activity', formData);
        console.log(data);

        Toast.fire({
            icon: 'success',
            title: data.message
        });
        getTaskActivities();

        // Backend is source of truth
        taskInfo(data.data.task);

        modal.hide();
        statusUpdateForm.reset();

    } catch (error) {

        const response = error.response;

        if (response?.status === 422 && response.data?.errors) {
            Object.entries(response.data.errors).forEach(([key, messages]) => {
                const field = statusUpdateForm.querySelector(`[name="${key}"]`);
                if (!field) return;

                field.classList.add('is-invalid');
                field.insertAdjacentHTML(
                    'afterend',
                    `<div class="invalid-feedback">${messages[0]}</div>`
                );
            });
        } else {
            Toast.fire({
                icon: 'error',
                title: response?.data?.message || 'Failed to update task.'
            });
        }

    } finally {
        submitBtn.disabled = false;
        resetLoading(submitBtn, 'Submit');
    }
});



const tasks = () => {
    axios.post(`/get-task-details/${taskId}`)
        .then(response => {
        taskInfo(response.data)
    })
}

const params = new URLSearchParams(window.location.search);
const success = params.get('success');

if(params.get('success'))
{
    console.log(success);
}

document.addEventListener('DOMContentLoaded', () => {
    flashSuccess()
    tasks()
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

