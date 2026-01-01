import "datatables.net-bs5";
import Swal from "sweetalert2";
import '../../../css/properties.css';

$(function () {
    const userTable = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/get-users",
            type: 'GET',
            data: function (d) {
                d.search = $('#search').val();
                d.status = $('#status').val();
                d.role = $('#role').val();
                d.sort = $('#sort').val();
            }
        },
        columns: [
            {
                data: "profile_photo",
                render: function (photo) {
                    return `${photo !== null ? `<img src="/storage/profile_pictures/${photo}" class="rounded-circle" width="50" height="50" alt="">` : `<small class="text-muted">No Photo</small>`}`;
                }
            },
            {
                data: "full_name",
                render: function (user) {
                    return `<strong>${user.full_name}</strong> <br>
                        <small class="text-muted">${user.email}</small>`;
                }
            },
            { data: "phone" },
            {
                data: "listings",
                className: "text-center",
                render: function (listings) {
                    return `<span class="text-primary fw-bold">${listings}</span>`;
                }
            },
            {
                data: "role",
                render: function (role) {
                    return `<span class="badge bg-primary">${role.toUpperCase()}</span>`;
                }
            },
            {
                data: "created_at",
                render: function(created_at){
                    return `<small class="text-muted">${created_at}</small>`;
                }
            },

            // Status badge
            {
                data: "status",
                render: function (status) {
                    const colors = {
                        active: "success",
                        inactive: "secondary",
                        pending: "warning"
                    };
                    return `<span class="badge bg-${colors[status]}">${status.toUpperCase()}</span>`;
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
                                ${action.view ? `<li><a href="/user/${action.id}" class="dropdown-item">View</a></li>` : ''}
                                ${action.edit ? `<li><a href="/user/${action.id}/edit" class="dropdown-item">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a href="#" onclick="removeUser(this)" class="dropdown-item text-danger">Delete</a></li>` : ''}
                            </ul>
                        </div>
                    `;
                }
            },

        ]
    });

    // Trigger reload on filter changes
    $("#search, #status, #role, #sort").on("change keyup", function () {
        userTable.ajax.reload();
    });

    window.removeUser = function (model) {
        const rowData = userTable.row($(model).closest('tr')).data();

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
                userTable.ajax.reload(null, false);
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


