import DataTable from 'datatables.net-bs5';
import moment from 'moment';
import {removeModelUnit} from "@/dashboard/modelUnits/delete.js";

let modelUnitsTable = $('#model-units-table');
const projectId = document.getElementById('project').dataset.projectId;

$(function () {
    removeModelUnit();
    $('#model-units-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 10,
        ordering: false,

        ajax: {
            url: `/get-model-units/${projectId}`, // adjust route
            type: 'GET',
        },

        columns: [
            {
                data: 'name',
                render: (data, type, row) => {
                    return `
                        <div class="fw-semibold">${data}</div>
                        <small class="text-muted">${row.slug}</small>
                    `;
                }
            },
            { data: 'type' },
            {
                data: 'lot_area',
                className: 'text-end',
                render: data => data ?? '—'
            },
            {
                data: 'floor_area',
                className: 'text-end',
                render: data => data ?? '—'
            },
            {
                data: 'status',
                render: status => {
                    const badges = {
                        published: 'success',
                        draft: 'secondary',
                        archived: 'dark'
                    };

                    return `
                        <span class="badge bg-${badges[status] ?? 'secondary'}">
                            ${status}
                        </span>
                    `;
                }
            },
            {
                data: 'created_at',
                width: '200px',
                render: date => moment(date).format('MMM DD, YYYY hh:mm A')
            },
            {
                data: "action",
                width: '20px',
                orderable: false,
                render: function (action) {
                    return `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                ${action.view ? `<li><a href="/project/${action.id}" class="dropdown-item">View</a></li>` : ''}
                                ${action.edit ? `<li><a data-model-unit-id="${action.id}" class="dropdown-item edit-model-unit" style="cursor: pointer">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a data-model-unit-id="${action.id}" class="dropdown-item text-danger delete-model-unit" style="cursor: pointer">Delete</a></li>` : ''}
                            </ul>
                        </div>
                    `;
                }
            },
        ]
    });
});

document.addEventListener('reload:table', () => {
    modelUnitsTable.DataTable().ajax.reload();
})
