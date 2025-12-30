import "datatables.net-bs5";
import {Toast} from "@/toast.js";
import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import Swal from "sweetalert2";
select2()

let rolesTable;
let roleId = null;
let mode = "create";

const setMode = (value) => {
    mode = value;
}

const getMode = () => mode;

$(function () {
    $('#permission').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Filter By Permission',
        allowClear: true
    });
});

rolesTable = $('#roles-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "/roles/get",
        type: 'GET',
        data: function (d) {
            d.search = $('#search').val();
            d.permission = $('#permission').val();
            d.sort = $('#sort').val();
        }
    },
    columns: [
        {
            data: "name",
        },
        {
            data: "permissions",
            render: function(permissions){
                if (!permissions || !permissions.length) {
                    return '<span class="text-muted">—</span>';
                }

                return permissions
                    .map(permission => `<span class="badge bg-success me-1">${permission}</span>`)
                    .join('');
            }
        },
        {
            data: "users",
            render: function(users){
                if (!users || !users.length) {
                    return '<span class="text-muted">—</span>';
                }

                return users
                    .map(user => `<span class="badge bg-orange me-1">${user}</span>`)
                    .join('');
            }
        },
        {
            data: "created_at",
            render: function(created_at){
                return `<small class="text-muted">${created_at}</small>`;
            }
        },
        {
            data: "action",
            orderable: false,
            render: function (action) {
                return `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                ${action.view ? `<li><a href="/user/${action.id}" class="dropdown-item">View</a></li>` : ''}
                                ${action.edit ? `<li><a href="#" data-id="${action.id}"  class="dropdown-item edit-role-btn">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a href="#" onclick="removeRole(this)" class="dropdown-item text-danger">Delete</a></li>` : ''}
                            </ul>
                        </div>
                    `;
            }
        },

    ]
});

window.removeRole = function (model) {
    const rowData = rolesTable.row($(model).closest('tr')).data();

    Swal.fire({
        title: "Are you sure?",
        html: `Remove <span class="fw-bolder text-primary">${rowData.name}</span>?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!"
    }).then((result) => {
        if (result.isConfirmed) {
            confirmRemoveRole(rowData.id);
        }
    });
}

const confirmRemoveRole = (role_id) => {
    axios.delete(`/roles/${role_id}`,{
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        }
    }).then(response => {
        if(response.data.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            reloadRolesTable()
        }
        else if(response.data.success === false)
        {
            Toast.fire({
                icon: 'error',
                title: response.data.message
            })
        }
    })
        .catch(error => {
            console.log(error)
        })
}

$(document).ready(function () {
    $(document).on('change', '#permission, #sort', function () {
        reloadRolesTable()
    })

    $(document).on('keyup', '#search', function () {
        const value = this.value.trim();

        if (value.length >= 3 || value.length === 0) {
            rolesTable.search(value).draw();
        }
    })
})

const reloadRolesTable = () => {
    rolesTable.ajax.reload(null, false);
}

///add roles
const addRoleBtn = document.getElementById('add-role-btn');
const roleModalEl = document.getElementById('roleModal');
const roleFormEl = roleModalEl.querySelector('form');
const saveRoleButton = roleModalEl.querySelector('button[type=submit]');

const roleModal = new bootstrap.Modal(roleModalEl, {
    backdrop: 'static', // optional
    keyboard: false     // optional
});

addRoleBtn.addEventListener('click', () => {

    roleFormEl.reset();
    roleFormEl.querySelector('.modal-title').textContent = 'Add Role';
    roleModal.show();

    roleFormEl.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    roleFormEl.querySelectorAll('input').forEach(el => el.classList.remove('is-invalid'));
    setMode('create')

})

roleFormEl.addEventListener('submit', async (e) => {
    e.preventDefault();
    let formData = new FormData(roleFormEl);
    let url = '#';

    if(getMode() === 'create')
    {
        url = `/roles`;
    }
    else if(getMode() === 'edit')
    {
        url = `/roles/${roleId}`;
        formData.append('_method', 'PUT');
    }
    createOrUpdateRole(formData, url);

});

const createOrUpdateRole = (formData, url) => {
    beforeRoleSaved();

    axios.post(url, formData)
        .then(response => {

            if(response.data.success === true)
            {
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
                reloadRolesTable()
            }
            else if(response.data.success === false)
            {
                Toast.fire({
                    icon: 'error',
                    title: response.data.message
                })
            }

        }).catch((error) => {
        const errors = error.response.data.errors;

        Object.keys(errors).forEach(key => {
            roleFormEl.querySelector(`[name=${key}]`).classList.add('is-invalid');
            roleFormEl.querySelector(`[name=${key}]`)
                .insertAdjacentHTML('afterend', `<p class="invalid-feedback">${errors[key][0]}</p>`);
        })
    }).finally(() => {
        afterRoleSaved()
    })
}

// const editRole = (formData) => {
//     beforeRoleSaved();
// }

window.getRole = (role) => {
    roleFormEl.querySelector('.modal-title').textContent = 'Edit Role';
    roleModal.show()

    axios.get(`/roles/${role}/edit`)
        .then(response => {
            roleFormEl.querySelector('[name=roles]').value = response.data.name;
        }).catch((error) => {
        console.log(error)
        }).finally(() => {
        roleFormEl.querySelectorAll('input, button[type=submit]')
            .forEach(el => el.disabled = false);
    })

}

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.edit-role-btn');
    if (!btn) return;

    roleFormEl.querySelectorAll('input, button[type=submit]')
        .forEach(el => el.disabled = true);
    roleFormEl.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    roleFormEl.querySelectorAll('input').forEach(el => el.classList.remove('is-invalid'));
    roleId = btn.dataset.id;
    getRole(btn.dataset.id);
    setMode('edit')
});

const beforeRoleSaved = () => {
    roleFormEl.querySelectorAll('input, button[type=submit]')
        .forEach(el => el.disabled = true);
    saveRoleButton.textContent = 'Saving...';
    roleFormEl.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    roleFormEl.querySelectorAll('input').forEach(el => el.classList.remove('is-invalid'));
}

const afterRoleSaved = () => {

    if(getMode() === 'create')
    {
        roleFormEl.reset();
    }

    roleFormEl.querySelectorAll('input, button[type=submit]')
        .forEach(el => el.disabled = false);
    saveRoleButton.textContent = 'Save';
}

