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

const disableForm = (form) => {
    [...form.elements].forEach(el => {
        el.dataset.wasDisabled = el.disabled;
        el.disabled = true;
    });
};

const enableForm = (form) => {
    [...form.elements].forEach(el => {
        el.disabled = el.dataset.wasDisabled === 'true';
        delete el.dataset.wasDisabled;
    });
};

export {setLoading, resetLoading, disableForm, enableForm};
