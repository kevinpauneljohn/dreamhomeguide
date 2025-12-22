import "datatables.net-bs5";

import '../../../css/properties.css';

import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import Swal from "sweetalert2";
import {reloadActivityLogs} from "@/component/activities/logs.js";
select2()

import {notesTable} from "../notes/notesTable.js";
window.notesTable = notesTable;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

$(function(){
    $('#type').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Type',
        allowClear: true,
        dropdownParent: $('#addNoteModal')
    });

    ///character counter for description
    $('#description').on('input', function () {
        let max = $(this).attr('maxlength');
        let length = $(this).val().length;

        $('#char_count').text(length);
    });

});
const addNoteModal = $('#addNoteModal');

$(document).on('click','.add-note-btn', function(){
    addNoteModal.find('form').attr('id','addNoteForm')
    addNoteModal.find('.modal-title').text('Add Note')
    addNoteForm.find('#type, textarea').val('').change();
    addNoteForm.find('.is-invalid').removeClass('is-invalid');
    addNoteForm.find('.error').remove();
    $('#char_count').text('0');
})

///add note form
const addNoteForm = $('#addNoteForm');
$(document).on('submit', '#addNoteForm', function(form){
    form.preventDefault();
    let data = $(this).serializeArray();

    addNote(data);
})

const addNote = (formData) => {
    $.ajax({
        url: '/note',
        type: 'POST',
        data: formData,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function(){

            addNoteForm.find('.is-invalid').removeClass('is-invalid');
            addNoteForm.find('.error').remove();

            addNoteForm.find('input, select, textarea').attr('disabled', true);
            addNoteForm.find('.add-note-form-submit').attr('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Saving...</span>`);
        }
    }).done(function(response){
        if(response.success === true)
        {
            Toast.fire({
                icon: "success",
                title: response.message
            });
            notesTable.ajax.reload(null, false);
            reloadActivityLogs();
        }
        else
        {
            Toast.fire({
                icon: "warning",
                title: response.message
            });
        }
    }).fail(function(xhr){
        $.each(xhr.responseJSON.errors, function (key, value) {
            Toast.fire({
                icon: "warning",
                title: value
            });
            addNoteForm.find('#' + key).addClass('is-invalid');
            addNoteForm.find('.' + key).append(`<p class="invalid-feedback error">${value}</p>`);
        });
    }).always(function () {
        addNoteForm.find('input, select, textarea, button').attr('disabled', false);
        addNoteForm.find('.add-note-form-submit').text('Save Note');
        addNoteForm.find('#type, textarea').val('').change();
        $('#char_count').text('0');
    });
}



