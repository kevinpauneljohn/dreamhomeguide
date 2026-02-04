import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import {changeUnits} from "@/dashboard/sales/changeUnit.js";
import {Toast} from "@/toast.js";

$(document).ready(function () {
    const project_id = $('#project_id').val();
    let model_id = $('input[name=model_id]').val();
    changeUnits(project_id, model_id);

    $(document).on('change', '#project_id', function () {
        const project_id = $(this).val();
        changeUnits(project_id, model_id);
    });

})

document.addEventListener('DOMContentLoaded', function () {
    const editSalesForm = document.getElementById('edit-sales-form');
    const alertEl = document.querySelector('.alert');
    const saveSalesBtn = document.getElementById('save-sales-btn');

    if (!editSalesForm) return;

    editSalesForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(editSalesForm);
        formData.append('_method', 'PUT');

        editSalesForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
        editSalesForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());
        setLoading(saveSalesBtn);

        axios.post(`/sales/${editSalesForm.dataset.sales}`, formData)
            .then(response => {
                console.log(response.data);
                if(response.data.success === true)
                {
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    })
                    alertEl.classList.remove('d-none');
                    alertEl.innerHTML = `View Sales Details <a href="/sales/${response.data.sales}">here</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
                }
                else{
                    Toast.fire({
                        icon: 'warning',
                        title: response.data.message
                    })
                }
            }).catch(error => {
            const errors = error.response.data.errors;
            console.log(errors);

            Object.keys(errors).forEach(key => {
                const field = editSalesForm.querySelector(`[name="${key}"]`);
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
        }).finally(() => {
            resetLoading(saveSalesBtn);
        })
    });
});

