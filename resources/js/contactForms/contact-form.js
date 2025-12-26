import {Toast} from '../toast.js';
const contactForm = $('#client-inquiry-form');

window.fireLeadEvent = function () {
    fbq('track', 'Lead');
};


$(document).on('submit', '#client-inquiry-form', function(form) {
    form.preventDefault();
    let data = $(this).serializeArray();
console.log(data);
    fireLeadEvent()

    $.ajax({
        url: '/submit-inquiry',
        type: 'POST',
        data: data,
        cache: false,
        beforeSend: function () {
            contactForm.find('.is-invalid').removeClass('is-invalid');
            contactForm.find('.error').remove();
            $('.success-inquiry-alert, .warning-inquiry-alert').remove();
            contactForm.find('input, select, textarea').attr('disabled', true);
            contactForm.find('button').attr('disabled', true).html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
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

            contactForm.before(`<div class="alert alert-success success-inquiry-alert" role="alert">
                    ${response.notice}
                </div>`)
            contactForm.trigger('reset');
        }else{
            contactForm.before(`<div class="alert alert-warning warning-inquiry-alert" role="alert">
                    Your listing has not been submitted successfully. <br/> You may email us at <strong>johnkevinpaunel@gmail.com</strong> instead.
                </div>`)
        }
    }).fail(function (xhr) {
        console.log(xhr)
        $.each(xhr.responseJSON.errors, function (key, value) {
            contactForm.find('#'+key).addClass('is-invalid');
            contactForm.find('.'+key).append(`<p class="text-danger error">${value}</p>`);
        })
    }).always(function () {
        contactForm.find('input, select, textarea').attr('disabled', false);
        contactForm.find('button').attr('disabled', false).html(`Submit`);
    })
})
