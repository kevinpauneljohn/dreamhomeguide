import {formatPeso} from "@/component/floatingTools/formatPeso.js";
import {plural} from "@/component/floatingTools/plural.js";

const initApecHomesPagIbigCalculator = () => {

    const total_contract_price = parseFloat(document.getElementById('total_contract_price').value);
    const discount = parseInt(document.getElementById('discount').value);
    const reservation_fee = parseInt(document.getElementById('reservation_fee').value);
    const gross_equity = parseFloat(document.getElementById('gross_equity').value);
    const months_to_pay = parseInt(document.getElementById('months').value);
    const years = parseInt(document.getElementById('years').value);
    const interest_rate = parseFloat(document.getElementById('interest_rate').value);

    const discountedTcp = total_contract_price - discount;
    const monthly_equity = gross_equity / months_to_pay;
    const loanable_amount = (discountedTcp - reservation_fee) - gross_equity;

    const monthlyRate = (interest_rate / 100) / 12;
    const months = years * 12;


    const monthly_amortization =
        (loanable_amount * monthlyRate) /
        (1 - Math.pow(1 + monthlyRate, -months));

    let requiredIncome = (monthly_amortization / 35) * 100 ;


    document.getElementById('property_total_contract_price').innerText =
        formatPeso(total_contract_price);

    document.getElementById('propertyDiscount').innerText =
        formatPeso(discount);

    document.getElementById('discountedTcp').innerText =
        formatPeso(discountedTcp);

    document.getElementById('property_reservation_fee').innerText =
        formatPeso(reservation_fee);

    document.getElementById('property_gross_equity').innerText =
        formatPeso(gross_equity);

    document.getElementById('equity_months_to_pay').innerText = `${months_to_pay} ${plural(months_to_pay, 'month','months')}`;
    document.getElementById('monthly_equity').innerText = formatPeso(monthly_equity);
    document.getElementById('loanable_amount').innerText = formatPeso(loanable_amount);

    document.getElementById('terms').innerText = `Estimated Monthly Amortization for the Selected Loan Term at a ${interest_rate}% Annual Interest Rate \n (${years} ${plural(years, 'year','years')})`

    document.getElementById('hdmf_monthly_amortization').innerText =
        formatPeso(monthly_amortization);

    document.getElementById('required_monthly_income').innerText =
        formatPeso(requiredIncome);

    document.getElementById('calc-result').classList.remove('d-none');
}

window.downloadApecHomesPagIbigPDF = async () => {
    const element = document.querySelector('.apec-homes-pagibig-computation');
    if (!element) return;

    // ✅ Lazy-load only when needed
    const { default: html2pdf } = await import('html2pdf.js');

    const options = {
        margin: 0.5,
        filename: 'Apec-homes-pag-ibig-Computation.pdf',
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

    await html2pdf().set(options).from(element).save();
}

export {initApecHomesPagIbigCalculator}
