import {Toast} from '@/toast.js'
import {notesTable} from "../notes/notesTable.js";
import moment from "moment";
import {reloadActivityLogs} from "@/component/activities/logs.js";
import Swal from "sweetalert2";

let noteId = '';
const addNoteModal = $('#addNoteModal');

$(function () {
    let birthday = $('#birthday').val(); // Example: 2025-01-20 00:00:00

// Format for input[type="date"]
    let formatted = moment(birthday).format("YYYY-MM-DD");

// Set value
    $('#birthday-input').val(formatted).change();
});

$(document).on('click', '.edit-note-btn', function(){
    noteId = this.id;
    addNoteModal.find('.modal-title').text('Edit Note')
    addNoteModal.find('form').attr('id','editNoteForm')
    addNoteModal.find('.is-invalid').removeClass('is-invalid');
    addNoteModal.find('.error').remove();
    let myModal = new bootstrap.Modal(document.getElementById('addNoteModal'));
    myModal.show();
    getNoteDetails();
})

const getNoteDetails = () => {
    $.ajax({
        url: `/note/${noteId}/edit`,
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {

        }
    }).done(function (response) {
        $.each(response, function (key, value) {
            $('#'+key).val(value).change();
        })
    }).fail(function (xhr) {

    }).always(function () {

    });
}

$(document).on('submit','#editNoteForm',function(e){
    e.preventDefault();
    let data = $(this).serializeArray();
    updateNote(data);
})

const updateNote = (formData) => {
    $.ajax({
        url: `/note/${noteId}`,
        type: 'PUT',
        data: formData,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {

        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            notesTable.ajax.reload(null, false);
            reloadActivityLogs();
            Toast.fire({
                icon: "success",
                title: response.message
            });
        }else{
            Toast.fire({
                icon: "warning",
                title: response.message
            });
        }
    }).fail(function (xhr) {
        const obj = xhr.responseJSON;

        if ('success' in obj && xhr.status === 401) {
            Swal.fire({
                title: xhr.responseJSON.message,
                icon: "error"
            });
        }
    }).always(function () {

    });
}

