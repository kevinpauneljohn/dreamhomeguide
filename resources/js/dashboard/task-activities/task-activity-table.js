
const taskId = document.getElementById('task-data').dataset.taskId;

document.addEventListener('DOMContentLoaded', () => {
    getTaskActivities()
})


const getTaskActivities = () => {
    axios.get(`/get-task-activities/${taskId}`)
        .then(response => {
            document.getElementById('task-activity-list').innerHTML = response.data;
        });

}

export {getTaskActivities}
