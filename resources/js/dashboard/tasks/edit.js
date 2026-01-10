import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import {Toast} from "@/toast.js";

select2()

const linkedTypeSelect = document.getElementById('linkedType');
const linkedValueId = document.getElementById('link_value');
const linkedRecordSelect = document.getElementById('linkedRecord');
const editTaskForm = document.getElementById('createTaskForm');

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
        console.log(linkedValueId.value);
        linkedRecordSelectOptions().then(data => {
            linkedRecordSelect.innerHTML = data;

            linkedRecordSelect.value = linkedValueId.value;
            linkedRecordSelect.dispatchEvent(new Event('change'));
        });
    }
});
