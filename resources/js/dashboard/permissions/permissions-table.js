import "datatables.net-bs5";
import {Toast} from "@/toast.js";
import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import Swal from "sweetalert2";
select2()

let permissionsTable;
let permissionId = null;
let mode = "create";

const setMode = (value) => {
    mode = value;
}

const getMode = () => mode;

///add roles
const addPermissionBtn = document.getElementById('add-permission-btn');
const permissionModalEl = document.getElementById('permissionModal');
const permissionFormEl = permissionModalEl.querySelector('form');
const savePermissionButton = permissionModalEl.querySelector('button[type=submit]');

const permissionModal = new bootstrap.Modal(permissionModalEl, {
    backdrop: 'static', // optional
    keyboard: false     // optional
});

addPermissionBtn.addEventListener('click', () => {

    permissionFormEl.reset();
    $('#roles').val('').trigger('change');

    permissionFormEl.querySelector('.modal-title').textContent = 'Add Permission';
    permissionModal.show();

    permissionFormEl.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    permissionFormEl.querySelectorAll('input').forEach(el => el.classList.remove('is-invalid'));
    setMode('create')

})

permissionFormEl.addEventListener('submit', async (e) => {
    e.preventDefault();
    let formData = new FormData(permissionFormEl);
    let url = '#';

    if(getMode() === 'create')
    {
        url = `/permissions`;
    }
    else if(getMode() === 'edit')
    {
        url = `/permissions/${permissionId}`;
        formData.append('_method', 'PUT');
    }
    createOrUpdatePermission(formData, url);
});

window.getPermission = (permission) => {
    permissionFormEl.querySelector('.modal-title').textContent = 'Edit Role';
    permissionModal.show()

    axios.get(`/permissions/${permission}/edit`)
        .then(response => {
            console.log(response)
            permissionFormEl.querySelector('[name=permission]').value = response.data.permission.name;
            $('#roles').val(response.data.roles).trigger('change');
        }).catch((error) => {
        console.log(error)
    }).finally(() => {
        permissionFormEl.querySelectorAll('input, button[type=submit]')
            .forEach(el => el.disabled = false);
    })

}

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.edit-permission-btn');
    if (!btn) return;

    permissionFormEl.querySelectorAll('input, button[type=submit]')
        .forEach(el => el.disabled = true);
    permissionFormEl.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    permissionFormEl.querySelectorAll('input').forEach(el => el.classList.remove('is-invalid'));
    permissionId = btn.dataset.id;
    getPermission(btn.dataset.id);
    setMode('edit')
});

const createOrUpdatePermission = (formData, url) => {
    beforePermissionSaved();

    axios.post(url, formData)
        .then(response => {
            console.log(response)
            if(response.data.success === true)
            {
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })
                reloadPermissionsTable()
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
    console.log(errors)
        Object.keys(errors).forEach(key => {
            permissionFormEl.querySelector(`[name=${key}]`).classList.add('is-invalid');
            permissionFormEl.querySelector(`[name=${key}]`)
                .insertAdjacentHTML('afterend', `<p class="invalid-feedback">${errors[key][0]}</p>`);
        })
    }).finally(() => {
        afterPermissionSaved()
    })
}

window.removePermission = function (model) {
    const rowData = permissionsTable.row($(model).closest('tr')).data();
    console.log(rowData)
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
            confirmRemovePermission(rowData.id)
        }
    })
}

const confirmRemovePermission = (permission_id) => {
    console.log(permission_id)
    axios.delete(`/permissions/${permission_id}`,{
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        }
    }).then(response => {
        console.log(response)
        if(response.data.success === true)
        {
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            reloadPermissionsTable()
        }
        else if(response.data.success === false)
        {
            Toast.fire({
                icon: 'error',
                title: response.data.message
            })
        }
    }).catch(error => {
        console.log(error)
    })
}

const beforePermissionSaved = () => {
    permissionFormEl.querySelectorAll('input, button[type=submit]')
        .forEach(el => el.disabled = true);
    savePermissionButton.textContent = 'Saving...';
    permissionFormEl.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    permissionFormEl.querySelectorAll('input').forEach(el => el.classList.remove('is-invalid'));
}

const afterPermissionSaved = () => {

    if(getMode() === 'create')
    {
        permissionFormEl.reset();
    }

    permissionFormEl.querySelectorAll('input, button[type=submit]')
        .forEach(el => el.disabled = false);
    savePermissionButton.textContent = 'Save';
}

$(function () {
    $('#role').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Filter By Role',
        allowClear: true
    });

    $('#roles').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Assign Roles',
        allowClear: true
    });
});

permissionsTable = $('#permissions-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "/get-permissions",
        type: 'GET',
        data: function (d) {
            d.search = $('#search').val();
            d.role = $('#role').val();
            d.sort = $('#sort').val();
        }
    },
    columns: [
        {
            data: "name",
        },
        {
            data: "roles",
            render: function(roles){
                if (!roles || !roles.length) {
                    return '<span class="text-muted">—</span>';
                }

                return roles
                    .map(role => `<span class="badge bg-success me-1">${role}</span>`)
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
                                ${action.edit ? `<li><a style="cursor: pointer" data-id="${action.id}"  class="dropdown-item edit-permission-btn">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a style="cursor: pointer" onclick="removePermission(this)" class="dropdown-item text-danger">Delete</a></li>` : ''}
                            </ul>
                        </div>
                    `;
            }
        },

    ]
});

$(document).ready(function () {
    $(document).on('change', '#role, #sort', function () {
        reloadPermissionsTable()
    })

    $(document).on('keyup', '#search', function () {
        const value = this.value.trim();

        if (value.length >= 3 || value.length === 0) {
            permissionsTable.search(value).draw();
        }
    })
})

const reloadPermissionsTable = () => {
    permissionsTable.ajax.reload(null, false);
}
