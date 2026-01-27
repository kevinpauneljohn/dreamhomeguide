import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import axios from "axios";
import {Toast} from "@/toast.js";

const completeStatusModal = document.getElementById('complete-status-note-modal');
const statusUpdateForm = document.getElementById('status-update-form');
const submitBtn = document.getElementById('submit-accomplishment-button');

statusUpdateForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(statusUpdateForm);

    statusUpdateForm.querySelectorAll('.is-invalid').forEach((element) => {
        element.classList.remove('is-invalid');
    })

    statusUpdateForm.querySelectorAll('.invalid-feedback').forEach((element) => {
        element.remove()
    })

    setLoading(submitBtn, 'Submitting...');
    axios.post('/appointment-activity',formData).then((response) => {
        console.log(response)
        if(response.data.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: response.data.message,
            })
        }
    }).catch((error) => {
        // console.log(error.response.data.errors)
        const errors = error.response.data.errors;

        Object.keys(errors).forEach(key => {
            console.log(errors[key]);
            const field = statusUpdateForm.querySelector(`[name="${key}"]`);
            if (!field) return;

            field.classList.add('is-invalid');
            field.insertAdjacentHTML('afterend', `<p class="invalid-feedback">${errors[key]}</p>`);
        })
    }).finally(() => {
        resetLoading(submitBtn, 'Submit');
    })
});
