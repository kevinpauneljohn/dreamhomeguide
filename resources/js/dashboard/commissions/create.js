import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
select2()
import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import {setMode, getMode} from "@/dashboard/commissions/mode.js";
import {Toast} from "@/toast.js";
import {updateCommission} from "@/dashboard/commissions/edit.js";

$(function(){
    const projectSelect = $('select[name=project_id]');
    projectSelect.select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Project',
        allowClear: true,
        dropdownParent: $("#commission-modal")
    });

    projectSelect.val(null).trigger('change');
});

document.addEventListener('DOMContentLoaded', () => {

    const commissionModalEl = document.getElementById('commission-modal');
    const commissionForm = document.getElementById('commission-form');
    const userId = commissionForm.dataset.userId;
    const addCommissionBtn = document.getElementById('add-commission-btn');
    const saveCommissionBtn = document.getElementById('save-commission-btn');



    if (!commissionModalEl || !addCommissionBtn) return;

    const commissionModal =
        bootstrap.Modal.getOrCreateInstance(commissionModalEl);

    addCommissionBtn.addEventListener('click', () => {
        $('select[name=project_id]').val(null).trigger('change');
        commissionForm.reset();

        commissionModalEl.querySelector('.modal-title').textContent = 'Add Commission';
        commissionModal.show();

        const idInput = commissionForm.querySelector('input[name="id"]');
        if (idInput) idInput.remove();
    });

    commissionForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(commissionForm);
        formData.append('user_id', userId);

        commissionForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
        commissionForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());
        setLoading(saveCommissionBtn);

        if(getMode() === 'create')
        {
            createCommission(formData);
        }
        else if(getMode() === 'edit'){

            formData.append('_method', 'PUT');

            updateCommission(formData)
                .then(response => {
                    if (response.data.success) {


                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });


                        // reload datatable
                        $('#commission-table').DataTable().ajax.reload(null, false);
                    }else{
                        Toast.fire({
                            icon: 'warning',
                            title: response.data.message
                        });
                    }

                })
                .catch(error => {

                    const errors = error.response?.data?.errors ?? {};

                    Object.keys(errors).forEach(key => {
                        const field = commissionForm.querySelector(`[name="${key}"]`);
                        if (!field) return;

                        field.classList.add('is-invalid');

                        if ($(field).hasClass('select2-hidden-accessible')) {
                            $(field).next('.select2-container')
                                .addClass('is-invalid')
                                .after(`<div class="invalid-feedback d-block">${errors[key][0]}</div>`);
                        } else {
                            field.insertAdjacentHTML(
                                'afterend',
                                `<div class="invalid-feedback">${errors[key][0]}</div>`
                            );
                        }
                    });

                })
                .finally(() => resetLoading(saveCommissionBtn));
        }

    })

    const createCommission = (formData) => {
        axios.post('/commission', formData).then(response => {
            if (response.data.success) {
                $('select[name=project_id]').val(null).trigger('change');
                commissionForm.reset();
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                });
                $('#commission-table').DataTable().ajax.reload(null, false);
            }
        }).catch(error => {
            const errors = error.response.data.errors;

            Object.keys(errors).forEach(key => {
                const field = commissionForm.querySelector(`[name="${key}"]`);
                if (!field) return;

                // Mark invalid
                field.classList.add('is-invalid');

                // 🔹 If Select2
                if ($(field).hasClass('select2-hidden-accessible')) {
                    const select2Container = $(field).next('.select2-container');

                    select2Container
                        .addClass('is-invalid')
                        .after(`<div class="invalid-feedback d-block">${errors[key][0]}</div>`);
                } else {
                    // Normal input
                    field.insertAdjacentHTML(
                        'afterend',
                        `<div class="invalid-feedback">${errors[key][0]}</div>`
                    );
                }
            });
        }).finally(() => resetLoading(saveCommissionBtn));
    }
});

