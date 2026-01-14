import axios from "axios";
import moment from "moment";
import {showEditModal} from "@/dashboard/projects/edit.js";
import Swal from "sweetalert2";

let projectData;

const projectName = document.querySelectorAll('.project-name');
const projectSlug = document.querySelectorAll('.project-slug');
const projectCreatedAt = document.querySelectorAll('.project-created-at');
const projectStatus = document.querySelector('.project-status');
const projectDescription = document.querySelector('.project-description');

const setPageTitle = (name) => {
    document.title = `${name}`;
};

const setProjectName = (name) => {
    projectName.forEach(el => {
        el.textContent = name;
    });
};

const setProjectSlug = (slug) => {
    projectSlug.forEach(el => {
        el.textContent = slug;
    });
}

const setProjectCreatedAt = (createdAt) => {
    projectCreatedAt.forEach(el => {
        el.textContent = moment(createdAt).format('MMM D, YYYY hh:mm A');
    });
}

const setProjectStatus = (status) => {
    let badge = `<h6 class="text-muted mb-1">Status</h6><span class="badge bg-success">Published</span>`
    if(status === 'draft')
    {
        badge = `<h6 class="text-muted mb-1">Status</h6><span class="badge bg-warning">Draft</span>`
    }
    projectStatus.innerHTML = badge;
}

const setProjectDescription = (description) => {
    projectDescription.innerHTML = description
        ? description.replace(/\r?\n/g, '<br>')
        : '<span class="text-muted">No description provided.</span>';
};

const projectInfo = (projectData) => {
    setProjectName(projectData.name);
    setProjectSlug(projectData.slug);
    setProjectCreatedAt(projectData.created_at);
    setProjectStatus(projectData.status);
    setProjectDescription(projectData.description);
    setPageTitle(projectData.name);
}


document.addEventListener('DOMContentLoaded', async () => {

    const projectEl = document.getElementById('project');
    if (!projectEl) {
        console.error('Project element not found');
        return;
    }

    const projectId = projectEl.dataset.projectId;
    if (!projectId) {
        console.error('Project ID missing');
        return;
    }


    try {
        const { data } = await axios.get(`/project/${projectId}/edit`);
        projectInfo(data);
    } catch (error) {
        console.error('Failed to fetch project', error);
    }

    document.addEventListener('project:loaded', (e) => {
        projectInfo(e.detail);
    });

});


const deleteButton = document.querySelector('.delete-project');

deleteButton.addEventListener('click', async (e) => {
    const deleteButton = e.target.closest('.delete-project');
    if (!deleteButton) return;

    const projectId = deleteButton.dataset.projectId;

    let project;

    // 🔎 Fetch project info (for name)
    try {
        const { data } = await axios.get(`/project/${projectId}/edit`);
        project = data;
    } catch (error) {
        console.error(error);

        await Swal.fire({
            icon: 'error',
            title: 'Unable to load project details'
        });
        return;
    }

    // ⚠️ Confirmation
    const result = await Swal.fire({
        title: `Remove project "${project.name}"?`,
        text: "This project will be permanently removed.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    });

    if (!result.isConfirmed) return;

    // 🗑️ Delete request
    try {
        const response = await axios.delete(`/project/${projectId}`);

        if (response.data?.success) {
            await Swal.fire({
                icon: 'success',
                title: response.data.message
            });

            // 🔄 Notify table / UI
            window.location.href = '/project';
        } else {
            throw new Error('Delete failed');
        }

    } catch (error) {
        console.error(error);

        await Swal.fire({
            icon: 'error',
            title: 'Failed to delete project'
        });
    }
});
