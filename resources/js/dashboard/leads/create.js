import * as bootstrap from 'bootstrap';
import "summernote/dist/summernote-lite.js";
import "summernote/dist/summernote-lite.css";

import Swal from "sweetalert2";

import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'

select2()

$(document).ready(function () {

    // set an acceptable age for birthday
    document.getElementById("birthday").setAttribute("max", acceptableDate());


    $('#notes').summernote({
        height: 250,
        placeholder: 'Write a detailed description here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link','table', 'hr']],
            ['view', ['help']],
        ]
    });

    $('#source, #user_id, #gender, #civil_status, #income_range').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select option',
        allowClear: true
    });

    $('#status').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select option',
    });

    $('#tags').select2({
        theme: 'bootstrap-5',
        placeholder: "Select tags",
        allowClear: true,
        width: '100%'
    });

    const content = document.querySelector('#lead-status-content').innerHTML;
    document.querySelectorAll('#leadStatusPopover').forEach((el) => {
        new bootstrap.Popover(el, {
            trigger: 'hover',
            html: true,
            content: content,
            'customClass': 'wide-popover',
            delay: { "show": 150, "hide": 100 } // optional smooth animation
        });
    });

});



const createLeadForm = $('#create-lead-form');
$(document).on('submit', '#create-lead-form', function (e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    saveLead(formData);
});


const saveLead = (formData) => {
    $.ajax({
        url: '/leads',
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function(){
            createLeadForm.find('.is-invalid').removeClass('is-invalid');
            createLeadForm.find('.error').remove();

            createLeadForm.find('input, select').attr('disabled', true);
            createLeadForm.find('.save-lead-button').attr('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Creating...</span>`);
        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 1300
            }).then((result) => {
                window.location.replace('/leads/'+response.lead_id);
            });

        }
    }).fail(function (xhr) {
        $.each(xhr.responseJSON.errors, function (key, value) {
            console.log(key, value);
            createLeadForm.find('#' + key).addClass('is-invalid');
            createLeadForm.find('.' + key).append(`<p class="text-danger error">${value}</p>`);
        });
    }).always(function () {
        createLeadForm.find('input, select').attr('disabled', false);
        createLeadForm.find('.save-lead-button').attr('disabled', false)
            .html(`Create Lead`);
    });
}

const acceptableDate = () => {
    // compute max date = today - 18 years
    let today = new Date();
    let year = today.getFullYear() - 18;
    let month = ("0" + (today.getMonth() + 1)).slice(-2);
    let day = ("0" + today.getDate()).slice(-2);

    return year + "-" + month + "-" + day;
}
