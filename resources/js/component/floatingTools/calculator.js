import {initApecHomesPagIbigCalculator} from "./apec-homes-pagibig-calculator.js";
import {initApecHomesInHouseCalculator} from "./apec-homes-inhouse-calculator.js";
import {formatPeso} from "@/component/floatingTools/formatPeso.js";
import {plural} from "@/component/floatingTools/plural.js";

const selectCalculator = document.getElementById('calculator-type');
let calculatorType = '';

function openCalculatorModal() {
    const modal = new bootstrap.Modal(
        document.getElementById('calculatorModal')
    );
    modal.show();
}

document.getElementById('calculateBtn').addEventListener('click', (e) => {
    e.preventDefault();

    initializeCalculator(calculatorType);
});



selectCalculator.addEventListener('change', (e) => {
    // console.log(e.target.value);
    calculatorType = e.target.value;
    if(calculatorType !== '')
    {
        loadCalculator(e.target.value);
    }
    else{
        document.getElementById('calculator-content').innerHTML = `
        <div class="text-center py-5">
            <i class="fa fa-calculator fa-3x text-primary mb-3"></i>
            <h5 class="fw-semibold">Choose a Calculator</h5>
            <p class="text-muted">
                Select a calculator type to estimate monthly amortization,
                down payment, or commission.
            </p>
        </div>
    `;
    }

})


function loadCalculator(type) {
    const container = document.getElementById('calculator-content');

    container.innerHTML = `
        <div class="d-flex flex-column align-items-center justify-content-center py-5">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="text-muted">Loading calculator...</span>
        </div>
    `;

    fetch(`/tools/calculator/${type}`)
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
        })
        .catch(() => {
            container.innerHTML = `
                <div class="alert alert-danger text-center">
                    Failed to load calculator. Please try again.
                </div>
            `;
        });
}


function initializeCalculator(type) {
    switch (type) {
        case 'mortgage':
            initMortgageCalculator();
            break;
        case 'apecpagibig':
            initApecHomesPagIbigCalculator();
            break;
        case 'apecinhouse':
            initApecHomesInHouseCalculator();
            break;
    }
}

const initMortgageCalculator = () => {
    const price = parseFloat(document.getElementById('price').value);
    const dpPercent = parseFloat(document.getElementById('dpPercent').value);
    const years = parseInt(document.getElementById('years').value);
    const interest = parseFloat(document.getElementById('interest').value);

    if (isNaN(price) ||
        isNaN(dpPercent) ||
        isNaN(years) ||
        isNaN(interest)) return;

    const downpayment = price * (dpPercent / 100);
    const loan = price - downpayment;

    const monthlyRate = (interest / 100) / 12;
    const months = years * 12;


    const monthly =
        (loan * monthlyRate) /
        (1 - Math.pow(1 + monthlyRate, -months));

    let requiredIncome = (monthly / 30) * 100 ;

    console.log(loan);
    document.getElementById('propertyPrice').innerText =
        formatPeso(price);

    document.getElementById('dpPercentValue').innerText = dpPercent + '%';

    document.getElementById('dpAmount').innerText =
        formatPeso(downpayment);

    document.getElementById('loanAmount').innerText =
        formatPeso(loan);

    document.getElementById('terms').innerText = `Estimated Monthly Amortization for the Selected Loan Term at a ${interest}% Annual Interest Rate \n (${years} ${plural(years, 'year','years')})`
    document.getElementById('monthly').innerText = ` ${formatPeso(monthly)}`;

    document.getElementById('monthlyIncome').innerText =
        formatPeso(requiredIncome);

    document.getElementById('calc-result').classList.remove('d-none');
}



export {openCalculatorModal};
