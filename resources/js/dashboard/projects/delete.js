import Swal from "sweetalert2";
import {editButton, getProjectId} from "@/dashboard/projects/edit.js";
import axios from "axios";


const removeProject = () => {
    document.addEventListener('click', async (e) => {
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
                document.dispatchEvent(
                    new CustomEvent('project:deleted', {
                        detail: { projectId }
                    })
                );
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
};

export { removeProject };

