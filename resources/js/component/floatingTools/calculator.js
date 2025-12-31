const selectCalculator = document.getElementById('calculator-type');


function openCalculatorModal() {
    const modal = new bootstrap.Modal(
        document.getElementById('calculatorModal')
    );
    modal.show();
}

document.getElementById('calculateBtn').addEventListener('click', (e) => {
    e.preventDefault();

    const price = parseFloat(document.getElementById('price').value);
    const dpPercent = parseFloat(document.getElementById('dpPercent').value);
    const years = parseInt(document.getElementById('years').value);
    const interest = parseFloat(document.getElementById('interest').value);

    if (!price || !dpPercent || !years || !interest) return;

    const downpayment = price * (dpPercent / 100);
    const loan = price - downpayment;

    const monthlyRate = (interest / 100) / 12;
    const months = years * 12;

    const monthly =
        (loan * monthlyRate) /
        (1 - Math.pow(1 + monthlyRate, -months));

    document.getElementById('dpAmount').innerText =
        formatPeso(downpayment);

    document.getElementById('loanAmount').innerText =
        formatPeso(loan);

    document.getElementById('monthly').innerText =
        formatPeso(monthly);

    document.getElementById('calc-result').classList.remove('d-none');
});

/* Peso Formatter */
function formatPeso(amount) {
    return '₱' + amount.toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

selectCalculator.addEventListener('change', (e) => {
    // console.log(e.target.value);
    loadCalculator(e.target.value);
})
function loadCalculator(type) {
    fetch(`/tools/calculator/${type}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('calculator-content').innerHTML = html;
            // initializeCalculator(type);
        });
}

// function initializeCalculator(type) {
//     switch (type) {
//         case 'property':
//             initPropertyCalculator();
//             break;
//         case 'commission':
//             initCommissionCalculator();
//             break;
//         case 'pagibig':
//             initPagibigCalculator();
//             break;
//     }
// }


export {openCalculatorModal};
