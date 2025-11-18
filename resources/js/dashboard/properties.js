import "datatables.net-bs5";

$(function () {
    const table = $('#properties-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/properties",
            type: 'GET',
            data: function (d) {
                d.search = $('#search').val();
                d.category = $('#category').val();
                d.listingType = $('#listingType').val();
                d.status = $('#status').val();
            }
        },
        columns: [
            {
                data: "thumbnail",
                render: function (data) {
                    // return `<img src="${data}" class="rounded" width="55" alt="">`;
                    return `<img src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260" class="rounded" width="55" alt="">`;
                }
            },
            { data: "title" },
            { data: "address" },
            { data: "type" },
            {
                data: "price",
                render: data => `₱ ${parseFloat(data).toLocaleString()}`
            },
            {
                data: "status",
                render: function (status) {
                    const colors = {
                        Active: "success",
                        Sold: "danger",
                        Reserved: "warning",
                        inactive: "secondary"
                    };
                    return `<span class="badge bg-${colors[status] ?? 'secondary'}">${status.toUpperCase()}</span>`;
                }
            },
            {
                data: "id",
                orderable: false,
                render: function (id) {
                    return `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="/property/${id}" class="dropdown-item">View</a></li>
                                <li><a href="/dashboard/properties/${id}/edit" class="dropdown-item">Edit</a></li>
                                <li><a href="#" onclick="deleteProperty(${id})" class="dropdown-item text-danger">Delete</a></li>
                            </ul>
                        </div>
                    `;
                }
            },
        ]
    });

    $("#search, #category, #listingType, #status").on("change keyup", function () {
        table.ajax.reload();
    });
});

window.deleteProperty = function (id) {
    if (confirm("Are you sure you want to delete this property?")) {
        alert("Delete function here...");
    }
}
