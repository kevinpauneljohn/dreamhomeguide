import select2 from 'select2';
import {Toast} from "@/toast.js";
import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import {reloadComputationTable} from "@/dashboard/computations/computations-table.js";
import {setMode} from "@/dashboard/projects/mode.js";
import {setComputationId} from "@/dashboard/computations/edit.js";
import axios from "axios";
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
select2()

const computationModal = document.getElementById('computationModal');
const addComputationBtn = document.getElementById('btnAddComputation');
const computationForm = document.getElementById('computationForm');
const saveComputationBtn = document.getElementById('saveComputationBtn');

const project = $('select[name=project_id]');
let project_id;

$(function(){
    $('select[name=project_id]').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Project',
        allowClear: true,
        dropdownParent: $("#computationModal")
    });

    $('select[name=model_unit_id]').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Model Unit',
        allowClear: true,
        dropdownParent: $('#computationModal')
    });
});

addComputationBtn.addEventListener('click', () => {
    setMode('create computation');
    setComputationId(null);
    computationModal.querySelector('.modal-title').textContent = 'Add New Computation';

    computationForm.reset();
    $('select[name=project_id]').val('').trigger('change');
    $('select[name=model_unit_id]').val('').trigger('change');

    const modal = bootstrap.Modal.getOrCreateInstance(computationModal);
    modal.show();
})

project.on('change', function (e) {
    const selected = $(this).val(); // select2-safe

    // ✅ Stop if cleared / empty
    if (!selected) {
        project_id = null;
        // clear model units safely
        $('select[name="model_unit_id"]').empty().append('<option></option>').trigger('change');
        return;
    }

    project_id = selected;

    axios.get(`/get-project-units/${project_id}`)
        .then(response => {
            // response.data should be array of units OR html options
            const $model = $('select[name="model_unit_id"]');

            // ✅ If your endpoint returns HTML <option>...</option>
            $model.html(response.data).trigger('change');

            // If your endpoint returns JSON array instead, use the JSON version below (Fix 2B)
        })
        .catch(error => console.log(error));
});


const saveComputation = (formData) => {

    // Ensure project_id is set
    formData.set('project_id', project_id);

    // Clear previous validation UI
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    setLoading(saveComputationBtn);

    axios.post('/computations', formData)
        .then(response => {

            if (response.data?.success) {

                Toast.fire({
                    icon: 'success',
                    title: response.data.message || 'Saved successfully'
                });

                // Reset form
                computationForm.reset();

                // Reset Select2 safely
                const $project = $('select[name="project_id"]');
                const $model = $('select[name="model_unit_id"]');

                $project.val(null).trigger('change.select2');
                $model.empty().append('<option></option>').val(null).trigger('change.select2');

                project_id = null;

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
};

export {saveComputation};
