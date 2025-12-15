import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import interactionPlugin from '@fullcalendar/interaction';
import moment from "moment";
import axios from 'axios';
import {Toast} from "@/toast.js";


let calendar;

$(function () {
    const calendarEl = document.getElementById('calendar');

    // Initialize calendar but DO NOT render yet
    calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, bootstrap5Plugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'bookAppointment dayGridMonth,timeGridWeek,listWeek'
        },
        titleFormat: { year: 'numeric', month: 'short', day: 'numeric' },
        height: 650,
        customButtons: {
            bookAppointment: {
                text: "Create Appointment",
                click: function () {
                    removeErrorMessages();
                    const modal = new bootstrap.Modal('#addAppointmentModal');
                    modal.show();
                }
            }
        },
        themeSystem: 'bootstrap5',
        editable: true,
        selectable: true,
        selectConstraint:{
            start: '00:00',
            end: '24:00'
        },
        select: function(info){
            let selectedDate = info.startStr;
            console.log(info);

        },
        // events: '/get-appointments',
        eventClick: function(info) {
            console.log(info);
            alert('Event: ' + info.event.title);
            alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            alert('View: ' + info.view.type);

            // change the border color just for fun
            info.el.style.borderColor = 'red';
        },
    });

    // Render immediately IF calendar tab is active
    if ($("#appointment").hasClass("show active")) {
        calendar.render();
    }

    // FIX: re-render when tab becomes visible
    $('button[data-bs-target="#appointment"]').on('shown.bs.tab', function () {
        calendar.render();
    });

});

const appointmentForm = document.getElementById('appointment-form');
appointmentForm.addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(appointmentForm);

    beforeSaveAppointment();

    axios.post('/appointment', formData)
        .then(response => {
        console.log(response.data);

        if(response.data.success)
        {
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            appointmentForm.reset();
        }
        else if(response.data.success === false)
        {
            Toast.fire({
                icon: 'warning',
                title: response.data.message
            })
        }
    }).catch(error => {
        const errors = error.response.data.errors;

        Object.keys(errors).forEach(key => {
            appointmentForm.querySelector(`[name=${key}]`).classList.add('is-invalid');
            appointmentForm.querySelector(`[name=${key}]`)
                .insertAdjacentHTML('afterend', `<p class="invalid-feedback">${errors[key][0]}</p>`);
        });
    }).finally(() => {
        afterSaveAppointment();
    })
});

const removeErrorMessages = () => {
    appointmentForm.querySelectorAll('.is-invalid').forEach(input => {
        input.classList.remove('is-invalid');
    })
    appointmentForm.querySelectorAll('.invalid-feedback').forEach(error => {
        error.remove();
    })
}

const beforeSaveAppointment = () => {
    removeErrorMessages();

    appointmentForm.querySelectorAll('input, textarea').forEach(input => {
        input.disabled = true;
    })

    appointmentForm.querySelector('button[type=submit]').disabled = true;
    appointmentForm.querySelector('button[type=submit]')
        .innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
}

const afterSaveAppointment = () => {
    appointmentForm.querySelectorAll('input, textarea').forEach(input => {
        input.disabled = false;
    })
    appointmentForm.querySelector('button[type=submit]').disabled = false;
    appointmentForm.querySelector('button[type=submit]').innerHTML = 'Save Appointment';
}

const setAppointmentButton = document.querySelector('.set-appointment-btn');

if (setAppointmentButton) {
    setAppointmentButton.addEventListener('click', function () {
        removeErrorMessages();
        console.log('clicked');
    });
}





