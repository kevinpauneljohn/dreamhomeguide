import {setMode, getMode} from "@/dashboard/projects/mode.js";
import {resetProjectForm, disableForm, enableForm} from "@/dashboard/projects/submitProject.js";
import axios from "axios";

const editButton = document.querySelector('.edit-project');
const projectModal = document.getElementById('projectModal');
const projectForm = document.getElementById('project-form');
let projectId;

const setProjectId = (project_id) => {
    projectId = project_id;
}

const getProjectId = () => {
    return projectId;
}

document.addEventListener("DOMContentLoaded", () => {
    showEditModal()
})

const setModalTitle = (title) => {
    projectModal.querySelector('.modal-title').textContent = title;
}


const showEditModal = () => {
    document.addEventListener('click', async (e) => {
        const editButton = e.target.closest('.edit-project');
        if (!editButton) return;

        const projectId = editButton.dataset.projectId;

        setMode('edit');
        resetProjectForm();
        setProjectId(projectId);
        setModalTitle('Loading project…');

        // 🔒 Disable form while fetching
        disableForm(projectForm);

        // Show modal immediately (with disabled inputs)
        const modal = new bootstrap.Modal(projectModal);
        modal.show();

        try {
            const { data } = await axios.get(`/project/${getProjectId()}/edit`);
            populateForm(data);
            setModalTitle('Edit Project');

        } catch (error) {
            console.error('Failed to load project', error);

            Toast.fire({
                icon: 'error',
                title: 'Failed to load project'
            });

            modal.hide();
        } finally {
            // 🔓 Re-enable form after fetch
            enableForm(projectForm);
        }
    });
};

const populateForm = (data) => {
    projectForm.querySelector('[name="name"]').value = data.name;
    projectForm.querySelector('[name="slug"]').value = data.slug;
    projectForm.querySelector('[name="address"]').value = data.address;
    projectForm.querySelector('[name="description"]').value = data.description ?? '';
    projectForm.querySelector('[name="status"]').value = data.status ?? '';
};


const editProject = async (formData) => {

    const response = await axios.post(`/project/${getProjectId()}`, formData);
    console.log(response.data)
    if (response.data.success) {
        document.dispatchEvent(
            new CustomEvent('project:loaded', {
                detail: response.data.data // ✅ real project data
            })
        );
    }
    return response.data;
}


export {showEditModal, editProject, getProjectId, setProjectId, projectId, editButton};


