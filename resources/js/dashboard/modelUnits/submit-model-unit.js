import {disableForm} from "@/dashboard/projects/submitProject.js";
import {setLoading} from "@/dashboard/modelUnits/button-loader.js";
import {createModelUnit} from "@/dashboard/modelUnits/add.js";
import {getMode} from "@/dashboard/projects/mode.js";
import {modelUnitId} from "@/dashboard/modelUnits/edit.js";
import {updateModelUnit} from "@/dashboard/modelUnits/edit.js";

const modelUnitForm = document.getElementById('model-unit-form');
const saveModelBtn = document.getElementById('save-model-unit-btn');

modelUnitForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(modelUnitForm);

    modelUnitForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    modelUnitForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    disableForm(modelUnitForm);
    setLoading(saveModelBtn)
    if (getMode() === 'create model unit')
    {
        createModelUnit(formData);
    }
    else if(getMode() === 'edit model unit')
    {
        updateModelUnit(formData, modelUnitId);
    }
})
