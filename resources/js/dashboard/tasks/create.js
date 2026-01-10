import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import {Toast} from "@/toast.js";

select2()

const reminderCheckbox = document.getElementById('enableReminder');
const reminderInput = document.getElementById('reminderAt');
const linkedType = document.getElementById('linkedType');
const linkedRecord = document.getElementById('linkedRecord');

const linkedTypeSelect = document.getElementById('linkedType');
const linkedRecordSelect = document.getElementById('linkedRecord');
const createTaskForm = document.getElementById('createTaskForm');

const params = new URLSearchParams(window.location.search);

const type = params.get('type');
const id   = params.get('id');

const link = document.querySelector('input[name=link]');

reminderCheckbox.addEventListener('change', () => {
    reminderInput.disabled = !reminderCheckbox.checked;
});

linkedType.addEventListener('change', () => {
    linkedRecord.disabled = linkedType.value === '';
});

$(function(){

    console.log(type); // "appointment"
    console.log(id);   // "28"

    $('select[name=assigned_to]').select2({
        theme: 'bootstrap-5',
        placeholder: 'Assign Agent',
        allowClear: true,
    });

    if(link.value === 'appointment')
    {
        linkedTypeSelect.value = 'appointment';
    }else if(link.value === 'lead')
    {
        linkedTypeSelect.value = 'lead';
    }
    linkedTypeSelect.dispatchEvent(new Event('change'));
})

linkedTypeSelect.addEventListener('change', () => {
    const linkedRecordSelectOptions = async () => {
        const response = await axios.get(`/task/link-type/${linkedTypeSelect.value}`);
        return response.data;
    }


    if(linkedTypeSelect.value === '')
    {
        linkedRecordSelect.innerHTML = '<option value="">Select linked record</option>';
    }
    else
    {
        linkedRecordSelectOptions().then(data => {
            linkedRecordSelect.innerHTML = data;

            /* SET LINK TYPE FROM URL */
            if (type && id) {
                linkedRecordSelect.value = id;
                linkedRecordSelect.dispatchEvent(new Event('change'));
            }
        });
    }
});

const submitBtn = document.getElementById('submitTaskBtn');

createTaskForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(createTaskForm);

    document.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    // Set loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        Saving...
    `;

    axios.post('/task', formData).then(response => {
        console.log(response);
        if(response.data.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            createTaskForm.reset();
            window.location.replace('/task')
        }
    }).catch(error => {
        console.log(error);
        const errors = error.response.data.errors;

        Object.keys(errors).forEach(key => {
            createTaskForm.querySelector(`[name=${key}]`).classList.add('is-invalid');
            createTaskForm.querySelector(`[name=${key}]`)
                .insertAdjacentHTML('afterend', `<p class="invalid-feedback">${errors[key][0]}</p>`);
        });
    }).finally(() => {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Save Task';
    })
})
