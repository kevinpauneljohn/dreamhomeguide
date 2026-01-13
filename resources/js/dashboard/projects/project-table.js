import Datatables from "datatables.net-bs5";
import {removeProject} from "@/dashboard/projects/delete.js";
window.removeProject = removeProject;
import moment from "moment";
export const projectsTable = $('#projects-table');

$(function () {
    initializeProjectTable()

    /* EXTERNAL SEARCH */
    $('#search').on('keyup change', function () {

            const searchValue = $('#search').val().trim();
            const searchLength = searchValue.length;

            if (searchLength === 0 || searchLength > 2) {
                projectsTable.DataTable().ajax.reload();
            }

        });
});
export const initializeProjectTable = ()  => {
    projectsTable.DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,

        pageLength: 25,

        ajax: {
            url: "/get-projects",
            type: "GET",
            data: function (d) {
                d.search     = $('#search').val();
            }
        },

        columns: [
            {
                data: 'name'
            },
            {
                data: 'slug'
            },
            {
                data: 'address'
            },
            {
                data: 'created_at',
                render: function (data) {
                    return data
                        ? moment(data).format('MMM DD, YYYY hh:mm A')
                        : '';
                }
            },
            {
                data: 'status'
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
                                ${action.view ? `<li><a href="/project/${action.id}" class="dropdown-item">View</a></li>` : ''}
                                ${action.edit ? `<li><a data-project-id="${action.id}" class="dropdown-item edit-project" style="cursor: pointer">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a data-project-id="${action.id}" onclick="removeProject(this)" class="dropdown-item text-danger delete-project" style="cursor: pointer">Delete</a></li>` : ''}
                            </ul>
                        </div>
                    `;
                }
            },
        ]
    });
}

document.addEventListener('project:created_or_updated', () => {
    projectsTable.DataTable().ajax.reload();
})

document.addEventListener('project:deleted', () => {
    projectsTable.DataTable().ajax.reload();
})

export {projectsTable as default}
