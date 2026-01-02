import axios from 'axios';
import { Toast } from "@/toast.js";

const updateProfileForm = document.getElementById('update-profile-form');
const saveBtn = document.getElementById('saveProfileBtn');
const btnText = saveBtn.querySelector('.btn-text');
const btnIcon = saveBtn.querySelector('i');

const changePasswordForm = document.getElementById('change-password-form');
const changePasswordBtn = document.getElementById('changePasswordBtn');

updateProfileForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // 🔒 LOCK UI
    toggleFormState(form, true);
    setButtonLoading(true);

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
        console.error(error.response || error);
    } finally {
        // 🔓 UNLOCK UI
        toggleFormState(form, false);
        setButtonLoading(false);
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
    const modal = new bootstrap.Modal(
        document.getElementById('changePasswordModal')
    );
    modal.show();
};

changePasswordBtn.addEventListener('click', openChangePasswordModal);


changePasswordForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // 🔒 LOCK UI
    toggleFormState(form, true);
    setButtonLoading(true);

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
        console.error(error.response || error);
    } finally {
        // 🔓 UNLOCK UI
        toggleFormState(form, false);
        setButtonLoading(false);
    }
})

