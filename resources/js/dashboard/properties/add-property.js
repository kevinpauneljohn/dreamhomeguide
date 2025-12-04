import "summernote/dist/summernote-lite.js";
import "summernote/dist/summernote-lite.css";
import Swal from "sweetalert2";
import {slugify} from '../Slugify.js';
// Initialize summernote
$(document).ready(function () {

    $('#description').summernote({
        height: 250,
        lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
        disableDragAndDrop: true,
        codeviewFilter: false,
        codeviewIframeFilter: true,
        placeholder: 'Write a detailed description here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture','table', 'hr', 'picture', 'video']],
            ['view', ['codeview','help']],
        ],
    });


});

document.addEventListener("DOMContentLoaded", function () {
    const addPropertyForm = $('.add-property-form');
    addPropertyForm.on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: '/property',
            type: 'POST',
            data: formData,
            processData: false,   // IMPORTANT: required for files
            contentType: false,   // IMPORTANT: required for files
            cache: false,
            beforeSend: function () {
                // console.log("Uploading...");
                addPropertyForm.find('.is-invalid').removeClass('is-invalid');
                addPropertyForm.find('.invalid-feedback').remove();

                addPropertyForm.find('input, select, textarea').attr('disabled', true);
                addPropertyForm.find('.save-property-btn').attr('disabled', true)
                    .html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Saving...</span>`);
            },
        }).done(function (response) {
            console.log(response);

            if(response.success === true)
            {
                let timerInterval;
                Swal.fire({
                    title: "Property Successfully Added!",
                    html: "Redirecting to the Gallery Page in <b></b> milliseconds.",
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                        window.location.replace(`/property/images/${response.property_id}`)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                    }
                });
            }

        }).fail(function (xhr) {
            console.log("Error:", xhr.responseJSON.errors);
            $.each(xhr.responseJSON.errors, function (key, value) {
                addPropertyForm.find('.' + key).append(`<p class="invalid-feedback">${value}</p>`);
                addPropertyForm.find('#' + key).addClass('is-invalid');
            });
        }).always(function () {
            addPropertyForm.find('input, select, textarea').attr('disabled', false);
            addPropertyForm.find('.save-property-btn').attr('disabled', false)
                .html(`Save Property`);
        });
    });


    /// auto slug generator from the title
    const title = $('#title');

    title.on('input', function () {
        $('#slug').val(slugify(title.val()));
    })


});



