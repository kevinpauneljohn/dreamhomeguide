import axios from "axios";

const notificationElement = document.getElementById('notification-getter');
const notificationId = notificationElement.dataset.notificationId;
const notificationCount = document.getElementById('notification-count');
const url = new URL(window.location.href);

document.addEventListener('DOMContentLoaded', () => {


    notifications(notificationId).then(r => {

        url.searchParams.delete('notification');
        url.searchParams.delete('id');

        window.history.pushState({}, '', url.toString());
    });
})


const notifications = async (notificationId) => {
    try {
        const { data } = await axios.post('/notifications', {
            id: notificationId,
        });

        if (data.success) {
            console.log(data);
            if(data.unread_count > 0)
            {
                notificationCount.innerText = data.unread_count;
            }else{
                notificationCount.remove()
            }
            document.getElementById(`notification-item-${notificationId}`).remove();
        }
    } catch (error) {
        console.error(error);
    }
};
