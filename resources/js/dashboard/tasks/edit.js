import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import {Toast} from "@/toast.js";
import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
select2()

const linkedTypeSelect = document.getElementById('linkedType');
const linkedValueId = document.getElementById('link_value');
const linkedRecordSelect = document.getElementById('linkedRecord');
const editTaskForm = document.getElementById('editTaskForm');
const task_id = document.querySelector('input[name=task_id]').value;
const updateTaskBtn = document.querySelector('.update-task-btn');

linkedTypeSelect.addEventListener('change', () => {
    linkedRecordSelect.disabled = linkedTypeSelect.value === '';
});

$(function(){

    $('select[name=assigned_to]').select2({
        theme: 'bootstrap-5',
        placeholder: 'Assign Agent',
        allowClear: true,
    });

    if(linkedTypeSelect.value === 'appointment')
    {
        linkedTypeSelect.value = 'appointment';
    }else if(linkedTypeSelect.value === 'lead')
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

            linkedRecordSelect.value = linkedValueId.value;
            linkedRecordSelect.dispatchEvent(new Event('change'));
        });
    }
});

const submitBtn = document.getElementById('submitTaskBtn');

editTaskForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(editTaskForm);

    document.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    // Set loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        Updating...
    `;

    setLoading(updateTaskBtn, 'Updating...');

    formData.append('_method', 'PUT');
    axios.post('/task/'+task_id, formData).then(response => {
        console.log(response);
        if(response.data.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
        }
        else{
            Toast.fire({
                icon: 'warning',
                title: response.data.message
            })
        }
    }).catch(error => {
        console.log(error);
        const errors = error.response.data.errors;

        Object.keys(errors).forEach(key => {
            editTaskForm.querySelector(`[name=${key}]`).classList.add('is-invalid');
            editTaskForm.querySelector(`[name=${key}]`)
                .insertAdjacentHTML('afterend', `<p class="invalid-feedback">${errors[key][0]}</p>`);
        });
    }).finally(() => {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Update Task';
        resetLoading(updateTaskBtn);
    })
})
