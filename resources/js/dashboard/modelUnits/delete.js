import axios from "axios";
import Swal from "sweetalert2";

let deleteListenerBound = false;

const removeModelUnit = () => {
    if (deleteListenerBound) return; // ✅ prevent duplicates
    deleteListenerBound = true;

    document.addEventListener('click', async (e) => {
        const deleteButton = e.target.closest('.delete-model-unit');
        if (!deleteButton) return;

        const modelUnitId = deleteButton.dataset.modelUnitId;

        let modelUnit;

        try {
            const { data } = await axios.get(`/model-units/${modelUnitId}/edit`);
            modelUnit = data;
            console.log(modelUnit);
        } catch {
            await Swal.fire({
                icon: 'error',
                title: 'Unable to load model unit details'
            });
            return;
        }

        const result = await Swal.fire({
            title: `Remove model unit "${modelUnit.name}"?`,
            text: "This model unit will be permanently removed.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        });

        if (!result.isConfirmed) return;

        try {
            const response = await axios.delete(`/model-units/${modelUnitId}`);

            if (response.data?.success) {
                await Swal.fire({
                    icon: 'success',
                    title: response.data.message
                });

                document.dispatchEvent(new CustomEvent('reload:table'));
            }
        } catch {
            await Swal.fire({
                icon: 'error',
                title: 'Failed to delete model unit'
            });
        }
    });
};

export { removeModelUnit };
