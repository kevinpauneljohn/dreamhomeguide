import axios from "axios";

const viewModalEl = document.getElementById('viewComputationModal');
const viewModal = new bootstrap.Modal(viewModalEl);

// 🔍 View computation
document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.view-computation');
    if (!btn) return;

    const computationId = btn.dataset.computationId;

    try {
        const { data } = await axios.get(`/computations/${computationId}`);

        // Title + subtitle
        document.getElementById('viewTitle').innerText =
            `${data.project_name} — ${data.model_unit_name}`;

        document.getElementById('viewSubtitle').innerText =
            `${data.financing_label} Financing • Updated ${data.updated_at}`;

        // // Meta
        // document.getElementById('viewProject').innerText =
        //     data.project_name ?? '—';
        //
        // document.getElementById('viewModelUnit').innerText =
        //     data.model_unit_name ?? '—';

        // // Monthly amortization
        // document.getElementById('viewMA').innerText =
        //     data.monthly_amortization
        //         ? `₱${Number(data.monthly_amortization).toLocaleString()} / month`
        //         : '—';

        // Computation text
        // document.getElementById('viewComputationText').value =
        //     data.computation ?? '';

        document.getElementById('viewComputationText').value =
            formatComputationText(data);


        viewModal.show();

    } catch (error) {
        console.error(error);
        alert('Failed to load computation.');
    }
});

const formatComputationText = (data) => {
    console.log(data);
    return `
**** Sample Computation Only ****
PROJECT: ${data.project_name}
MODEL UNIT: ${data.model_unit_name}
UNIT LOCATION: ${data.type ? data.type.toUpperCase() + ' UNIT' : '—'}

FINANCING: ${data.financing_label}
PROPERTY LOCATION:
${data.location ?? '—'}

LOT AREA: ${data.lot_area ?? '—'}
${data.floor_area ? `FLOOR AREA: ${data.floor_area}` : ''}
--------------------------------------
${data.computation}
--------------------------------------

✔ Prices and computation are subject to change without prior notice.
✔ Final approval is subject to financing evaluation.
✔ Processing fees and other charges may apply.
`.trim();
};


// 📋 Copy computation
document.getElementById('btnCopyComputation')
    .addEventListener('click', async () => {

        const textarea = document.getElementById('viewComputationText');
        await navigator.clipboard.writeText(textarea.value);

        const btn = document.getElementById('btnCopyComputation');
        const original = btn.innerHTML;

        btn.innerHTML = `<i class="fa fa-check me-1"></i> Copied`;
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');

        setTimeout(() => {
            btn.innerHTML = original;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 1500);
    });
