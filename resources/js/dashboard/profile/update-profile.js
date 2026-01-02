import axios from 'axios';
import { Toast } from "@/toast.js";

const updateProfileForm = document.getElementById('update-profile-form');
const saveBtn = document.getElementById('saveProfileBtn');
const btnText = saveBtn.querySelector('.btn-text');
const btnIcon = saveBtn.querySelector('i');

const changePasswordForm = document.getElementById('change-password-form');
const changePasswordBtn = document.getElementById('changePasswordBtn');

const modal = new bootstrap.Modal(
    document.getElementById('changePasswordModal')
);

updateProfileForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // 🔒 LOCK UI
    toggleFormState(form, true);
    setButtonLoading(true);

    beforeSave(updateProfileForm);

    try {
        const response = await axios.post('/profile/update', formData, {
            headers: { 'X-HTTP-Method-Override': 'PUT' }
        });

        if (response.data.success) {
            Toast.fire({
                icon: 'success',
                title: response.data.message ?? 'Profile updated successfully'
            });
        } else {
            Toast.fire({
                icon: 'warning',
                title: response.data.message ?? 'No changes detected'
            });
        }

    } catch (error) {
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong while saving'
        });

        const errors = error.response.data.errors;

        Object.keys(errors).forEach(key => {
            const input = updateProfileForm.querySelector(`[name="${key}"]`);
            if (!input) return;

            input.classList.add('is-invalid');
            input.insertAdjacentHTML(
                'afterend',
                `<div class="invalid-feedback">${errors[key][0]}</div>`
            );
        });
        console.error(error.response || error);
    } finally {
        // 🔓 UNLOCK UI
        toggleFormState(form, false);
        setButtonLoading(false);

        afterSave(updateProfileForm);
    }
});

/* =====================
   Helpers
===================== */

const toggleFormState = (form, disabled) => {
    form.querySelectorAll('input, select, textarea, button')
        .forEach(el => el.disabled = disabled);
}

const setButtonLoading = (loading) => {
    if (loading) {
        saveBtn.disabled = true;
        btnIcon.className = 'fa fa-spinner fa-spin me-1';
        btnText.textContent = 'Saving...';
    } else {
        btnIcon.className = 'fa fa-save me-1';
        btnText.textContent = 'Save Changes';
    }
}
const openChangePasswordModal = () => {
    modal.show();
};

changePasswordBtn.addEventListener('click', openChangePasswordModal);


changePasswordForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const data = new FormData(form);

    beforeSave(changePasswordForm);

    try {
        data.append('_method', 'PUT');
        // Use PUT directly (no method spoof needed)
        const response = await axios.post('/profile/change-password', data);

        if (response.data.success) {
            Toast.fire({
                icon: 'success',
                title: response.data.message
            });

            form.reset();
            modal.hide()
        }

    } catch (error) {
        // ✅ Handle validation errors
        if (error.response?.status === 422) {
            const errors = error.response.data.errors;

            Object.keys(errors).forEach(key => {
                const input = changePasswordForm.querySelector(`[name="${key}"]`);
                if (!input) return;

                input.classList.add('is-invalid');
                input.insertAdjacentHTML(
                    'afterend',
                    `<div class="invalid-feedback">${errors[key][0]}</div>`
                );
            });

        } else {
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong while saving'
            });
        }

        // console.error(error.response || error);

    } finally {
        // 🔓 ALWAYS restore UI
        afterSave(changePasswordForm);
    }
});


const removeErrorMessages = (formElement) => {
    formElement.querySelectorAll('.is-invalid').forEach(input => {
        input.classList.remove('is-invalid');
    })
    formElement.querySelectorAll('.invalid-feedback').forEach(error => {
        error.remove();
    })
}
const beforeSave = (formElement) => {
    removeErrorMessages(formElement);

    formElement.querySelectorAll('input, textarea').forEach(input => {
        input.disabled = true;
    })

    formElement.querySelector('button[type=submit]').disabled = true;
    formElement.querySelector('button[type=submit]')
        .innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
}

const afterSave = (formElement) => {
    formElement.querySelectorAll('input, textarea').forEach(input => {
        input.disabled = false;
    })
    formElement.querySelector('button[type=submit]').disabled = false;
    formElement.querySelector('button[type=submit]').innerHTML = 'Save Changes';
}

