const enableStatusCompletionEl = document.querySelector('input[name="complete_appointment"]');
const linkedTypeEl = document.getElementById('linkedType');

linkedTypeEl.addEventListener('change', (e) => {
    if(e.target.value === 'appointment')
    {
        enableStatusCompletionEl.removeAttribute('disabled');

    }else{
        enableStatusCompletionEl.disabled = true;
        enableStatusCompletionEl.checked = false;
    }
})
