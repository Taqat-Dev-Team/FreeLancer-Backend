import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false
});

// اشعارات الادمن
document.addEventListener('DOMContentLoaded', () => {
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationsMenu = document.getElementById('kt_menu_notifications');
    const audio = document.getElementById('notifSound');

    notificationToggle.addEventListener('click', () => {
        notificationsMenu.style.display = (notificationsMenu.style.display === 'block') ? 'none' : 'block';
    });

    window.Echo.channel('admin-notifications')
        .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
            console.log('🔔 New BroadcastNotificationCreated:', e);

            // تشغيل الصوت
            const audio = document.getElementById('notifSound');
            if (audio) {
                audio.play().catch(err => console.warn('🔇 Sound play blocked', err));
            }

            // تحديث العداد
            let badge = document.getElementById('notificationCount');
            if (badge) {
                badge.innerText = parseInt(badge.innerText) + 1;
            } else {
                badge = document.createElement('div');
                badge.id = 'notificationCount';
                badge.className = 'badge badge-circle badge-danger position-absolute translate-middle bottom-0 ms-10 mt-10 h-15px w-15px fs-9';
                badge.innerText = '1';
                document.getElementById('notificationToggle').appendChild(badge);
            }

            // الحصول على البيانات من الحدث
            // البيانات تكون في e أو e.data أو e.notification حسب إعداد Laravel
            const notificationData = e.data || e.notification || e;

            // إضافة الإشعار للقائمة
            const notificationsList = document.getElementById('notificationsList');
            const newNotificationHTML = `
        <div class="d-flex flex-stack py-4 notification-item bg-light-primary p-5 rounded mb-3">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-35px me-4">
                    <span class="symbol-label bg-light-primary">
                      <i class="ki-outline ki-notification-on fs-2 text-primary"></i>
                    </span>
                </div>
                <div class="mb-0 me-2">
                    <a href="${notificationData.url || '#'}" class="fs-6 text-gray-800 text-hover-primary fw-bold">
                        ${notificationData.title || 'عنوان غير محدد'}
                    </a>
                    <div class="text-gray-500 fs-7">${notificationData.message || 'رسالة غير محددة'}</div>
                </div>
            </div>
            <span class="badge badge-light fs-8">Now</span>
        </div>`;

            if (notificationsList) {
                notificationsList.insertAdjacentHTML('afterbegin', newNotificationHTML);
            }
        });
});
