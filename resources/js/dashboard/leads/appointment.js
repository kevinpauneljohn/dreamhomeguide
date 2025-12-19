import {calendar, setMode, getMode, appointmentForm} from "@/component/appointment/calendar.js";

// FIX: re-render when tab becomes visible
$('button[data-bs-target="#appointment"]').on('shown.bs.tab', function () {
    calendar.render();

    const createAppointmentButton = document.querySelector('.fc-bookAppointment-button');

    createAppointmentButton.addEventListener('click', function () {
        setMode('create');
        // appointmentForm.setAttribute('id',`appointment-form`);
        appointmentForm.querySelector('.modal-title').textContent = 'Set Appointment';
        appointmentForm.reset();
    })
});
