import "datatables.net-bs5";

import moment from "moment";
import Swal from "sweetalert2";

$(function () {
    const blogsTable = $('#blogs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/get-blogs",
            type: 'GET',
            data: function (d) {
                d.search = $('#search').val();
                d.category = $('#category').val();
                d.status = $('#status').val();
            }

        },
        columns: [
            {
                data: "thumbnail",
                orderable: false,
                render: function (thumbnail) {
                    return `<img src="${thumbnail !== null ? `/storage/blogs/${thumbnail}` : `#`}" class="rounded" width="55" alt="">`;
                }
            },
            {
                data: 'title'
            },
            {
                data: 'user_id'
            },
            {
                data: 'category'
            },
            {
                data: 'status',
                render: function (status) {
                    return `<span class="badge ${status.class}">${status.label}</span>`;
                }
            },
            {
                data: 'updated_at'
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
                                ${action.view ? `<li><a href="/blog/${action.id}" class="dropdown-item">View</a></li>` : ''}
                                ${action.edit ? `<li><a href="/blog/${action.id}/edit" class="dropdown-item">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a href="#" onclick="removeUser(this)" class="dropdown-item text-danger">Delete</a></li>` : ''}
                            </ul>
                        </div>
                    `;
                }
            },
        ]
    })

    $("#search, #category, #status").on("change keyup", function () {
        blogsTable.ajax.reload();
    });
});
