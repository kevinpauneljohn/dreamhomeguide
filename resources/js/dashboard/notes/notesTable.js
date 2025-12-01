import Swal from "sweetalert2";

export const lead_id = $('input[name=lead_id]').val();
export const notesTable = $('#notes-table').DataTable({
    processing: true,
    serverSide: true,
    lengthChange: false,
    // order: [[2, 'desc']],
    ajax: {
        url: "/get-notes/lead/"+lead_id,
        type: 'GET',
    },
    columns: [
        {
            data: 'icon',
            render: function (icon) {
                return `<i class="${icon['icon']}" style="color:${icon.icon_color}; font-size: 1.2rem;"></i>`;
            }
        },
        {
            data: 'title',
            render: function (note) {
                return `<h6 class="fw-bold mb-1">${note.type}</h6>
                            <p class="note-text mb-0 text-muted">
                                ${note.description}
                            </p>`;
            }
        },
        {
            data: 'created_at',
            render: function(created_at){
                return `<small class="text-muted">${created_at}</small>`;
            }
        },
        {
            data: 'user_id',
            render: function(user_id){
                return `<small><strong>${user_id}</strong></small>`;
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
                                ${action.edit ? `<li><button id="${action.id}" class="edit-note-btn dropdown-item">Edit</button></li>` : ''}
                                ${action.delete ? `<li><button onclick="removeNote(this)" class="dropdown-item text-danger">Delete</button></li>` : ''}
                            </ul>
                        </div>
                    `;
            }
        },
    ]
});
// $(function() {
//
// });

window.removeNote = function (model) {
    const rowData = notesTable.row($(model).closest('tr')).data();
    console.log(rowData);
    Swal.fire({
        title: "Are you sure?",
        html: `Remove <span class="fw-bolder text-primary">${rowData.title.type}</span> note?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteNote(rowData.id);
        }
    });
}

const deleteNote = (note_id) => {
    $.ajax({
        url: `/note/${note_id}`,
        type: 'DELETE',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {

        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            notesTable.ajax.reload(null, false);
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
