import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';

let calendar;

$(function () {
    const calendarEl = document.getElementById('calendar');

    // Initialize calendar but DO NOT render yet
    calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, bootstrap5Plugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'bookAppointment dayGridMonth,timeGridWeek,listWeek'
        },
        titleFormat: { year: 'numeric', month: 'short', day: 'numeric' },
        height: 650,
        themeSystem: 'bootstrap5',
        customButtons: {
            bookAppointment: {
                text: "Create Appointment",
                click: function () {
                    console.log("Create appointment clicked");
                    const modal = new bootstrap.Modal('#addAppointmentModal');
                    modal.show();
                }
            }
        }
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
