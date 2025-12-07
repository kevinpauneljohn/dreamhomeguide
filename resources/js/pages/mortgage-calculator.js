function calculateMortgage() {
    let price = parseFloat(document.getElementById('mc-price').value);
    let dpPercent = parseFloat(document.getElementById('mc-downpayment').value);
    let interest = parseFloat(document.getElementById('mc-interest').value) / 100 / 12;
    let years = parseFloat(document.getElementById('mc-years').value);

    let downPayment = price * (dpPercent / 100);
    let loanAmount = price - downPayment;
    let months = years * 12;

    // Amortization formula
    let monthlyPayment = loanAmount * (interest * Math.pow(1 + interest, months))
        / (Math.pow(1 + interest, months) - 1);

    let totalInterest = (monthlyPayment * months) - loanAmount;

    // Output values
    document.getElementById('mc-loan').innerText = loanAmount.toLocaleString();
    document.getElementById('mc-monthly').innerText = Math.round(monthlyPayment).toLocaleString();
    document.getElementById('mc-interest-total').innerText = Math.round(totalInterest).toLocaleString();

    document.getElementById('mc-results').style.display = 'block';
}
function copyPropertyLink() {
    navigator.clipboard.writeText(window.location.href);
    alert("Property link copied!");
}
window.copyPropertyLink = copyPropertyLink;
window.calculateMortgage = calculateMortgage;
