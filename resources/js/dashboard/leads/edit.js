import {Toast} from "@/toast.js";
import select2 from 'select2';
select2()

import moment from "moment";

const lead_id = $('input[name=lead_id]').val();
const leadName = document.querySelector('.lead-name');
let firstName = document.getElementById("first_name").value;
let lastName = document.getElementById("last_name").value;
let fullName;

const setFullName = (first_name, last_name) => {
    const ucWords = str =>
        str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());

    first_name = ucWords(first_name);
    last_name = ucWords(last_name);

    fullName = `${first_name} ${last_name}`;
}

const getFullName = () => {
    return fullName;
}
$(document).ready(function () {

    setFullName(firstName, lastName);
    leadName.innerText = getFullName();

    $('#income_range').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Income Range',
        allowClear: true,
        // dropdownParent: $('#addNoteModal')
    });

    $('#source').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select lead Source',
        allowClear: true,
        // dropdownParent: $('#addNoteModal')
    });

    $('#user_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Assign Agent',
        allowClear: true,
        // dropdownParent: $('#addNoteModal')
    });

    // Click ✏️ to open edit mode
    $(".edit-icon").on("click", function () {
        let container = $(this).closest(".editable-field");

        container.find(".value-text").addClass("d-none");
        container.find(".edit-btn").addClass("d-none");
        container.find(".edit-input").removeClass("d-none");
    });

    // Cancel edit
    $(".cancel-btn").on("click", function () {
        let container = $(this).closest(".editable-field");

        container.find(".value-text").removeClass("d-none");
        container.find(".edit-btn").removeClass("d-none");
        container.find(".edit-input").addClass("d-none");
    });

    // Save edit (AJAX)
    $(".save-btn").on("click", function () {
        let container = $(this).closest(".editable-field");

        let newValue = container.find(".input-box").val();
        let field = container.data("field");
        let data = [
            { name: field, value: newValue },
        ];

        $.ajax({
            url: `/lead/${lead_id}/update-field`,
            method: "patch",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            success: function (response) {

                container.find(".value-text").text(newValue);

                container.find(".value-text").removeClass("d-none");
                container.find(".edit-btn").removeClass("d-none");
                container.find(".edit-input").addClass("d-none");

                if(response.success === true)
                {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });

                    newValue = response.field === 'user_id' ? response.agent : newValue;
                    newValue = response.field === 'birthday'? moment(newValue).format("MMM DD, YYYY") : newValue;

                    container.find(".value").text(newValue);

                    if(response.field === 'first_name')
                    {
                        firstName = newValue;
                    }

                    if(response.field === 'last_name')
                    {
                        lastName = newValue;
                    }

                    setFullName(firstName, lastName);
                    leadName.innerText = getFullName();

                }
                else
                {
                    Toast.fire({
                        icon: "warning",
                        title: response.message
                    });
                }
            },error: function (xhr) {
                console.log(xhr);
                $.each(xhr.responseJSON.errors, function (key, value) {
                    Toast.fire({
                        icon: "warning",
                        title: value
                    });
                })
            }
        });
    });

});

const birthdayInput = $('#birthday-input');
function isValidDate(dateString) {
    // moment strict mode check
    return moment(dateString, "YYYY-MM-DD", true).isValid();
}

birthdayInput.on('input change', function () {
    let val = $(this).val();

    if (!isValidDate(val)) {
        showError("Invalid date format.");
        birthdayInput.closest('.edit-input').find('.save-btn').prop('disabled', true);
        return;
    }else{
        birthdayInput.closest('.edit-input').find('.save-btn').prop('disabled', false);
    }

    let year = moment(val).year();

    if (year < 1900 || year > 2100) {
        showError("Year must be between 1900 and 2100.");
        $(this).addClass('is-invalid');
        birthdayInput.closest('.edit-input').find('.save-btn').prop('disabled', true);
    } else {
        birthdayInput.closest('.edit-input').find('.save-btn').prop('disabled', false);
        hideError();
    }
});

function showError(msg) {
    birthdayInput.addClass('is-invalid');
    $('#birthday-error').text(msg);

}

function hideError() {
    birthdayInput.removeClass('is-invalid');
    $('#birthday-error').text("");
}

