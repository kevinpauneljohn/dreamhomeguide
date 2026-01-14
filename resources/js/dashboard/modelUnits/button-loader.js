const setLoading = (element) => {
    element.disabled = true;
    element.dataset.originalText = element.innerHTML;
    element.innerHTML = `
        <span class="spinner-border spinner-border-sm me-1"></span>
        Saving...
    `;
};

const resetLoading = (element) => {
    element.disabled = false;
    element.innerHTML = element.dataset.originalText || 'Save';
};

export {setLoading, resetLoading};
