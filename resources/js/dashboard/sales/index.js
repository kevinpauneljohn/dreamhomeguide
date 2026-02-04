import DataTable from 'datatables.net-bs5';
import axios from 'axios';
import moment from 'moment';
import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import Swal from "sweetalert2";
select2()

let salesTable;

$(function(){
    $('select[name=projects]').select2({
        theme: 'bootstrap-5',
        placeholder: 'All Projects',
        allowClear: true,
    });

    $('select[name=agents]').select2({
        theme: 'bootstrap-5',
        placeholder: 'All Agents',
        allowClear: true,
    });


    salesTable = $('#sales-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ordering: false,
        lengthChange: false,
        pageLength: 10,
        responsive: true,

        ajax: {
            url: '/sales-datatable', // 👈 backend route
            type: 'GET',
            data: function (d) {
                d.search        = $('input[name="search"]').val();
                d.project_id    = $('select[name="projects"]').val();
                d.agent_id      = $('select[name="agents"]').val();
                d.status        = $('select[name="status"]').val();
                d.date_created  = $('input[name="date_created"]').val();
                d.sort          = $('select[name="sort"]').val();
            }
        },

        columns: [
            {
                data: 'client',
                name: 'client',
                render: function (data) {
                    return `
                        <strong>${data.name}</strong><br>
                        <small class="text-muted">${data.phone}</small>
                    `;
                }
            },
            { data: 'project', name: 'project' },
            {
                data: 'amount',
                name: 'amount',
                className: 'fw-bold',
                render: data => `₱${Number(data).toLocaleString()}`
            },
            {
                data: 'agent',
                name: 'agent',
                render: function (data) {
                    return `
                        <div class="d-flex align-items-center gap-2">
                            <span class="avatar bg-primary text-white">
                                ${data.initials}
                            </span>
                            <div>
                                <strong>${data.name}</strong><br>
                                <small class="text-muted">${data.role}</small>
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function (data) {
                    const map = {
                        completed: 'success',
                        reserved: 'warning',
                        cancelled: 'danger'
                    };

                    return `
                        <span class="badge rounded-pill
                              bg-${map[data]} bg-opacity-10
                              text-${map[data]} px-3">
                            ${data.charAt(0).toUpperCase() + data.slice(1)}
                        </span>
                    `;
                }
            },
            {
                data: 'date',
                name: 'date',
                render: function (data) {

                    const date = moment(data);

                    return `
            <div class="fw-semibold">${date.format('MMM DD')}</div>
            <small class="text-muted">${date.format('hh:mm A')}</small>
        `;
                }
            },
            {
                data: 'action',
                orderable: false,
                className: 'text-end',
                render: action => {

                    console.log(action);

                    let buttons = '';

                    // View
                    if (action.view) {
                        buttons += `
                            <a
                                href="/sales/${action.id}"
                                class="btn btn-sm btn-outline-secondary"
                                title="View task"
                            >
                                <i class="fa fa-eye"></i>
                            </a>
                        `;
                    }

                    // Edit
                    if (action.edit) {
                        buttons += `
                            <a
                                href="/sales/${action.id}/edit"
                                class="btn btn-sm btn-outline-secondary"
                                title="Edit task"
                            >
                                <i class="fa fa-pen"></i>
                            </a>
                        `;
                    }

                    // More actions (Delete inside dropdown)
                    if (action.delete) {
                        buttons += `
                            <div class="btn-group">
                                <button
                                    class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                >

                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a

                                            class="dropdown-item text-danger"
                                            onclick="deleteSale(
                                                ${action.id},
                                                '${action.client}',
                                                '${action.project}',
                                                '${action.tcp}',
                                                '${action.assigned_agent}'
                                            )"
                                            style="cursor: pointer"
                                        >
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `;
                    }

                    return `<div class="btn-group">${buttons}</div>`;
                }

            }
        ]
    });

    /* 🔄 FILTER LISTENERS */
    $('input[name="search"], select, input[name="date_created"]')
        .on('keyup change', function () {
            salesTable.ajax.reload();
        });
});

window.deleteSale = function (id, clientName, projectName, amount, assigned_agent) {

    const formattedAmount = Number(amount).toLocaleString();

    Swal.fire({
        title: 'Delete Sale?',
        html: `
            <div class="text-start">
                <p class="mb-2"><strong>Client:</strong> ${clientName}</p>
                <p class="mb-2"><strong>Project:</strong> ${projectName}</p>
                <p class="mb-2"><strong>Amount:</strong> ₱${formattedAmount}</p>
                <p class="mb-2"><strong>Agent:</strong> ${assigned_agent}</p>
                <hr>
                <p class="text-danger mb-0">
                    This action cannot be undone.
                </p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete sale',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) return;

        axios.delete(`/sales/${id}`)
            .then(response => {

                if (response.data?.success === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: 'Sales record has been deleted.',
                        confirmButtonText: 'OK'
                    }).then(() => {

                        // 🔥 reload AFTER user clicks OK
                        salesTable.ajax.reload(null, false);

                    });
                }

            })
            .catch(error => {
                console.error(error);

                Swal.fire({
                    icon: 'error',
                    title: 'Delete Failed',
                    text: error.response?.data?.message ?? 'Something went wrong.'
                });
            });
    });
};

