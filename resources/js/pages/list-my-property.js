import {Toast} from '../toast.js';
const listMyPropertyForm = $('#list-my-property-form');

window.fireLeadEvent = function () {
    fbq('track', 'Lead');
};

$(document).on('submit', '#list-my-property-form', function(e) {
    e.preventDefault();
    let data = $(this).serializeArray();
    fireLeadEvent();

    $.ajax({
        url: '/submit-listing',
        type: 'POST',
        data: data,
        cache: false,
        beforeSend: function(){
            listMyPropertyForm.find('.is-invalid').removeClass('is-invalid');
            listMyPropertyForm.find('.error').remove();
            $('#list-form').find('.alert').remove();
            listMyPropertyForm.find('input, select, textarea').attr('disabled', true);
            listMyPropertyForm.find('button').attr('disabled', true).html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Submitting...</span>`);
        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            Toast.fire({
                icon: "success",
                title: response.message,
            })

            listMyPropertyForm.before(`<div class="alert alert-success" role="alert">
                    ${response.notice}
                </div>`)
            listMyPropertyForm.trigger('reset');
        }else{
            listMyPropertyForm.before(`<div class="alert alert-warning" role="alert">
                    Your listing has not been submitted successfully. <br/> You may email us at <strong>johnkevinpaunel@gmail.com</strong> instead.
                </div>`)
        }
    }).fail(function (xhr) {
        console.log(xhr)
        if(xhr.responseJSON.success === false)
        {
            listMyPropertyForm.before(`<div class="alert alert-danger" role="alert">
                    ${xhr.responseJSON.message}
                </div>`)
        }
        $.each(xhr.responseJSON.errors, function (key, value) {
            listMyPropertyForm.find('#'+key).addClass('is-invalid');
            listMyPropertyForm.find('.'+key).append(`<p class="text-danger error">${value}</p>`);
        })
    }).always(function () {
        listMyPropertyForm.find('input, select, textarea').attr('disabled', false);
        listMyPropertyForm.find('button').attr('disabled', false).html(`Submit Property Details`);
    })
})
