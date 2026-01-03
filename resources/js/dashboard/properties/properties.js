import "datatables.net-bs5";
import Swal from "sweetalert2";

$(function () {
    const propertyTable = $('#properties-table').DataTable({
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
                orderable: false,
                render: function (data) {
                    return `${data.with_images && data.with_thumbnail ? `<img src="/storage/property_images/${data.thumbnail.file_name}" class="rounded" width="55" alt="">` : ``}`;
                }
            },
            { data: "title" },
            { data: "location" },
            { data: "images_count", render: function (count) {
                const bgColor = count > 0 ? 'text-bg-success' : 'text-bg-secondary';
                    return `<span class="badge ${bgColor}">${count} Images</span>`;
                }
            },
            { data: "property_type",
            render: function (type) {
                const colors = {
                    sale: "primary",
                    rent: "success",
                    preselling: "warning",
                };

                const label = {
                    sale: "For Sale",
                    rent: "For Rent",
                    preselling: "Pre-Selling",
                };

                return `<span class="badge bg-${colors[type] ?? 'secondary'}">${label[type].toUpperCase()}</span>`;
                }
            },
            {
                data: "price",
                render: data => `₱ ${parseFloat(data).toLocaleString()}`
            },
            {
                data: "is_featured",
                render: function (is_featured) {
                    const colors = is_featured ? 'text-bg-success' : 'text-bg-secondary';
                    return `<span class="badge ${colors}">${is_featured ? 'Yes' : 'No'}</span>`;
                }
            },
            {
                data: "status",
                render: function (status) {
                    const colors = {
                        active: "success",
                        sold: "danger",
                        reserved: "warning",
                        inactive: "secondary"
                    };
                    return `<span class="badge bg-${colors[status] ?? 'secondary'}">${status.toUpperCase()}</span>`;
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
                                ${action.view ? `<li><a href="/property/${action.id}" class="dropdown-item">View</a></li>` : ''}
                                ${action.edit ? `<li><a href="/property/${action.id}/edit" class="dropdown-item">Edit</a></li>` : ''}
                                ${action.delete ? `<li><a href="#" onclick="deleteProperty(this, ${action.id})" class="dropdown-item text-danger">Delete</a></li>` : ''}
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="#" class="dropdown-item copy-landing-url" data-url="/landing-page/properties/${action.slug}">View landing Page</a></li>
                                ${action.upload_images ? `<li><a href="/property/images/${action.id}" class="dropdown-item"><i class="bi-card-image"></i> Upload Images</a></li>` : ''}
                            </ul>
                        </div>
                    `;
                }
            },
        ]
    });

    document.addEventListener('click', function (e) {
        const target = e.target.closest('.copy-landing-url');
        if (!target) return;

        e.preventDefault();

        const url = target.dataset.url;
        const fullUrl = `${window.location.origin}${url}`;

        navigator.clipboard.writeText(fullUrl)
            .then(() => {
                // ✅ Success feedback
                if (window.Toast) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Landing page URL copied!'
                    });
                } else {
                    alert('Landing page URL copied!');
                }
            })
            .catch(err => {
                console.error('Failed to copy:', err);
                alert('Failed to copy URL');
            });
    });

    $("#search, #category, #listingType, #status").on("change keyup", function () {
        propertyTable.ajax.reload();
    });

    window.deleteProperty = function (model, id) {
        const rowData = propertyTable.row($(model).closest('tr')).data();
        console.log(rowData.title);

        Swal.fire({
            title: "Are you sure?",
            html: `Delete <span class="fw-bolder text-primary">${rowData.title}</span>?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteProperty(id)
            }
        });
    }

    const deleteProperty = (property_id) => {
        $.ajax({
            url: `/property/${property_id}`,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            cache: false,
            beforeSend: function () {

            }
        }).done(function (response) {
            console.log(response);
            if(response.success === true)
            {
                propertyTable.ajax.reload(null, false);
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
});



