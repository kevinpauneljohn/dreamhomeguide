import Datatables from "datatables.net-bs5";
import moment from "moment";

export const taskTable = $('#task-table');

$(function () {

    initializeTaskTable()

    /* EXTERNAL SEARCH */
    $('#search, #status-filter, #priorities, #due-date-filter, #order-by-due, #agent-filter')
        .on('keyup change', function () {
            $('#task-table').DataTable().ajax.reload();
        });
});

export const initializeTaskTable = ()  => {
    taskTable.DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,

// 🔴 IMPORTANT: Disable DataTables default ordering
        ordering: false,

        pageLength: 25,

        ajax: {
            url: "/get-tasks",
            type: "GET",
            data: function (d) {
                d.search     = $('#search').val();
                d.assigned_to = $('#agent-filter').val();
                d.status     = $('#status-filter').val();
                d.priority   = $('#priorities').val();
                d.due_date   = $('#due-date-filter').val();
                d.order_due  = $('#order-by-due').val();
            }
        },

        columns: [

            /* TASK # */
            {
                data: 'id',
                render: id => `
                    <span class="fw-semibold text-muted task-number">
                        TSK-${String(id).padStart(5, '0')}
                    </span>
                `,
                orderable: false
            },

            /* TASK (TITLE + DESCRIPTION) */
            {
                data: null,
                render: row => {
                    const maxLength = 60;
                    const desc = row.description ?? '';

                    const truncated =
                        desc.length > maxLength
                            ? desc.substring(0, maxLength) + '…'
                            : desc;

                    return `
                    <strong>${row.title}</strong>
                    <div class="text-muted small" title="${desc}">
                        ${truncated}
                    </div>
                `;
                },
                orderable: false
            },


            /* DUE DATE */
            {
                data: 'due_date',
                render: due => {
                    const m = moment(due);
                    const isToday = m.isSame(moment(), 'day');
                    const label = isToday ? 'Today' : m.fromNow().includes('day') ? m.format('MMM DD') : m.format('MMM DD');

                    return `
                        <span class="fw-semibold ${isToday ? 'text-danger' : ''}">
                            ${label}
                        </span>
                        <div class="small text-muted">
                            ${m.format('h:mm A')}
                        </div>
                    `;
                },
                orderable: false
            },

            /* PRIORITY */
            {
                data: 'priority',
                render: priority => {
                    const map = {
                        high:   'bg-danger-subtle text-danger',
                        medium: 'bg-warning-subtle text-warning',
                        low:    'bg-success-subtle text-success'
                    };

                    return `
                        <span class="badge ${map[priority]}">
                            ${priority.charAt(0).toUpperCase() + priority.slice(1)}
                        </span>
                    `;
                },
                orderable: false
            },

            /* ASSIGNED */
            {
                data: 'assigned_to',
                render: assigned => {

                    if (!assigned) {
                        return `<span class="text-muted">Unassigned</span>`;
                    }

                    const initials = assigned.name
                        .split(' ')
                        .map(word => word.charAt(0))
                        .join('')
                        .substring(0, 2)
                        .toUpperCase();

                    return `
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar">${initials}</div>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">${assigned.name}</span>
                                <small class="text-muted">${assigned.role ?? 'Agent'}</small>
                            </div>
                        </div>
                    `;
                },
                orderable: false
            },


            /* LINKED TO */
            {
                data: 'linked_record',
                render: linked => {

                    if (!linked) {
                        return `<span class="text-muted">—</span>`;
                    }

                    const map = {
                        lead: 'bg-info-subtle text-info',
                        appointment: 'bg-primary-subtle text-primary',
                    };

                    return `
                        <span class="badge ${map[linked.type]}">
                            ${linked.label}
                        </span>
                        <div class="small text-muted">
                            Linked Record
                        </div>
                    `;
                },
                orderable: false
            },


            /* STATUS */
            {
                data: 'status',
                render: status => {
                    const map = {
                        'pending':     'bg-secondary-subtle text-secondary',
                        'in progress': 'bg-info-subtle text-info',
                        'completed':   'bg-success-subtle text-success',
                        'overdue':     'bg-warning-subtle text-warning'
                    };

                    return `
                        <span class="badge ${map[status]}">
                            ${status.replace(/\b\w/g, l => l.toUpperCase())}
                        </span>
                    `;
                },
                orderable: false
            },

            /* ACTION */
            {
                data: 'action',
                orderable: false,
                className: 'text-end',
                render: action => {

                    let buttons = '';

                    // View
                    if (action.view) {
                        buttons += `
                            <a
                                href="/task/${action.id}"
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
                                href="/task/${action.id}/edit"
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
                                    <i class="fa fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a
                                            href="#"
                                            class="dropdown-item text-danger"
                                            onclick="deleteTask(${action.id})"
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
}

