import {slugify} from "@/dashboard/Slugify.js";
import axios from "axios";
import {Toast} from "@/toast.js";

const addProjectBtn = document.getElementById('add-project-btn');
const projectForm = document.getElementById('project-form');
const projectModal = document.getElementById('projectModal');
const saveBtn = document.getElementById('save-project-btn');

const name = document.querySelector('input[name=name]');
const slug = document.querySelector('input[name=slug]');

document.addEventListener('DOMContentLoaded', () => {
    generateSlug();

    addProjectBtn.addEventListener('click', () => {
        projectModal.querySelector('.modal-title').textContent = 'Add Project';
    })
})

const generateSlug = () => {
    document.addEventListener('keyup', () => {
        slug.value = slugify(name.value);
    })
}

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


projectForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(projectForm);

    projectForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    projectForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    setLoading()
    disableForm(projectForm);
    try {

        const result = await createProject(formData);
        if(result.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: result.message
            })
            document.dispatchEvent(
                new CustomEvent('project:created')
            );
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


const createProject = async (formData) => {
    const response = await axios.post('/project', formData);
    return response.data;
}

export {name, slug, generateSlug}
