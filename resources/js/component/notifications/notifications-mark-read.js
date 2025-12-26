import axios from "axios";
import {getNotifications} from "@/component/notifications/get-notifications.js";

const notificationElement = document.getElementById('notification-getter');
const notificationId = notificationElement.dataset.notificationId;
const notificationCount = document.getElementById('notification-count');
const url = new URL(window.location.href);

document.addEventListener('DOMContentLoaded', () => {
    notificationsMarkRead(notificationId).then(r => {

        url.searchParams.delete('notification');
        url.searchParams.delete('id');

        window.history.pushState({}, '', url.toString());
    });
})


const notificationsMarkRead = async (notificationId) => {
    try {
        const { data } = await axios.post('/notifications/mark-read', {
            id: notificationId,
        });

        if (data.success) {
            getNotifications()
                .then(r => {
                    notificationCount.innerText = data.unread_count;
                })
                .then(r => {
                    if(data.unread_count === 0)
                    {
                        notificationCount.innerText = '';
                    }
                })

        }
    } catch (error) {
        console.error(error);
    }
};
