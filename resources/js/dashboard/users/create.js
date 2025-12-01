import Swal from "sweetalert2";

const createUserForm = $('#create-user-form');

$(document).on('submit','#create-user-form', function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    saveUser(formData);
});


///preview the photo
export const previewPhoto = (event) => {
    const preview = document.getElementById('previewImage');
    preview.src = URL.createObjectURL(event.target.files[0]);
}

window.previewPhoto = previewPhoto;

const saveUser = (formData) => {
    $.ajax({
        url: '/user',
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function(){
            createUserForm.find('.is-invalid').removeClass('is-invalid');
            createUserForm.find('.error').remove();

            createUserForm.find('input, select').attr('disabled', true);
            createUserForm.find('.save-user-button').attr('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Saving...</span>`);
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
                window.location.replace('/user');
            });

        }
    }).fail(function (xhr) {
        $.each(xhr.responseJSON.errors, function (key, value) {
            console.log(key, value);
            createUserForm.find('#' + key).addClass('is-invalid');
            createUserForm.find('.' + key).append(`<p class="text-danger error">${value}</p>`);
        });
    }).always(function () {
        createUserForm.find('input, select').attr('disabled', false);
        createUserForm.find('.save-user-button').attr('disabled', false)
            .html(`Save`);
    });
}
