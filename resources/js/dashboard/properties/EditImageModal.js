// import '../properties/get-property-images.js';
import {propertyImagesTable} from '../properties/get-property-images.js';
import Swal from "sweetalert2";

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

const editImageModal = $('#edit-image-modal');
let image_id = '';
$(document).on('click', '.edit-image-button', function () {

    image_id = this.id;
    $.ajax({
        url: `/property-images/${image_id}/edit`,
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {
            editImageForm.find('input, select').attr('disabled', true);
            editImageForm.find('.save').attr('disabled', true).html(`
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Loading...</span>`);
        }
    }).done(function (response) {
        editImageModal.find('img').attr({
            'src': `/storage/property_images/${response.file_name}`,
            'alt': response.name
        });

        $.each(response, function (key, value) {
            editImageModal.find(`#${key}`).val(value).change();
        })
    }).fail(function (xhr) {
        console.log(xhr)
    }).always(function () {
        editImageForm.find('input, select').attr('disabled', false);
        editImageForm.find('.save').attr('disabled', false).html(`Save Changes`);
    });
});

const editImageForm = $('.edit-image-form');

$(document).on('submit', '.edit-image-form', function (form) {
    form.preventDefault();
    let data = $(this).serializeArray();

    $.ajax({
        url: `/property-images/${image_id}`,
        type: 'PATCH',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: data,
        cache: false,
        beforeSend: function () {
            editImageForm.find('input, select').attr('disabled', true);
            editImageForm.find('.save').attr('disabled', true).html(`
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Saving...</span>`);
        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            propertyImagesTable.ajax.reload(null, false);
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
        console.log(xhr)
    }).always(function () {
        editImageForm.find('input, select').attr('disabled', false);
        editImageForm.find('.save').attr('disabled', false).html(`Save Changes`);
    })
});
