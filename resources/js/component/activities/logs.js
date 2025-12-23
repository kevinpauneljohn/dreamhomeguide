import "datatables.net-bs5";
import moment from 'moment';

let activityLogsDataTable = null;
const activityLogModal = document.getElementById('viewActivityModal');

$(function () {
    const tableEl = document.getElementById('activity-logs-table');
    if (!tableEl) return;

    const url = tableEl.dataset.url;

    // ✅ PREVENT DOUBLE INITIALIZATION
    if ($.fn.DataTable.isDataTable('#activity-logs-table')) {
        activityLogsDataTable = $('#activity-logs-table').DataTable();
        return;
    }
    activityLogsDataTable = $('#activity-logs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${url}`,
        ordering: false,
        searching: false,
        columns: [

            // ICON COLUMN
            {
                data: 'icon',
                render: function (event) {

                    const map = {
                        created: {
                            icon: 'bi-plus-circle-fill',
                            color: 'success',
                            label: 'Created'
                        },
                        updated: {
                            icon: 'bi-pencil-square',
                            color: 'primary',
                            label: 'Updated'
                        },
                        deleted: {
                            icon: 'bi-trash-fill',
                            color: 'danger',
                            label: 'Deleted'
                        },
                        login: {
                            icon: 'bi-shield-check',
                            color: 'success',
                            label: 'Logged In'
                        },
                        logout: {
                            icon: 'bi-shield-lock',
                            color: 'danger',
                            label: 'Logged Out'
                        }
                    };

                    const cfg = map[event] ?? {
                        icon: 'bi-info-circle',
                        color: 'secondary'
                    };

                    return `
                    <div class="d-flex justify-content-center">
                        <i class="bi ${cfg.icon} fs-5 text-${cfg.color}"></i>
                    </div>
                `;
                }
            },

            // DESCRIPTION COLUMN
            {
                data: null,
                render: function (row) {

                    const title = row.description ?? 'Activity logged';
                    const sub = row.email ?? ''; // optional (if available)

                    return `
                        <div class="d-flex flex-column">

                            <!-- PRIMARY LINE -->
                            <small class="fw-semibold text-dark">
                                <a href="/user/${row.causer_id}" class="text-decoration-none">${row.primary_text}</a>
                            </small>

                            <!-- SECONDARY LINE (email / extra info) -->
                            ${sub ? `
                                <span class="text-muted small">
                                    ${sub}
                                </span>
                            ` : ''}

                            <!-- META LINE -->
                            <span class="text-muted small mt-1">
                                <i class="bi bi-clock"></i> ${row.time_ago}
                                &nbsp;·&nbsp;
                                <span class="text-secondary">(${row.exact_date})</span>
                            </span>

                        </div>
                    `;
                }
            },
            {
                data: 'properties',
                render: function (row) {
                    return `
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-xs btn-light text-light-emphasis" onclick='showActivityModal(${JSON.stringify(row)})'>View</button>
                    </div>
                `;
                }
            },


        ]
    });

});

window.showActivityModal = (activity) => {
console.log(activity);
    const modalEl = document.getElementById('viewActivityModal');

    // =========================
    // CORE DATA
    // =========================
    const causerName = activity.causer
        ? `${activity.causer.first_name} ${activity.causer.last_name}`
        : 'System';

    const subject = activity.log_name ?? '';
    const action = activity.event ?? '';
    const description = activity.description ?? '';

    // =========================
    // DATE HANDLING
    // =========================
    const createdAt = activity.created_at
        ? moment(activity.created_at)
        : null;

    const timeAgo = createdAt ? createdAt.fromNow() : '';
    const exactDate = createdAt ? createdAt.format('MMM DD, YYYY hh:mm A') : '';

    // =========================
    // PROPERTIES
    // =========================
    const { old = {}, attributes = {} } = activity.properties ?? {};
    const isDeleted = activity.event === 'deleted';
    const isLoggedIn = activity.event === 'login' || activity.event === 'logout';

    // =========================
    // HELPER: RESOLVE DISPLAY VALUE
    // =========================
    const resolveValue = (key, value, source) => {
        if (key === 'lead_id' && source.lead_id_name) {
            return source.lead_id_name;
        }

        if (key === 'user_id' && source.user_id_name) {
            return source.user_id_name;
        }

        if (key === 'assigned_agent' && source.assigned_agent_name) {
            return source.assigned_agent_name;
        }

        return value ?? '-';
    };

    // =========================
    // BUILD CHANGE ROWS
    // =========================
    let rows = '';

    if (isDeleted) {
        // Deleted → show full snapshot
        Object.keys(old).forEach(key => {
            const displayValue = resolveValue(key, old[key], old);

            rows += `
                <tr>
                    <td class="fw-semibold text-capitalize">
                        ${key.replaceAll('_', ' ')}
                    </td>
                    <td class="text-danger">
                        ${displayValue}
                    </td>
                    <td class="text-muted">—</td>
                </tr>
            `;
        });
    }
    else if (isLoggedIn) {
        Object.keys(activity.properties).forEach(key => {
            console.log(activity.log_name);

            rows += `
                <tr>
                    <td class="fw-semibold text-capitalize">
                        ${key.replaceAll('_', ' ')}
                    </td>

                    <td colspan="2" class="text-success">
                        ${key === 'location' ?
                        `${activity.properties['location']['region']}
                        ${activity.properties['location']['city']}
                        ${activity.properties['location']['isp']}
                        ${activity.properties['location']['lang']}
                        ${activity.properties['location']['lat']}
                        ${activity.properties['location']['timezone']}`
                        : activity.properties[key]}

                    </td>
                </tr>
            `;
        });
    }
    else {
        // Created / Updated → show diff
        Object.keys(attributes).forEach(key => {
            const oldValue = resolveValue(key, old[key], old);
            const newValue = resolveValue(key, attributes[key], attributes);

            rows += `
                <tr>
                    <td class="fw-semibold text-capitalize">
                        ${key.replaceAll('_', ' ')}
                    </td>
                    <td class="text-danger">
                        ${oldValue}
                    </td>
                    <td class="text-success">
                        ${newValue}
                    </td>
                </tr>
            `;
        });
    }

    // =========================
    // MODAL CONTENT
    // =========================
    modalEl.querySelector('.modal-title').textContent = 'Activity Details';

    modalEl.querySelector('.modal-body').innerHTML = `
    <!-- HEADER / META ROW -->
    <div class="row align-items-start mb-4">
        <!-- CAUSER -->
        <div class="col-md-6">
            <div class="fw-semibold fs-6">${causerName}</div>
            <div class="text-muted small">
                Caused by ·
                <i class="bi bi-clock"></i>
                ${timeAgo}
                ${exactDate ? `<span class="text-secondary">(${exactDate})</span>` : ''}
            </div>
        </div>

        <!-- SUBJECT -->
        ${subject ? `
            <div class="col-md-3">
                <div class="fw-semibold text-uppercase small text-secondary">
                    Subject
                </div>
                <div>${subject}</div>
            </div>
        ` : ''}

        <!-- ACTION -->
        ${action ? `
            <div class="col-md-3">
                <div class="fw-semibold text-uppercase small text-secondary">
                    Action
                </div>
                <div class="text-capitalize">${action}</div>
            </div>
        ` : ''}
    </div>

    <!-- CHANGES -->
    <div>
        <div class="fw-semibold mb-2">Changes</div>
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%">Field</th>
                    <th style="width: 30%">
                        ${isDeleted ? 'Deleted Value' : 'Old Value'}
                    </th>
                    <th style="width: 30%">
                        ${isDeleted ? '' : 'New Value'}
                    </th>
                </tr>
            </thead>
            <tbody>
                ${rows || `
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">
                            No changes recorded
                        </td>
                    </tr>
                `}
                ${activity.log_name === 'leads' || activity.log_name ? 'login' || 'logout' : `
                    <tr>
                        <td colspan="2" class="fw-semibold text-capitalize">Lead Name</td>
                        <td class="text-right text-success">
                            ${activity.properties.lead_name}
                        </td>
                    </tr>
                `}

            </tbody>
        </table>
    </div>
`;



    // =========================
    // SHOW MODAL
    // =========================
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl, {
        backdrop: true
    });

    modal.show();
};




export function reloadActivityLogs() {
    activityLogsDataTable?.ajax.reload(null, false);
}
