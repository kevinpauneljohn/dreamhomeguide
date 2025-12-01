import "datatables.net-bs5";
import Swal from "sweetalert2";

const property_id = $('input[name=property_id]').val();
export const propertyImagesTable = $('#property-images-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: `/property/images/${property_id}/get`,
        type: 'GET',
    },
    columns: [
        {
            data: "file_name",
            orderable: false,
            render: function (image) {
                return `<img src="/storage/property_images/${image}" class="rounded" width="55" alt="${image}">`;
            }
        },
        { data: "title" },
        { data: "file_name" },
        {
            data: "is_thumbnail",
            render: function (thumbnail) {
                return thumbnail ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>';
            }
        },
        {
            data: "action",
            orderable: false,
            render: function (action) {
                return `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                ${action.edit ? `<li><button id="${action.id}" class="edit-image-button dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-image-modal">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a href="#" onclick="deleteProperty(${action.id})" class="dropdown-item text-danger">Delete</a></li>` : ''}

                            </ul>
                        </div>
                    `;
            }
        },
    ]
});


window.deleteProperty = function (property_image_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteImage(property_image_id);
        }
    });
}

const deleteImage = (property_image_id) => {
    $.ajax({
        url: `/property-images/${property_image_id}`,
        type: 'DELETE',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        beforeSend: function () {

        }
    }).done(function (response) {
        console.log(response);
        if(response.success === true)
        {
            propertyImagesTable.ajax.reload(null, false);
            Swal.fire({
                title: "Deleted!",
                text: response.message,
                icon: "success"
            });
        }else{
            Swal.fire({
                title: "Error!",
                text: response.message,
                icon: "error"
            });
        }

    }).fail(function (xhr) {
        console.log(xhr)
        return false;
    }).always(function () {

    });
}

