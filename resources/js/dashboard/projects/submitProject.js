import {createProject} from "@/dashboard/projects/create.js";
import {editProject} from "@/dashboard/projects/edit.js";
import {Toast} from "@/toast.js";
const saveBtn = document.getElementById('save-project-btn');
const projectForm = document.getElementById('project-form');
import {getMode} from "@/dashboard/projects/mode.js";


document.addEventListener('DOMContentLoaded', () => {

})
const setLoading = () => {
    saveBtn.disabled = true;
    saveBtn.dataset.originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-1"></span>
        Saving...
    `;
};

const resetLoading = () => {
    saveBtn.disabled = false;
    saveBtn.innerHTML = saveBtn.dataset.originalText || 'Save';
};

const disableForm = (form) => {
    [...form.elements].forEach(el => {
        el.dataset.wasDisabled = el.disabled;
        el.disabled = true;
    });
};

const enableForm = (form) => {
    [...form.elements].forEach(el => {
        el.disabled = el.dataset.wasDisabled === 'true';
        delete el.dataset.wasDisabled;
    });
};

const resetProjectForm = () => {
    // Reset field values
    projectForm.reset();

    // Remove validation styles
    projectForm.querySelectorAll('.is-invalid, .is-valid')
        .forEach(el => el.classList.remove('is-invalid', 'is-valid'));

    // Remove validation messages
    projectForm.querySelectorAll('.invalid-feedback, .valid-feedback')
        .forEach(el => el.remove());

    // Clear dynamic state
    delete projectForm.dataset.submitting;
};


projectForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(projectForm);

    projectForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    projectForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    setLoading()
    disableForm(projectForm);
    try {

        if(getMode() === 'create')
        {
            const result = await createProject(formData);
            if(result.success === true)
            {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })
                document.dispatchEvent(
                    new CustomEvent('project:created_or_updated')
                );
            }
        }
        else if(getMode() === 'edit'){
            formData.append('_method', 'PUT');
            const result = await editProject(formData);
            if(result.success === true)
            {
                Toast.fire({
                    icon: 'success',
                    title: result.message
                })
                document.dispatchEvent(
                    new CustomEvent('project:created_or_updated')
                );
            }else{
                Toast.fire({
                    icon: 'warning',
                    title: result.message
                })
            }
        }

    }
    catch (error)
    {
        console.log(error);
        const errors = error.response?.data?.errors;

        // 🚨 NOT a validation error (network / 500 / unexpected)
        if (!errors || typeof errors !== 'object') {
            Toast.fire({
                icon: 'error',
                title: error.response?.data?.message || 'Something went wrong'
            });
            return;
        }

        // ✅ Validation errors
        Object.keys(errors).forEach(key => {
            const field = projectForm.querySelector(`[name="${key}"]`);
            if (!field) return;

            field.classList.add('is-invalid');
            field.insertAdjacentHTML(
                'afterend',
                `<p class="invalid-feedback">${errors[key][0]}</p>`
            );
        });
    } finally {
        enableForm(projectForm);
        resetLoading();
        delete projectForm.dataset.submitting;
    }
})

export {setLoading, resetLoading, resetProjectForm, disableForm, enableForm, projectForm};
