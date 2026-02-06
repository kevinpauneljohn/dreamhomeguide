import Swal from "sweetalert2";
import axios from "axios";
import {getCommissionDetails} from "@/dashboard/commissions/mode.js";

export const deleteCommission = async (commissionId) => {

    try {
        const response = await getCommissionDetails(commissionId);
        console.log(response);

        Swal.fire({
            title: 'Delete Commission Rate?',
            html: `
            <div class="text-start">
                <p class="mb-2"><strong>Project:</strong> ${response.data.project_name}</p>
                <p class="mb-2"><strong>Rate:</strong> ${response.data.rate}%</p>
                <hr>
                <p class="text-danger mb-0">
                    This action cannot be undone.
                </p>
            </div>
        `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (!result.isConfirmed) return;

            axios.delete(`/commission/${response.data.id}`)
                .then(response => {

                    if (response.data?.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: response.data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {

                            // 🔥 reload AFTER user clicks OK
                            $('#commission-table').DataTable().ajax.reload(null, false);

                        });
                    }

                })
                .catch(error => {
                    console.error(error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Delete Failed',
                        text: error.response?.data?.message ?? 'Something went wrong.'
                    });
                });
        });



    } catch (error) {
        console.error('Failed to load commission', error);
    }

}

window.deleteCommission = deleteCommission;
