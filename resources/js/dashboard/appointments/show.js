import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import axios from "axios";
import moment from "moment";
import {Toast} from "@/toast.js";
import {rescheduleButton} from "@/dashboard/appointments/re-schedule-appoinment.js";

const completeStatusModalEl = document.getElementById('complete-status-note-modal');
const completeStatusModal = bootstrap.Modal.getOrCreateInstance(completeStatusModalEl);
const statusUpdateForm = document.getElementById('status-update-form');
const submitBtn = document.getElementById('submit-accomplishment-button');
const appointmentStatusBadge = document.getElementById('appointment-status');
const appointmentId = appointmentStatusBadge.dataset.appointmentId;
const completeStatusButton = document.getElementById('complete-status-button');
const appointmentDateDisplay = document.getElementById('appointment-date-display');


const statusBgColor = (status) => {
    switch (status) {
        case 'pending':
            return 'bg-secondary';
        case 'completed':
            return 'bg-success';
        case 'cancelled':
            return 'bg-danger';
    }
}


const replaceBgClass = (element, newBgClass) => {
    element.classList.remove(
        'bg-primary',
        'bg-secondary',
        'bg-success',
        'bg-danger',
        'bg-warning',
        'bg-info',
        'bg-light',
        'bg-dark'
    );

    element.classList.add(newBgClass);
};

const getAppointmentStatus = async () => {
    const response = await axios.get(`/appointment/status/${appointmentId}`)
    const status = response.data.status;
    const formattedDate = moment(response.data.appointment_date)
        .format('MMM DD, YYYY hh:mm A')
        .replace(',', '');
    const inputDate = moment(response.data.appointment_date)
        .format('YYYY-MM-DDTHH:mm');

    replaceBgClass(appointmentStatusBadge, statusBgColor(status));
    appointmentStatusBadge.textContent = status.toUpperCase();
    completeStatusButton.disabled = status === 'completed';
    rescheduleButton.disabled = status === 'completed';

    appointmentDateDisplay.textContent = formattedDate;
    document.querySelector('input[name="appointment_date"]').value = inputDate;

}

document.addEventListener('update:appointment-status', () => {
    getAppointmentStatus().then(response => {});
})

const getAppointmentActivities = () => {
    axios.get(`/get-appointment-activities/${appointmentId}`)
        .then(response => {
            document.getElementById('appointment-activity-list').innerHTML = response.data;
        });
}

const getAppointmentTasks = () => {
    axios.get(`/get-appointment-tasks/${appointmentId}`)
        .then(response => {
            document.getElementById('related-tasks-list').innerHTML = response.data;
        });
}

document.addEventListener('DOMContentLoaded', () => {
    getAppointmentStatus().then(response => {});
    getAppointmentActivities();
    getAppointmentTasks();
})

statusUpdateForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(statusUpdateForm);

    statusUpdateForm.querySelectorAll('.is-invalid').forEach((element) => {
        element.classList.remove('is-invalid');
    })

    statusUpdateForm.querySelectorAll('.invalid-feedback').forEach((element) => {
        element.remove()
    })

    setLoading(submitBtn, 'Submitting...');
    axios.post('/appointment-activity',formData).then((response) => {
        console.log(response)
        if(response.data.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: response.data.message,
            })

            getAppointmentStatus().then(response => {});
            getAppointmentActivities();
            statusUpdateForm.reset();
            completeStatusModal.hide();
        }
    }).catch((error) => {
        console.log(error.response.data)
        if(error.response.data.success === false)
        {
            Toast.fire({
                icon: 'warning',
                title: error.response.data.message,
            })
        }
        const errors = error.response.data.errors;

        Object.keys(errors).forEach(key => {
            console.log(errors[key]);
            const field = statusUpdateForm.querySelector(`[name="${key}"]`);
            if (!field) return;

            field.classList.add('is-invalid');
            field.insertAdjacentHTML('afterend', `<p class="invalid-feedback">${errors[key]}</p>`);
        })
    }).finally(() => {
        resetLoading(submitBtn, 'Submit');
    })
});
