import {setMode} from "@/dashboard/projects/mode.js";
import {enableForm, disableForm, resetLoading, setLoading} from "@/dashboard/modelUnits/button-loader.js";
import {reloadComputationTable} from "@/dashboard/computations/computations-table.js";
import {Toast} from "@/toast.js";
import axios from "axios";

const computationModal = document.getElementById('computationModal');
const computationForm = document.getElementById('computationForm');
const saveComputationBtn = document.getElementById('saveComputationBtn');


const modal = bootstrap.Modal.getOrCreateInstance(computationModal);
let computationId = null;

const setComputationId = (id) => computationId = id;
const getComputationId = () => computationId;

$(function(){
    document.addEventListener('click', (e) => {
        const editComputationBtn = e.target.closest('.edit-computation');

        if (!editComputationBtn) return;

        setComputationId(editComputationBtn.dataset.computationId)
        setMode('edit computation');

        // Remove validation styles
        computationForm.querySelectorAll('.is-invalid, .is-valid')
            .forEach(el => el.classList.remove('is-invalid', 'is-valid'));

        // Remove validation messages
        computationForm.querySelectorAll('.invalid-feedback, .valid-feedback')
            .forEach(el => el.remove());

        disableForm(computationForm);
        getComputation(getComputationId()).then(data => {
            Object.keys(data).forEach(key => {
                const field = $(`[name="${key}"]`);
                if (!field) return;

                if(key === 'model_unit_id')
                {
                    axios.get(`/get-project-units/${data.project_id}`,{
                        params: {
                            model_id: data.model_unit_id
                        }
                    })
                        .then(response => {
                            const $model = $('select[name="model_unit_id"]');
                            $model.html(response.data).trigger('change');
                        })
                        .catch(error => console.log(error));
                }

                field.val(data[key]).change();
            })
        }).finally(() => enableForm(computationForm));

        computationModal.querySelector('.modal-title').textContent = 'Edit Computation';
        modal.show();
    })
});

const getComputation = async (id) => {
    const response = await axios.get(`/computations/${id}/edit`);
    return response.data;
}

const updateComputation = (formData, id) => {

    // Clear previous validation UI
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    setLoading(saveComputationBtn);
    formData.append('_method', 'PUT');
    axios.post(`/computations/${id}`, formData)
        .then(response => {
            console.log(response);

            if (response.data?.success) {

                Toast.fire({
                    icon: 'success',
                    title: response.data.message || 'Saved successfully'
                });

                // ✅ SAFE reload (no recursion, no re-init)
                reloadComputationTable();
            }
            else {
                Toast.fire({
                    icon: 'error',
                    title: response.data.message || 'Something went wrong'
                });
            }
        })
        .catch(error => {

            // 🔴 VALIDATION ERRORS (422)
            if (error.response?.status === 422) {
                const errors = error.response.data.errors;

                Toast.fire({
                    icon: 'error',
                    title: 'Please fix the highlighted fields'
                });

                Object.keys(errors).forEach(key => {

                    const $field = $(`[name="${key}"]`);
                    if (!$field.length) return;

                    // Normal input / textarea
                    if (!$field.hasClass('select2-hidden-accessible')) {
                        $field.addClass('is-invalid');
                        $field.after(`<div class="invalid-feedback">${errors[key][0]}</div>`);
                        return;
                    }

                    // Select2 field
                    const $select2 = $field.next('.select2-container')
                        .find('.select2-selection');

                    $select2.addClass('is-invalid');

                    $field.closest('.col-md-6, .col-md-4, .col-md-12')
                        .append(`<div class="invalid-feedback d-block">${errors[key][0]}</div>`);
                });

                return;
            }

            // 🔴 SERVER ERROR (500 / others)
            Toast.fire({
                icon: 'error',
                title: 'Server error. Please try again.'
            });

            console.error(error);
        }).finally(() => resetLoading(saveComputationBtn));
}

export {updateComputation, setComputationId, getComputationId};


