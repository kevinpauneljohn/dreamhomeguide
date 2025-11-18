import Chart from 'chart.js/auto';

// Property activity line chart
const ctx1 = document.getElementById('propertyChart');
if (ctx1) {
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Views',
                data: [12, 19, 14, 25, 32, 28, 40],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.2)',
                tension: 0.4,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
}

// Property type donut chart
const ctx2 = document.getElementById('listingTypeChart');
if (ctx2) {
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['For Sale', 'For Rent', 'Pre-Selling'],
            datasets: [{
                data: [10, 5, 3],
                backgroundColor: ['#0d6efd', '#20c997', '#ffc107']
            }]
        }
    });
}
