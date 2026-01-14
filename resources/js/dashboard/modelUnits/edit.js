import {setMode} from "@/dashboard/projects/mode.js";
import {disableForm, enableForm} from "@/dashboard/projects/submitProject.js";
import {resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import {Toast} from "@/toast.js";


const modelUnitModal = document.getElementById('model-unit-modal');
const modelUnitForm = document.getElementById('model-unit-form');
const saveModelBtn = document.getElementById('save-model-unit-btn');

let modelUnitId;

document.addEventListener('click', (e) => {
    const editModelUnitButton = e.target.closest('.edit-model-unit');
    if (!editModelUnitButton) return; // ✅ guard clause

    modelUnitForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    modelUnitForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    setMode('edit model unit');
    modelUnitModal.querySelector('.modal-title').textContent = 'Edit Model Unit';

    modelUnitId = editModelUnitButton.dataset.modelUnitId;

    disableForm(modelUnitForm);
    getModelUnit().then(data => {
        Object.keys(data).forEach(key => {
            const field = modelUnitForm.querySelector(`[name="${key}"]`);
            if (!field) return;

            field.value = data[key];
        });

    }).finally(() => {
        enableForm(modelUnitForm);
        resetLoading(saveModelBtn);
    })

    const modal = bootstrap.Modal.getOrCreateInstance(modelUnitModal);
    modal.show();
});

const getModelUnit = async () => {
    const response = await axios.get(`/model-units/${modelUnitId}/edit`)
    return response.data;
}

const updateModelUnit = (formData, id) => {
    formData.append('_method', 'PUT');
    axios.post(`/model-units/${id}`, formData)
        .then(response => {

            if(response.data.success === true)
            {
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
                document.dispatchEvent(
                    new CustomEvent('reload:table')
                );
            }
            else if (response.data.success === false)
            {
                Toast.fire({
                    icon: 'warning',
                    title: response.data.message
                })
            }
            console.log(
                response.data.success === true ? 'success' : 'failed'
            )

        })
        .catch(error => {
            console.log(error);
            if(error.response.data.status === false)
            {
                Toast.fire({
                    icon: 'warning',
                    title: error.response.data.message
                })
            }
            const errors = error.response?.data?.errors;
            Object.keys(errors).forEach(key => {
                const field = modelUnitForm.querySelector(`[name="${key}"]`);
                if (!field) return;

                field.classList.add('is-invalid');
                field.insertAdjacentHTML(
                    'afterend',
                    `<p class="invalid-feedback">${errors[key][0]}</p>`
                );
            });
        }).finally(() => {
        resetLoading(saveModelBtn);
        enableForm(modelUnitForm);
    })

}

export {updateModelUnit, modelUnitId, getModelUnit};
