import axios from "axios";
import Swal from "sweetalert2";
import {reloadComputationTable} from "@/dashboard/computations/computations-table.js";

let deleteListenerBound = false;

export const removeComputation = () => {
    if (deleteListenerBound) return; // ✅ prevent duplicates
    deleteListenerBound = true;

    document.addEventListener('click', async (e) => {
        const deleteButton = e.target.closest('.delete-computation');
        if (!deleteButton) return;

        const computationId = deleteButton.dataset.computationId;

        let computation;

        try {
            const { data } = await axios.get(`/get-computations-prompt/${computationId}`);
            computation = data;
            console.log(computation);
        } catch {
            await Swal.fire({
                icon: 'error',
                title: 'Unable to load model unit details'
            });
            return;
        }

        const result = await Swal.fire({
            title: `Remove Computation?`,
            html: `
                <div class="text-start">
                    <p class="mb-2">
                        You are about to permanently delete the computation for:
                    </p>

                    <div class="p-3 rounded bg-light border mb-2">
                        <div class="fw-semibold text-dark">
                            ${computation.data.project_name}
                        </div>
                        <div class="text-muted small">
                            Model Unit: ${computation.data.model_unit_name} - (${computation.data.type})
                        </div>
                        <div class="mt-1">
                            <span class="badge bg-secondary text-uppercase">
                                ${computation.data.financing}
                            </span>
                        </div>
                    </div>

                    <p class="text-danger small mb-0">
                        This action cannot be undone.
                    </p>
                </div>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, remove it",
            cancelButtonText: "Cancel",
            focusCancel: true
        });


        if (!result.isConfirmed) return;

        try {
            const response = await axios.delete(`/computations/${computationId}`);

            if (response.data?.success) {
                await Swal.fire({
                    icon: 'success',
                    title: response.data.message
                });

                reloadComputationTable();
            }
        } catch {
            await Swal.fire({
                icon: 'error',
                title: 'Failed to delete model unit'
            });
        }
    });
};
