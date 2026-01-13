import axios from "axios";

const notificationDropdownElement = document.getElementById("notification-dropdown-menu");
const notificationCountElement = document.getElementById("notification-count");
const userIdElement = document.getElementById("app-user-id");
const userIdObserver = userIdElement.dataset.userId;
let notificationSound = null;

document.addEventListener("DOMContentLoaded", () => {

// User interaction unlocks audio
    document.addEventListener('click', unlockNotificationSound);
    document.addEventListener('keydown', unlockNotificationSound);

    getNotifications().then(r => {

    });

    if (!userIdObserver) return;

    Echo.private(`App.Models.User.${userIdObserver}`)
        .notification((notification) => {
            console.log('New notification:', notification);
            playNotificationSound()
            getNotifications().then(r => {

            });
        });
})

const unlockNotificationSound = () => {
    if (!notificationSound) {
        notificationSound = new Audio('/sounds/notification.mp3');
        notificationSound.volume = 0.7;
    }

    document.removeEventListener('click', unlockNotificationSound);
    document.removeEventListener('keydown', unlockNotificationSound);
}

const playNotificationSound = () => {
    if (!notificationSound) return;

    notificationSound.currentTime = 0;
    notificationSound.play().catch(() => {});
}


const formatNotificationType = (type) => {
    return type
        .replace(/_/g, ' ')
        .replace(/\b\w/g, char => char.toUpperCase());
};

const getNotifications = async () => {
    try {
        const { data: notifications } = await axios.get('/notifications');
        notificationDropdownElement.innerHTML = '';

        // 🔔 Notifications list
        if (notifications.unread_messages.length > 0) {
            notificationCountElement.innerText = notifications.unread_count;

            notifications.unread_messages.forEach(notification => {
                const item = document.createElement('li');
                item.id = `notification-item-${notification.id}`;
                item.classList.add('notification-item');

                const description = notification.data.description ?? 'View details';
                const type = notification.data.type ?? 'notification';

                item.innerHTML = `
                    <a class="dropdown-item small"
                       href="${notification.data.url}?notification=read&id=${notification.id}">
                        <div class="fw-semibold">
                            ${formatNotificationType(type)}
                        </div>
                        <small class="text-muted">
                            ${description}
                        </small>
                    </a>
                `;

                notificationDropdownElement.appendChild(item);
            });
        } else {
            // 💤 Empty state
            notificationDropdownElement.insertAdjacentHTML(
                'beforeend',
                `
                <li class="dropdown-item text-muted text-center small">
                    No notifications found
                </li>
                `
            );
        }

        // ➖ Divider (ALWAYS visible)
        notificationDropdownElement.insertAdjacentHTML(
            'beforeend',
            `<li><hr class="dropdown-divider"></li>`
        );

        // 🔗 View all notifications (ALWAYS visible)
        const viewAllUrl = notificationDropdownElement.dataset.viewAllUrl;

        notificationDropdownElement.insertAdjacentHTML(
            'beforeend',
            `
            <li>
                <a class="dropdown-item text-center small fw-semibold"
                   href="/all-notifications">
                    View all notifications
                </a>
            </li>
            `
        );

    } catch (error) {
        console.error('Failed to fetch notifications', error);
    }
};


export {notificationDropdownElement, formatNotificationType, getNotifications};

