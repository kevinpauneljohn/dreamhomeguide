import axios from "axios";

import {setLoading, resetLoading} from "@/dashboard/modelUnits/button-loader.js";
import {changeUnits} from "@/dashboard/sales/changeUnit.js";
import {Toast} from "@/toast.js";

$(function(){

    $(document).on('change', '#project_id', function () {
        const project_id = $(this).val();
        changeUnits(project_id);
    });

});


document.addEventListener('DOMContentLoaded', function () {
    const createSalesForm = document.getElementById('create-sales-form');
    if (!createSalesForm) return;

    const alertEl = document.querySelector('.alert');
    const saveSalesBtn = document.getElementById('save-sales-btn');

    createSalesForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(createSalesForm);

        createSale(formData);
    })

    const createSale = (formData) => {
        createSalesForm.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
        createSalesForm.querySelectorAll('.invalid-feedback').forEach((el) => el.remove());

        setLoading(saveSalesBtn);
        axios.post('/sales', formData)
            .then(response => {
            if(response.data.success === true)
            {
                createSalesForm.reset();

                $('#lead_id').val(null).trigger('change');
                $('#user_id').val(null).trigger('change');
                $('#project_id').val(null).trigger('change');
                $('select[name="model_unit_id"]').html(`<option value=""></option>`).trigger('change');


                alertEl.classList.remove('d-none');
                alertEl.innerHTML = `View Sales Details<a href="/sales/${response.data.sales}">here</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
            }else{
                Toast.fire({
                    icon: 'warning',
                    title: response.data.message
                })
            }
        }).catch(error => {
            const errors = error.response.data.errors;
            console.log(errors);

            Object.keys(errors).forEach(key => {
                const field = createSalesForm.querySelector(`[name="${key}"]`);
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
    }
})

