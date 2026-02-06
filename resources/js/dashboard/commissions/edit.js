import {setMode, getCommissionDetails} from "@/dashboard/commissions/mode.js";

const commissionModalEl = document.getElementById('commission-modal');
const commissionForm = document.getElementById('commission-form');
const userId = commissionForm.dataset.userId;
const saveCommissionBtn = document.getElementById('save-commission-btn');

const commissionModal =
    bootstrap.Modal.getOrCreateInstance(commissionModalEl);
const editCommission = async (commissionId) => {
    setMode('edit');

    commissionForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
    commissionForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

    commissionModalEl.querySelector('.modal-title').textContent = 'Edit Commission';
    commissionModal.show()


    let idInput = commissionForm.querySelector('input[name="id"]');

    if (!idInput) {
        idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        commissionForm.appendChild(idInput);
    }

    idInput.value = commissionId;

    try {
        const response = await getCommissionDetails(commissionId);

        $('#commission-form select[name=project_id]').val(response.data.project_id).trigger('change');
        $('#commission-form select[name=rate]').val(response.data.rate).trigger('change');



    } catch (error) {
        console.error('Failed to load commission', error);
    }
}

const updateCommission = async (formData) => {
    const id = formData.get('id');

    return axios.post(`/commission/${id}`, formData);
};



window.editCommission = editCommission;

export {editCommission, updateCommission};
