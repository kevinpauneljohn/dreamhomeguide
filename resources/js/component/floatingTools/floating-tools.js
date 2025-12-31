import {openCalculatorModal} from "./calculator.js";

const tab = document.getElementById('tool-tab');
const drawer = document.getElementById('tool-drawer');
const closeBtn = document.getElementById('close-drawer');

tab.addEventListener('click', () => {
    drawer.classList.add('active');
});

closeBtn.addEventListener('click', () => {
    drawer.classList.remove('active');
});

// Optional: click outside to close
document.addEventListener('click', (e) => {
    if (!drawer.contains(e.target) && !tab.contains(e.target)) {
        drawer.classList.remove('active');
    }
});
document.querySelectorAll('.tool-app').forEach(tool => {
    tool.addEventListener('click', () => {
        const type = tool.dataset.tool;

        // console.log(type);

        switch (type) {
            case 'calculator':
                openCalculatorModal();
                break;
            case 'computations':
                openComputationModal();
                break;
            case 'requirements':
                openRequirementsModal();
                break;
            case 'commission':
                openCommissionModal();
                break;
            case 'pagibig':
                openPagibigGuide();
                break;
            case 'bank':
                openBankLoanGuide();
                break;
        }
    });
});



