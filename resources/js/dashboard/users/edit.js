import {previewPhoto} from "@/dashboard/users/create.js";
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

const old_profile_photo = document.querySelector('#old_profile_photo').value;
const editUserForm = $('#edit-user-form');

document.querySelector('#previewImage').src = `${old_profile_photo !== '' ? '/storage/profile_pictures/'+old_profile_photo :
    'https://static.vecteezy.com/system/resources/previews/026/434/417/original/default-avatar-profile-icon-of-social-media-user-photo-vector.jpg'}`;

$(document).on('submit','#edit-user-form',function(e){
    e.preventDefault();
    let data = $(this).serializeArray();

    $.ajax({
        url: this.action,
        type: 'PUT',
        data: data,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function(){
            editUserForm.find('input, select').attr('disabled', true);
            editUserForm.find('button').attr('disabled', true).text('Saving...');
        },
    }).done(function (response) {
        console.log(response);
        if(response.success)
        {
            Toast.fire({
                icon: "success",
                title: response.message
            });
        }
        else
        {
            Toast.fire({
                icon: "warning",
                title: response.message
            });
        }
    }).fail(function (xhr) {
        console.log(xhr)
    }).always(function () {
        editUserForm.find('input, select').attr('disabled', false);
        editUserForm.find('button').attr('disabled', false).text('Save User Details');
    });
})

$(document).on('submit','#edit-profile-photo-form',function(e){
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);
    console.log(formData);
    $.ajax({
        url: this.action,
        type: 'post',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function(){}
    }).done(function (response) {
        console.log(response);
        if(response.success)
        {
            Toast.fire({
                icon: "success",
                title: response.message
            });
        }
    }).fail(function (xhr) {
        console.log(xhr)
        Toast.fire({
            icon: "error",
            title: xhr.responseText
        });
    });
})
