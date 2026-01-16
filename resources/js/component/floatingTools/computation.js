import axios from "axios";
import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
select2()
const computationModal = document.getElementById('computationToolModal');
const modal = bootstrap.Modal.getOrCreateInstance(computationModal);
const computationForm = document.getElementById('computationToolForm');
const computationResultWrapper = document.getElementById('computationResultWrapper');

const project = $('#computationToolModal #project');
let project_id;

$(function(){
    $('#computationToolModal #project').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Project',
        allowClear: true,
        dropdownParent: $("#computationToolModal")
    });

    $('#computationToolModal #model_unit').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Model Unit',
        allowClear: true,
        dropdownParent: $('#computationToolModal')
    });
});

project.on('change', function (e) {
    const selected = $(this).val(); // select2-safe

    // ✅ Stop if cleared / empty
    if (!selected) {
        project_id = null;
        // clear model units safely
        $('#computationToolModal #model_unit').empty().append('<option></option>').trigger('change');
        return;
    }

    project_id = selected;

    axios.get(`/get-project-units/${project_id}`)
        .then(response => {
            console.log(response);
            // response.data should be array of units OR html options
            const $model = $('#computationToolModal #model_unit');

            // ✅ If your endpoint returns HTML <option>...</option>
            $model.html(response.data).trigger('change');

            // If your endpoint returns JSON array instead, use the JSON version below (Fix 2B)
        })
        .catch(error => console.log(error));
});
const openComputationModal = () => {
    modal.show();
}

computationForm.addEventListener('submit', (e) => {
    e.preventDefault();


    const formData = new FormData(computationForm);

    axios.post('/tools/get-computation-result', formData)
        .then((response) => {
            computationResultWrapper.classList.remove('d-none');
            computationResultWrapper.innerHTML = response.data;
        })
        .catch(error => {
            console.error(error.response?.data || error);
        });
});

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.copy-computation');
    if (!btn) return;

    navigator.clipboard.writeText(btn.dataset.text);

    const original = btn.textContent;
    btn.textContent = 'Copied';
    btn.classList.add('btn-success');

    setTimeout(() => {
        btn.textContent = original;
        btn.classList.remove('btn-success');
    }, 1500);
});






export {openComputationModal};
