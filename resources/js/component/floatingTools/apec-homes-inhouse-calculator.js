import html2pdf from "html2pdf.js";
import {formatPeso} from "@/component/floatingTools/formatPeso.js";
import {plural} from "@/component/floatingTools/plural.js";

export const initApecHomesInHouseCalculator = () => {
    const total_contract_price = parseFloat(document.getElementById('total_contract_price').value);
    const discount = parseInt(document.getElementById('discount').value);
    const reservation_fee = parseInt(document.getElementById('reservation_fee').value);
    const equity_percentage = parseFloat(document.getElementById('equity_percentage').value);
    const months_to_pay = parseInt(document.getElementById('months').value);

    const discountedTcp = total_contract_price - discount;
    const net_equity_payment = discountedTcp - reservation_fee;
    const percentage_of_equity_amount = net_equity_payment * (equity_percentage / 100);
    const monthly_equity = percentage_of_equity_amount / months_to_pay;

    const equity_percentage_balance = 100 - equity_percentage;
    const loanable_amount = net_equity_payment * (equity_percentage_balance / 100);

    const five_years_amortization = loanable_amount * 0.022244;
    const ten_years_amortization = loanable_amount * 0.017380;

    document.getElementById('property_total_contract_price').innerText =
        formatPeso(total_contract_price);

    document.getElementById('propertyDiscount').innerText =
        formatPeso(discount);

    document.getElementById('discountedTcp').innerText =
        formatPeso(discountedTcp);

    document.getElementById('property_reservation_fee').innerText =
        formatPeso(reservation_fee);

    document.getElementById('property_gross_equity').innerText =
        formatPeso(percentage_of_equity_amount);

    document.getElementById('equity_months_to_pay').innerText = `${months_to_pay} ${plural(months_to_pay, 'month','months')}`;
    document.getElementById('monthly_equity').innerText = formatPeso(monthly_equity);
    document.getElementById('loanable_amount').innerText = formatPeso(loanable_amount);

    document.getElementById('five_years_amortization').innerText = formatPeso(five_years_amortization);
    document.getElementById('ten_years_amortization').innerText = formatPeso(ten_years_amortization);



    document.getElementById('calc-result').classList.remove('d-none');
}

window.downloadApecHomesInHousePDF = () => {
    const element = document.querySelector('.apec-homes-in-house-computation');

    const options = {
        margin: 0.5,
        filename: 'Apec-homes-in-house-Computation.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: {
            scale: 2,          // sharp text
            useCORS: true
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        }
    };

    html2pdf().set(options).from(element).save();
}
