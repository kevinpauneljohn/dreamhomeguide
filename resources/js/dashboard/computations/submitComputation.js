import {saveComputation} from "@/dashboard/computations/add.js";
import {updateComputation, getComputationId} from "@/dashboard/computations/edit.js";
import {getMode} from "@/dashboard/projects/mode.js";

const computationForm = document.getElementById('computationForm');


computationForm.addEventListener('submit', (e) => {
    e.preventDefault();
    computationForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    computationForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());
    const formData = new FormData(computationForm);

    console.log(getComputationId());
    if(getMode() === 'create computation')
    {
        saveComputation(formData)
    }
    else if(getMode() === 'edit computation')
    {
        updateComputation(formData, getComputationId());
    }
})
