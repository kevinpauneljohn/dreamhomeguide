import Datatables from "datatables.net-bs5";
import {removeProject} from "@/dashboard/projects/delete.js";
window.removeProject = removeProject;
import moment from "moment";
export const projectsTable = $('#projects-table');

$(function () {
    initializeProjectTable()
    removeProject();

    /* EXTERNAL SEARCH */
    $('#search').on('keyup change', function () {

            const searchValue = $('#search').val().trim();
            const searchLength = searchValue.length;

            if (searchLength === 0 || searchLength > 2) {
                projectsTable.DataTable().ajax.reload();
            }

        });
});
export const initializeProjectTable = () => {
    projectsTable.DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        pageLength: 25,
        ordering: false,
        responsive: true,

        ajax: {
            url: "/get-projects",
            type: "GET",
            data: d => {
                d.search = $('#search').val();
            }
        },

        columns: [
            {
                data: 'name',
                render: (data, type, row) => `
                    <div class="fw-semibold">${data}</div>
                    <small class="text-muted">${row.slug}</small>
                `
            },
            {
                data: 'address',
                render: data =>
                    data
                        ? `<span class="text-truncate d-inline-block" style="max-width:260px">${data}</span>`
                        : '<span class="text-muted">—</span>'
            },
            {
                data: 'created_at',
                className: 'text-nowrap',
                render: function (data) {
                    if (!data) return '';

                    return `
            <div class="fw-semibold">
                ${moment(data).format('MMM DD, YYYY')}
            </div>
            <small class="text-muted">
                ${moment(data).format('hh:mm A')}
            </small>
        `;
                }
            },

            {
                data: 'status',
                render: status => {
                    const map = { published: 'success', draft: 'secondary', archived: 'dark' };
                    return `<span class="badge bg-${map[status] ?? 'secondary'}">${status}</span>`;
                }
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
                            ${action.view ? `<li><a href="/project/${action.id}" class="dropdown-item"><i class="bi bi-eye me-2"></i>View</a></li>` : ''}
                            ${action.edit ? `<li><a data-project-id="${action.id}" class="dropdown-item edit-project" style="cursor: pointer"><i class="bi bi-pencil me-2"></i>Edit</a></li>` : ''}
                            ${action.delete ? `<li><a data-project-id="${action.id}" class="dropdown-item text-danger delete-project" style="cursor: pointer"><i class="bi bi-trash me-2"></i>Delete</a></li>` : ''}
                        </ul>
                    </div>
                `
            }
        ]
    });
};


document.addEventListener('project:created_or_updated', () => {
    projectsTable.DataTable().ajax.reload();
})

document.addEventListener('project:deleted', () => {
    projectsTable.DataTable().ajax.reload();
})

export {projectsTable as default}
