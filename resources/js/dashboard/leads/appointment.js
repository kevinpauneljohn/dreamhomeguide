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
let mode;
let appointment_id;
const lead_id = document.querySelector('input[name=lead_id]').value;

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

                    const modal = new bootstrap.Modal('#addAppointmentModal');
                    modal.show();
                }
            }
        },
        themeSystem: 'bootstrap5',
        editable: true,
        eventStartEditable: true,
        eventDurationEditable: true,
        selectable: true,
        selectConstraint:{
            start: '00:00',
            end: '24:00'
        },
        select: function(info){
            let selectedDate = info.startStr;
            // console.log(info);

        },
        events: '/get-appointments',
        eventClick: function(info) {
            console.log(info.event);
            if (lead_id !== info.event.extendedProps.lead_id) {
                info.jsEvent.preventDefault();
            }else{
                appointmentForm.dataset.mode = 'edit';
                appointment_id = info.event.id;

                info.jsEvent.preventDefault();

                Swal.fire({
                    title: info.event.title,
                    text: 'What would you like to do?',
                    icon: 'question',
                    showCancelButton: true,

                    showDenyButton: true,
                    confirmButtonText: 'Edit',
                    denyButtonText: 'View',
                    cancelButtonText: 'Delete',

                    confirmButtonColor: '#0d6efd',
                    denyButtonColor: '#198754',
                    cancelButtonColor: '#dc3545'
                }).then(result => {

                    // 👉 EDIT
                    if (result.isConfirmed) {
                        openEditModal(info.event);
                    }

                    // 👉 VIEW
                    if (result.isDenied) {
                        openViewModal(info.event);
                    }

                    // 👉 DELETE
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        confirmDelete(info.event);
                    }
                });
            }


        },
        eventDidMount: function(info) {
            info.el.setAttribute('title', 'Type: '+info.event.extendedProps.appointment_type +
                '\nClient: '+ info.event.extendedProps.client+
                '\nAssigned To: '+ info.event.extendedProps.assigned_agent+
                '\n' + moment(info.event.start).format('dddd, MMMM Do YYYY, h:mm a'));

        },
        eventDrop: function(info) {

            let formData = new FormData(appointmentForm);
            appointment_id = info.event.id;
            formData.append('_method', 'PUT');
            formData.append('title', info.event.title);
            formData.append('appointment_type', info.event.extendedProps.appointment_type);
            formData.append('user_id', info.event.extendedProps.agent_id);
            formData.append('appointment_date', moment(info.event.start).format('YYYY-MM-DDTHH:mm'));
            editAppointment(formData)
        },
    });


    // FIX: re-render when tab becomes visible
    $('button[data-bs-target="#appointment"]').on('shown.bs.tab', function () {
        calendar.render();

        const createAppointmentButton = document.querySelector('.fc-bookAppointment-button');

        createAppointmentButton.addEventListener('click', function () {
            mode = 'create';
            // appointmentForm.setAttribute('id',`appointment-form`);
            appointmentForm.querySelector('.modal-title').textContent = 'Set Appointment';
            appointmentForm.reset();
        })
    });

});

const appointmentForm = document.getElementById('appointment-form');

appointmentForm.addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(appointmentForm);


    // console.log(mode)
    if(mode === 'create')
    {
        createAppointment(formData)
    }
    else if(mode === 'edit')
    {
        formData.append('_method', 'PUT');
        editAppointment(formData)
    }

});

const createAppointment = (formData) => {
    beforeSaveAppointment();

    axios.post('/appointment', formData)
        .then(response => {
            console.log(response);
            if(response.data.success)
            {
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
                appointmentForm.reset();
                calendar.refetchEvents();
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
}

const editAppointment = (formData) => {
    beforeSaveAppointment();

    axios.post(`/appointment/${appointment_id}`, formData)
        .then(response => {
            if(response.data.success)
            {
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
                calendar.refetchEvents();
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
}

const confirmDelete = (event) => {
    Swal.fire({
        title: `Remove ${event.title}`,
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/appointment/${event.id}`)
            .then(response => {
                if(response.data.success)
                {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    })
                    calendar.refetchEvents();
                }
                else if(response.data.success === false)
                {
                    Toast.fire({
                        icon: 'warning',
                        title: response.data.message
                    })
                }
            }).catch(error => {
                console.log(error);
            })
        }
    })
}

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
        appointmentForm.reset();
        console.log('clicked');
    });
}


// Edit Modal
const openEditModal = (event) => {
    // console.log(event);
    removeErrorMessages();
    mode = 'edit';

    appointmentForm.querySelector('.modal-title').textContent = 'Edit Appointment';

    appointmentForm.querySelector('select[name=appointment_type]').value = event.extendedProps.appointment_type;
    appointmentForm.querySelector('input[name=title]').value = event.title;
    appointmentForm.querySelector('input[name=appointment_date]').value = moment(event.start).format('YYYY-MM-DDTHH:mm');
    appointmentForm.querySelector('input[name=location]').value = event.extendedProps.location;
    appointmentForm.querySelector('textarea[name=notes]').value = event.extendedProps.notes;


    const modal = new bootstrap.Modal('#addAppointmentModal');
    modal.show();
}


// End of Edit Modal







