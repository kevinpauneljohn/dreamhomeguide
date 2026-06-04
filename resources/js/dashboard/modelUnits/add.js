import {slugify} from "@/dashboard/Slugify.js";
import {setMode, getMode} from "@/dashboard/projects/mode.js";
import {enableForm} from "@/dashboard/projects/submitProject.js";
import {Toast} from "@/toast.js";
import {resetLoading} from "@/dashboard/modelUnits/button-loader.js";

const addModelUnitButton = document.getElementById('add-model-unit-btn');
const modelUnitModal = document.getElementById('model-unit-modal');
const modelUnitForm = document.getElementById('model-unit-form');
const modelUnitName = document.getElementById('model-unit-name');
const modelUnitSlug = document.getElementById('model-unit-slug');
const saveModelBtn = document.getElementById('save-model-unit-btn');

addModelUnitButton.addEventListener('click', () => {
    modelUnitModal.querySelector('.modal-title').textContent = 'Add Model Unit';
    setMode('create model unit');
    resetModelUnitForm();

    const modal = bootstrap.Modal.getOrCreateInstance(modelUnitModal);
    modal.show();
});

modelUnitName.addEventListener('input', () => {
    modelUnitSlug.value = slugify(modelUnitName.value);
})


const resetModelUnitForm = () => {
    // Reset field values
    modelUnitForm.reset();

    // Remove validation styles
    modelUnitForm.querySelectorAll('.is-invalid, .is-valid')
        .forEach(el => el.classList.remove('is-invalid', 'is-valid'));

    // Remove validation messages
    modelUnitForm.querySelectorAll('.invalid-feedback, .valid-feedback')
        .forEach(el => el.remove());

    // Clear dynamic state
    delete modelUnitForm.dataset.submitting;
};


const createModelUnit = (formData) => {
    axios.post('/model-units', formData)
        .then(response => {
            console.log(response);

            if (response.data.success === true) {
                resetModelUnitForm();

                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                });

                document.dispatchEvent(new CustomEvent('reload:table'));
            }
        })
        .catch(error => {
            console.log(error);

            const status = error.response?.status;
            const data = error.response?.data;

            console.log('Status:', status);
            console.log('Data:', data);

            if (data?.status === false) {
                Toast.fire({
                    icon: 'warning',
                    title: data.message
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data?.message || 'Something went wrong. Please try again.'
                });
            }

            const errors = data?.errors || {};

            Object.keys(errors).forEach(key => {
                const field = modelUnitForm.querySelector(`[name="${key}"]`);
                if (!field) return;

                field.classList.add('is-invalid');
                field.insertAdjacentHTML(
                    'afterend',
                    `<p class="invalid-feedback">${errors[key][0]}</p>`
                );
            });
        })
        .finally(() => {
            resetLoading(saveModelBtn);
            enableForm(modelUnitForm);
        });
};

export {resetModelUnitForm, createModelUnit};


