import Swal from "sweetalert2";
import axios from "axios";

const deleteButton = document.getElementById('delete-task-button');

if (deleteButton) {
    deleteButton.addEventListener('click', () => {
        deleteTask(
            deleteButton.dataset.id,
            deleteButton.dataset.title,
            deleteButton.dataset.ticket
        );
    });
}
export const deleteTask = (id, title, ticket) => {
    Swal.fire({
        title: `Delete task #${ticket}?`,
        text: `Title: ${title}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/task/${id}`)
                .then(response => {
                    console.log(response)
                    if(response.data.success === true)
                    {
                        const currentPath = window.location.pathname;

                        setTimeout(() => {
                            // If user is on /task/{id}, redirect
                            if (currentPath === `/task/${id}`) {
                                window.location.href = '/task';
                                return;
                            }
                        }, 2000)

                        Swal.fire('Deleted!', 'Task has been deleted.', 'success');
                        // 🔔 Notify table to reload
                        document.dispatchEvent(
                            new CustomEvent('task:deleted')
                        );
                    }
                }).catch(error => {
                console.log(error)
            })
        }
    })
}
