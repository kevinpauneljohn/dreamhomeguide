import {formatPeso} from "@/component/floatingTools/formatPeso.js";
import {plural} from "@/component/floatingTools/plural.js";

export const initHauslandInHouseCalculator = () => {

    const total_contract_price = parseFloat(document.getElementById('total_contract_price').value);
    const processing_fee = parseFloat(document.getElementById('processing_fee').value);
    const reservation_fee = parseFloat(document.getElementById('reservation_fee').value);

    const pf_less_rf = processing_fee - reservation_fee;
    const pf_months = parseInt(document.getElementById('pf_months').value);
    const pf_less_rf_monthly = pf_less_rf / pf_months;

    const equity_percentage_element = document.getElementById('equity_percentage');
    const equity_percentage = parseFloat(equity_percentage_element.value);

    const equity_exact_amount_element = document.getElementById('equity_exact_amount');
    const equity_exact_amount = parseFloat(equity_exact_amount_element.value);
    const equity_months = parseFloat(document.getElementById('equity_months').value);
    const monthly_equity = equity_exact_amount / equity_months;

    const combined_monthly_pf_and_equity = monthly_equity + pf_less_rf_monthly;

    const loanable_amount = total_contract_price - equity_exact_amount;

    const years = parseInt(document.getElementById('years').value);

    document.getElementById('total_contract_price_result').innerText =
        formatPeso(total_contract_price);

    document.getElementById('processing_fee_result').innerText =
        formatPeso(processing_fee);

    document.getElementById('reservation_fee_result').innerText =
        formatPeso(reservation_fee);

    document.getElementById('pf_less_rf').innerText =
        formatPeso(pf_less_rf);

    document.getElementById('pf_less_rf_monthly').innerText =
        formatPeso(pf_less_rf_monthly);

    document.getElementById('equity_result').innerText =
        formatPeso(equity_exact_amount);

    document.getElementById('monthly_equity_result').innerText =
        `(${equity_months} ${plural(equity_months, 'month','months')})`;

    document.getElementById('monthly_equity_payment_result').innerText =
        formatPeso(monthly_equity);

    document.getElementById('combined_monthly').innerText =
        `(${equity_months} ${plural(equity_months, 'month','months')})`;

    document.getElementById('combined_monthly_result').innerText =
        formatPeso(combined_monthly_pf_and_equity);

    document.getElementById('calc-result').classList.remove('d-none');

    amortization(loanable_amount, years);
}

const amortization = (balance, years) => {
    let result, balance2, balance3 = '';

    if(years === 5)
    {
        balance = balance * 0.022244448;
        result = `<li class="list-group-item d-flex justify-content-between">
                        <span>1-5 yrs (12%)</span>
                        <strong>${formatPeso(balance)}</strong>
                    </li>
                `;
    }else if(years === 10)
    {
        balance = balance * 0.014347095;
        balance2 = (balance*0.0460251)+balance;

        result = `<li class="list-group-item d-flex justify-content-between">
                        <span>1-5 yrs (12%)</span>
                        <strong>${formatPeso(balance)}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>6-10 yrs (14%)</span>
                        <strong>${formatPeso(balance2)}</strong>
                    </li>
                `;
    }else if(years === 15)
    {
        balance = balance * 0.012001681;
        balance2 = (balance*0.0822151)+balance;
        balance3 = (balance2*0.0451175)+balance2;

        result = `<li class="list-group-item d-flex justify-content-between">
                        <span>1-5 yrs (12%)</span>
                        <strong>${formatPeso(balance)}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>6-10 yrs (14%)</span>
                        <strong>${formatPeso(balance2)}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>11-15 yrs (16%)</span>
                        <strong>${formatPeso(balance3)}</strong>
                    </li>
                `;
    }

    // document.getElementById('amortization').innerHTML = result;
    document.getElementById('hausland-inhouse-result-list').insertAdjacentHTML('beforeend', result);

}

window.setEquityExactAMount = () => {
    const total_contract_price = parseFloat(document.getElementById('total_contract_price').value);
    const equity_percentage = parseFloat(document.getElementById('equity_percentage').value);

    const equity_exact_amount_element = document.getElementById('equity_exact_amount');
    equity_exact_amount_element.value = total_contract_price * (equity_percentage / 100);
}

window.setEquityPercentage = () => {
    const total_contract_price = parseFloat(document.getElementById('total_contract_price').value);
    const equity_exact_amount = parseFloat(document.getElementById('equity_exact_amount').value);

    const equity_percentage_element = document.getElementById('equity_percentage');
    equity_percentage_element.value = equity_exact_amount / total_contract_price * 100;
}

window.setLoanableAmount = () => {
    const loanable_amount_element = document.getElementById('loanable_amount');
    const total_contract_price = parseFloat(document.getElementById('total_contract_price').value);
    const equity_exact_amount = parseFloat(document.getElementById('equity_exact_amount').value);

    loanable_amount_element.value = total_contract_price - equity_exact_amount;
}


