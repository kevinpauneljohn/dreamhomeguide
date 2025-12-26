import axios from "axios";

const notificationDropdownElement = document.getElementById("notification-dropdown-menu");
const notificationCountElement = document.getElementById("notification-count");

document.addEventListener("DOMContentLoaded", () => {
    getNotifications().then(r => {

    });


    if (!window.Laravel || !window.Laravel.userId) return;

    console.log('test', window.Laravel.userId);

    Echo.private(`App.Models.User.${window.Laravel.userId}`)
        .notification((notification) => {
            console.log('New notification:', notification);

            getNotifications().then(r => {

            });
        });
})

const formatNotificationType = (type) => {
    return type
        .replace(/_/g, ' ')
        .replace(/\b\w/g, char => char.toUpperCase());
};

const getNotifications = async () => {
    try {
        const { data: notifications } = await axios.get('/notifications');

        // Clear dropdown properly
        notificationDropdownElement.innerHTML = '';

        if (notifications.unread_messages.length > 0) {
            notificationCountElement.innerText = notifications.unread_count;
            notifications.unread_messages.forEach(notification => {
                const item = document.createElement('li');
                item.id = `notification-item-${notification.id}`;
                item.classList.add('notification-item');

                item.innerHTML = `
                    <a class="dropdown-item small"
                       href="${notification.data.url}?notification=read&id=${notification.id}">
                        <div class="fw-semibold">${formatNotificationType(notification.data.type)}</div>
                        <small class="text-muted">${notification.data.description}</small>
                    </a>
                `;

                notificationDropdownElement.appendChild(item);
            });
        } else {
            notificationDropdownElement.innerHTML = `
                <li class="dropdown-item text-muted text-center small">
                    No notifications found
                </li>
            `;
        }

    } catch (error) {
        console.error('Failed to fetch notifications', error);
    }
};

export {notificationDropdownElement, formatNotificationType, getNotifications};

