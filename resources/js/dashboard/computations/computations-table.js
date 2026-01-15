import "datatables.net-bs5";
import moment from "moment"
import {removeComputation} from "@/dashboard/computations/delete.js";

const computationTable = $('#computationsTable');

const initializeTable = () => {

    // ✅ Destroy ONLY the DataTable instance
    if ($.fn.DataTable.isDataTable('#computationsTable')) {
        computationTable.DataTable().destroy();
    }

    computationTable.DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        autoWidth: false,
        responsive: false,
        orderings: false,

        ajax: {
            url: '/get-computations',
            data: function (d) {
                d.search     = $('#search').val();
                d.project_id = $('#filter-project').val();
                d.financing  = $('#filter-financing').val();
                d.date_from = $('#filter-date').val();
            }
        },

        columns: [
            {
                data: null,
                name: 'project',
                render: row => `
            <div class="fw-semibold">${row.project}</div>
            <div class="text-muted small">${row.model_unit} ${row.type}</div>
        `
            },
            {
                data: 'financing',
                name: 'financing',
                render: val => {
                    const map = {
                        bank: 'primary',
                        hdmf: 'success',
                        inhouse: 'warning',
                        cash: 'dark',
                        'deferred-cash': 'info'
                    };
                    const color = map[val] ?? 'secondary';
                    return `<span class="badge bg-${color} text-uppercase">${val}</span>`;
                }
            },
            {
                data: 'updated_at',
                name: 'updated_at',
                className: 'text-nowrap',
                render: data => `
            <div class="fw-semibold">
                ${moment(data).format('MMM DD, YYYY')}
            </div>
            <small class="text-muted">
                ${moment(data).format('hh:mm A')}
            </small>
        `
            },
            {
                data: 'updated_by',
                name: 'updated_by',
                render: val => `
            <div class="fw-semibold">${val ?? '—'}</div>
            <small class="text-muted">User</small>
        `
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: action => `
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary border-0"
                                data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            ${action.view ? `<li><a data-computation-id="${action.id}" class="dropdown-item view-computation" style="cursor: pointer"><i class="bi bi-eye me-2"></i>View</a></li>` : ''}
                            ${action.edit ? `<li><a data-computation-id="${action.id}" class="dropdown-item edit-computation" style="cursor: pointer"><i class="bi bi-pencil me-2"></i>Edit</a></li>` : ''}
                            ${action.delete ? `<li><a data-computation-id="${action.id}" class="dropdown-item text-danger delete-computation" style="cursor: pointer"><i class="bi bi-trash me-2"></i>Delete</a></li>` : ''}
                        </ul>
                    </div>
                `
            }
        ],

        order: [[2, 'desc']]
    });
};

$(function () {
    initializeTable();
    removeComputation();

    // 🔁 FILTER RELOAD (required)
    $('#filter-project, #filter-financing, #filter-date').on('keyup change', () => {
        reloadComputationTable()
    });

    $('#search').on('input', () => {
        let searchValue = $('#search').val().trim().length;
        if (searchValue > 2)reloadComputationTable()
    });

    $('#btnResetFilters').on('click', () => {
        $('#search').val('');
        $('#filter-project').val('');
        $('#filter-financing').val('');
        $('#filter-date').val('');
        reloadComputationTable()
    });
});

const reloadComputationTable = () => {
    const table = $('#computationsTable').DataTable();
    table.ajax.reload(null, false); // keep page, safe
};

export {reloadComputationTable};

