import "datatables.net-bs5";

import moment from "moment";
import '../../../css/properties.css';

import select2 from 'select2';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'
import Swal from "sweetalert2";
select2()

$(function () {
    $('#status').select2({
        theme: 'bootstrap-5',
        width: '20%',
        placeholder: 'Filter By Status',
        allowClear: true
    });

    $('#source').select2({
        theme: 'bootstrap-5',
        width: '20%',
        placeholder: 'Filter By Source',
        allowClear: true
    });

    const crmTable = $('#crm-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/get-leads",
            type: 'GET',
            data: function (d) {
                let date = $('#date_range').val();

                d.status = $('#status').val();
                d.source = $('#source').val();
                d.search = $('#search').val();
                d.date_range = date
                    ? moment(date, "YYYY-MM-DD")
                        .subtract(1, 'days')
                        .format("YYYY-MM-DD HH:mm:ss")
                    : '';
            }
        },
        columns: [
            {
                data: 'full_name',
                render: function (lead) {
                    return `<a href="/leads/${lead.id}" class="text-decoration-none"><strong>${lead.name}</strong> <br>
                        <small class="text-muted">${lead.email}</small></a>`;
                }
            },
            {
                data: 'phone'
            },
            {
                data: 'source'
            },
            {
                data: 'status'
            },
            {
                data: 'created_at'
            },
            {
                data: 'user_id'
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
                                ${action.view ? `<li><a href="/leads/${action.id}" class="dropdown-item">View</a></li>` : ''}
                                ${action.edit ? `<li><a href="/leads/${action.id}/edit" class="dropdown-item">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a href="#" onclick="removeUser(this)" class="dropdown-item text-danger">Delete</a></li>` : ''}
                            </ul>
                        </div>
                    `;
                }
            },
        ]
    });

    // Trigger reload on filter changes
    $("#search, #status, #source, #date_range").on("change keyup", function () {
        crmTable.ajax.reload();
    });

    window.removeUser = function (model) {
        const rowData = crmTable.row($(model).closest('tr')).data();

        Swal.fire({
            title: "Are you sure?",
            html: `Remove <span class="fw-bolder text-primary">${rowData.full_name.full_name}</span>?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteUser(rowData.id);
            }
        });
    }

    const deleteUser = (user_id) => {
        $.ajax({
            url: `/user/${user_id}`,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            cache: false,
            beforeSend: function () {

            }
        }).done(function (response) {
            console.log(response);
            if(response.success === true)
            {
                crmTable.ajax.reload(null, false);
                Swal.fire({
                    title: "Deleted!",
                    text: response.message,
                    icon: "success"
                });
            }

        }).fail(function (xhr) {
            console.log(xhr)
            Swal.fire({
                title: "Error!",
                icon: "error"
            });
        }).always(function () {

        });
    }
});

