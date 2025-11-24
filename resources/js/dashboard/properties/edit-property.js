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

let description = $('#property_description').val();
let property_id = $('input[name=property_id]').val();
$('#description').summernote('code', description);

const editPropertyForm = $('.edit-property-form');
$(document).on('submit', '.edit-property-form', function(form){
    form.preventDefault();
    let data = $(this).serializeArray();
    console.log(data);

    $.ajax({
        url: '/property/'+property_id,
        type: 'PATCH',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: data,
        cache: false,
        beforeSend: function () {
            // console.log("Uploading...");
            editPropertyForm.find('.is-invalid').removeClass('is-invalid');
            editPropertyForm.find('.invalid-feedback').remove();
        },
    }).done(function (response) {
        console.log(response);

        if(response.success === true)
        {
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
        console.log("Error:", xhr.responseJSON.errors);
        $.each(xhr.responseJSON.errors, function (key, value) {
            editPropertyForm.find('.' + key).append(`<p class="invalid-feedback">${value}</p>`);
            editPropertyForm.find('#' + key).addClass('is-invalid');
        });
    }).always(function () {

    });
})

const urlParams = new URLSearchParams(window.location.search);
const youtubeVideoInput = $('#youtube_video_id');
if (urlParams.has('youtube_video')) {
    console.log('YouTube video parameter detected');
    youtubeVideoInput.focus();
}

