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
const calendarEl = document.getElementById('my-calendar');
const editable = calendarEl.dataset.editable;
let eventUrl = calendarEl.dataset.url;
let viewAppointmentFilter = document.getElementById('view-appointments-filter');
let appointment_id;
const appointmentForm = document.getElementById('appointment-form');
const appointmentUserId = document.getElementById('app-user-id').dataset.userId;
let mode = 'create';
let activeStatFilter = null;


const setMode = (value) => {
    mode = value;
}

const getMode = () => mode;
let currentEventUrl = `/get-appointment/user/${appointmentUserId}`;

const createTaskCheckbox = document.getElementById('create-task-input');
const createTask = document.querySelector('.create-task');

$(function () {

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
                    createTask.classList.remove('d-none');
                    createTaskCheckbox.setAttribute('checked', 'checked');
                    const modal = new bootstrap.Modal('#addAppointmentModal');
                    modal.show();
                }
            }
        },
        themeSystem: 'bootstrap5',
        editable: false,
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
        events: (info, successCallback, failureCallback) => {
            axios.get(currentEventUrl)
                .then(res => successCallback(res.data))
                .catch(err => failureCallback(err));
        },
        // events: '/get-appointments',
        eventClick: function(info) {
            console.log(info.event);
            appointmentForm.dataset.mode = 'edit';
            appointment_id = info.event.id;

            info.jsEvent.preventDefault();

            Swal.fire({
                title: info.event.title,
                text: 'What would you like to do?',
                icon: 'question',
                showCancelButton: info.event.extendedProps.showCloseButton,
                showConfirmButton: info.event.extendedProps.showEditButton,
                showDenyButton: info.event.extendedProps.showViewButton,
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
                    window.location.href = `/appointment/${info.event.id}`;
                }

                // 👉 DELETE
                if (result.dismiss === Swal.DismissReason.cancel) {
                    confirmDelete(info.event);
                }
            });

        },
        eventDidMount: function(info) {
            if(info.event.extendedProps.client === "No Client")
            {
                info.el.style.display = 'none';
            }
            info.el.setAttribute('title', 'Type: '+info.event.extendedProps.appointment_type +
                '\nClient: '+ info.event.extendedProps.client+
                '\nAssigned To: '+ info.event.extendedProps.assigned_agent+
                '\n' + moment(info.event.start).format('dddd, MMMM Do YYYY, h:mm a'));

            info.el.style.backgroundColor = info.event.extendedProps.bgColor;
            // info.el.style.color = '#fff';

        },
        eventDrop: function(info) {
            console.log(info.event);
            let formData = new FormData(appointmentForm);
            appointment_id = info.event.id;
            formData.append('_method', 'PUT');
            formData.append('title', info.event.title);
            formData.append('lead_id', info.event.extendedProps.lead_id);
            formData.append('appointment_type', info.event.extendedProps.appointment_type);
            formData.append('assigned_agent', info.event.extendedProps.agent_id);
            formData.append('appointment_date', moment(info.event.start).format('YYYY-MM-DDTHH:mm'));
            editAppointment(formData)
        },
        eventAllow: function(dropInfo, draggedEvent) {
            const today = moment().startOf('day');
            const newStart = moment(dropInfo.start);

            // Disallow dragging to past dates
            return newStart.isSameOrAfter(today);
        },
        // validRange: {
        //     start: moment().format('YYYY-MM-DD')
        // }
    });

    calendar.render();

    viewAppointmentFilter.addEventListener('change', function () {
        currentEventUrl = this.value === 'all'
            ? `/get-appointments`
            : `/get-appointment/user/${appointmentUserId}`;

        calendar.refetchEvents();
    });

    const createAppointmentButton = document.querySelector('.fc-bookAppointment-button');

    createAppointmentButton.addEventListener('click', function () {
        setMode('create');
        // appointmentForm.setAttribute('id',`appointment-form`);
        appointmentForm.querySelector('.modal-title').textContent = 'Set Appointment';
        appointmentForm.reset();
    })

    appointmentForm.addEventListener('submit', function(e){
        e.preventDefault();
        let formData = new FormData(appointmentForm);

        // console.log(mode)
        if(getMode() === 'create')
        {
            createAppointment(formData)
        }
        else if(getMode() === 'edit')
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
                    appointmentStatus();

                    if(createTaskCheckbox.checked)
                    {
                        Swal.fire({
                            title: "Good job!",
                            text: "Redirecting to create task page in 2 seconds!",
                            showConfirmButton: false,
                            icon: "success"
                        });
                        setTimeout(function (){
                            window.location.href = `/task/create?type=appointment&id=${response.data.appointment_id}`
                        },2000)
                    }
                }
                else if(response.data.success === false)
                {
                    Toast.fire({
                        icon: 'warning',
                        title: response.data.message
                    })
                }
            })
            .catch(error => {

                if (error.response && error.response.data && error.response.data.errors) {

                    const errors = error.response.data.errors;

                    Object.keys(errors).forEach(key => {
                        const input = appointmentForm.querySelector(`[name="${key}"]`);
                        if (!input) return;

                        input.classList.add('is-invalid');
                        input.insertAdjacentHTML(
                            'afterend',
                            `<p class="invalid-feedback">${errors[key][0]}</p>`
                        );
                    });

                }
                // ❌ No server response (network / 500 / 419)
                else {
                    console.error('Request failed:', error);

                    if(error.response.status === 422)
                    {
                        Toast.fire({
                            icon: 'error',
                            title: error.response.data.message
                        })
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong. Please try again.'
                        });
                    }

                }
        }).finally(() => {
            afterSaveAppointment();
        })
    }

    const editAppointment = (formData) => {
        beforeSaveAppointment();

        axios.post(`/appointment/${appointment_id}`, formData)
            .then(response => {
                console.log(response);
                if(response.data.success)
                {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    })
                    appointmentStatus();
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
            if (error.response && error.response.data && error.response.data.errors) {

                const errors = error.response.data.errors;

                Object.keys(errors).forEach(key => {
                    const input = appointmentForm.querySelector(`[name="${key}"]`);
                    if (!input) return;

                    input.classList.add('is-invalid');
                    input.insertAdjacentHTML(
                        'afterend',
                        `<p class="invalid-feedback">${errors[key][0]}</p>`
                    );
                });

            }
            // ❌ Server crash / 500 / logic error
            else {
                console.error('Edit appointment failed:', error);

                if(error.response.status === 422)
                {
                    Toast.fire({
                        icon: 'error',
                        title: error.response.data.message
                    })
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Server error while updating appointment'
                    });
                }

            }
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
                axios.delete(`/appointment/${event.id}`, {
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                })
                    .then(response => {
                        if(response.data.success)
                        {
                            Toast.fire({
                                icon: 'success',
                                title: response.data.message
                            })
                            appointmentStatus()
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
            // console.log('clicked');
        });
    }


// Edit Modal
    const openEditModal = (event) => {
        console.log(event);
        removeErrorMessages();
        mode = 'edit';

        createTask.classList.add('d-none');
        createTaskCheckbox.removeAttribute('checked');
        appointmentForm.querySelector('.modal-title').textContent = 'Edit Appointment';

        appointmentForm.querySelector('select[name=lead_id]').value = event.extendedProps.lead_id;
        appointmentForm.querySelector('select[name=appointment_type]').value = event.extendedProps.appointment_type;
        appointmentForm.querySelector('input[name=title]').value = event.title;
        appointmentForm.querySelector('input[name=appointment_date]').value = moment(event.start).format('YYYY-MM-DDTHH:mm');
        appointmentForm.querySelector('input[name=location]').value = event.extendedProps.location;
        appointmentForm.querySelector('select[name=assigned_agent]').value = event.extendedProps.agent_id;
        appointmentForm.querySelector('textarea[name=notes]').value = event.extendedProps.notes;


        const modal = new bootstrap.Modal('#addAppointmentModal');
        modal.show();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    appointmentStatus()
})

const appointmentStatus = () => {
    fetch('/appointments/stats')
        .then(res => res.json())
        .then(data => {
            document.getElementById('stat-today').textContent = data.today;
            document.getElementById('stat-upcoming').textContent = data.upcoming;
            document.getElementById('stat-pending').textContent = data.pending;
            document.getElementById('stat-overdue').textContent = data.overdue;
        });
}


