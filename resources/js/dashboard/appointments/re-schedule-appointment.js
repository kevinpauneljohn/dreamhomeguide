import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import axios from "axios";
import {Toast} from "@/toast.js";

const rescheduleButton = document.getElementById('re-schedule-btn');
const rescheduleModalEl = document.getElementById('re-schedule-modal');
const rescheduleModal = bootstrap.Modal.getOrCreateInstance(rescheduleModalEl);
const rescheduleForm = document.getElementById('re-schedule-form');
const rescheduleSaveAppointmentBtn = document.getElementById('save-reschedule-appointment-btn');

const appointmentStatusBadge = document.getElementById('appointment-status');
const appointmentId = appointmentStatusBadge.dataset.appointmentId;

rescheduleButton.addEventListener('click', () => {
    rescheduleModal.show();
});

rescheduleForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(rescheduleForm);
    formData.append('_method', 'PUT');

    rescheduleForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    rescheduleForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    setLoading(rescheduleSaveAppointmentBtn, 'Saving...');
    axios.post(`/appointment/${appointmentId}/re-schedule`, formData)
        .then(response => {
            console.log(response);
            if(response.data.success)
            {
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })

                document.dispatchEvent(
                    new CustomEvent('update:appointment-status')
                )

                rescheduleModal.hide();
            }
            else if(response.data.success === false)
            {
                Toast.fire({
                    icon: 'warning',
                    title: response.data.message
                })
            }
        }).catch(error => {
        if (error.response && error.response.data && error.response.data.errors) {

            const errors = error.response.data.errors;

            Object.keys(errors).forEach(key => {
                const input = rescheduleForm.querySelector(`[name="${key}"]`);
                if (!input) return;

                input.classList.add('is-invalid');
                input.insertAdjacentHTML(
                    'afterend',
                    `<p class="invalid-feedback">${errors[key][0]}</p>`
                );
            });

        }
        // ❌ Server crash / 500 / logic error
        else {
            console.error('Edit appointment failed:', error);

            if(error.response.status === 422)
            {
                Toast.fire({
                    icon: 'error',
                    title: error.response.data.message
                })
            }else{
                Toast.fire({
                    icon: 'error',
                    title: 'Server error while updating appointment'
                });
            }

        }
    }).finally(() => {
        resetLoading(rescheduleSaveAppointmentBtn, 'Save changes');
    })
})

export { rescheduleButton, rescheduleModal };
