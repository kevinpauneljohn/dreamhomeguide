import DataTable from 'datatables.net-bs5';
import moment from 'moment';
import {editCommission} from "@/dashboard/commissions/edit.js";
import {deleteCommission} from "@/dashboard/commissions/delete.js";

let commissionTable;
const commissionForm = document.getElementById('commission-form');
const userId = commissionForm.dataset.userId;

commissionTable = $('#commission-table').DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    ordering: false,
    lengthChange: false,
    pageLength: 10,
    responsive: true,

    ajax: {
        url: `/commissions-datatable/${userId}` // pass user id from blade
    },

    columns: [
        {
            data: 'date_assigned',
            render: data => `
                <div class="fw-semibold">${data.date}</div>
                <small class="text-muted">${data.time}</small>
            `
        },
        {
            data: 'rate',
            className: 'fw-bold',
            render: rate => `${rate}%`
        },
        {
            data: 'project',
            render: project => `
                <span class="badge bg-light text-dark">
                    ${project}
                </span>
            `
        },
        {
            data: 'action',
            className: 'text-end',
            render: action =>
                `
                <div class="btn-group">
                    <button
                        class="btn btn-sm btn-outline-secondary"
                        onclick="editCommission(${action.id})"
                    >
                        <i class="fa fa-pen"></i>
                    </button>

                    <button
                        class="btn btn-sm btn-outline-danger"
                        onclick="deleteCommission(${action.id})"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `
        }
    ]
});
