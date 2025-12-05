const listMyPropertyForm = $('#list-my-property-form');

$(document).on('submit', '#list-my-property-form', function(e) {
    e.preventDefault();
    let data = $(this).serializeArray();

    $.ajax({
        url: '/submit-listing',
        type: 'POST',
        data: data,
        cache: false,
        beforeSend: function(){
            listMyPropertyForm.find('.is-invalid').removeClass('is-invalid');
            listMyPropertyForm.find('.error').remove();
            listMyPropertyForm.find('input, select, textarea').attr('disabled', true);
            listMyPropertyForm.find('button').attr('disabled', true).html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Submitting...</span>`);
        }
    }).done(function (response) {
        console.log(response);
    }).fail(function (xhr) {
        console.log(xhr)
        $.each(xhr.responseJSON.errors, function (key, value) {
            listMyPropertyForm.find('#'+key).addClass('is-invalid');
            listMyPropertyForm.find('.'+key).append(`<p class="text-danger error">${value}</p>`);
        })
    }).always(function () {
        listMyPropertyForm.find('input, select, textarea').attr('disabled', false);
        listMyPropertyForm.find('button').attr('disabled', false).html(`Submit Property Details`);
    })
})
