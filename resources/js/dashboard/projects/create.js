import {slugify} from "@/dashboard/Slugify.js";
import axios from "axios";
import {resetProjectForm} from "@/dashboard/projects/submitProject.js";
import {getMode, setMode} from "@/dashboard/projects/mode.js";

const addProjectBtn = document.getElementById('add-project-btn');
const projectModal = document.getElementById('projectModal');


const name = document.querySelector('input[name=name]');
const slug = document.querySelector('input[name=slug]');

document.addEventListener('DOMContentLoaded', () => {

    if (addProjectBtn && projectModal) {
        addProjectBtn.addEventListener('click', () => {
            projectModal.querySelector('.modal-title').textContent = 'Add Project';
            setMode('create');
            resetProjectForm();
            console.log(getMode());
        });
    }

    if (name && slug) {
        generateSlug();
    }
})

const generateSlug = () => {
    document.addEventListener('keyup', () => {
        slug.value = slugify(name.value);
    })
}

const createProject = async (formData) => {
    const response = await axios.post('/project', formData);
    return response.data;
}

export {name, slug, generateSlug, createProject}
