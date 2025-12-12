import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import moment from "moment";

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
        customButtons: {
            bookAppointment: {
                text: "Create Appointment",
                click: function () {
                    console.log("Create appointment clicked");
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

            if(moment(selectedDate).isBefore(moment('{{now()}}')))
            {
            }
        },
        // events: '/get-appointments',
        eventClick: function(info) {
            alert('Event: ' + info.event.title);
            alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            alert('View: ' + info.view.type);

            // change the border color just for fun
            info.el.style.borderColor = 'red';
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
