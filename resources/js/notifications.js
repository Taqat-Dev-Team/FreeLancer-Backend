import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false
});

// إضافة CSS للاهتزاز
const shakeCSS = `
<style>
@keyframes shake {
    0% { transform: translate(1px, 1px) rotate(0deg); }
    10% { transform: translate(-1px, -2px) rotate(-1deg); }
    20% { transform: translate(-3px, 0px) rotate(1deg); }
    30% { transform: translate(3px, 2px) rotate(0deg); }
    40% { transform: translate(1px, -1px) rotate(1deg); }
    50% { transform: translate(-1px, 2px) rotate(-1deg); }
    60% { transform: translate(-3px, 1px) rotate(0deg); }
    70% { transform: translate(3px, 1px) rotate(-1deg); }
    80% { transform: translate(-1px, -1px) rotate(1deg); }
    90% { transform: translate(1px, 2px) rotate(0deg); }
    100% { transform: translate(1px, -2px) rotate(-1deg); }
}

.shake-bell {
    animation: shake 0.8s;
    animation-iteration-count: 2;
}

.pulse-badge {
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>`;

// إضافة الـ CSS للصفحة
document.head.insertAdjacentHTML('beforeend', shakeCSS);

// اشعارات الادمن
document.addEventListener('DOMContentLoaded', () => {
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationsMenu = document.getElementById('kt_menu_notifications');

    notificationToggle.addEventListener('click', () => {
        notificationsMenu.style.display = (notificationsMenu.style.display === 'block') ? 'none' : 'block';
    });

    // دالة الاهتزاز
    function shakeNotificationBell() {
        const bellIcon = notificationToggle.querySelector('i');
        if (bellIcon) {
            bellIcon.classList.add('shake-bell');
            setTimeout(() => bellIcon.classList.remove('shake-bell'), 1600);
        }
    }

    window.Echo.channel('admin-notifications')
        .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
            // console.log('📡 إشعار جديد:', e);
            const data = e.data || e.notification || e;

            // تشغيل الصوت
            const audio = document.getElementById('notifSound');
            if (audio) audio.play().catch(() => {
            });

            // اهتزاز الجرس
            shakeNotificationBell();

            // تحديث العداد
            let badge = document.getElementById('notificationCount');
            if (badge) {
                badge.textContent = parseInt(badge.textContent || 0) + 1;
                badge.classList.add('pulse-badge');
                setTimeout(() => badge.classList.remove('pulse-badge'), 2000);
            } else {
                badge = document.createElement('div');
                badge.id = 'notificationCount';
                badge.className = 'badge badge-circle badge-danger position-absolute translate-middle bottom-0 ms-10 mt-10 h-15px w-15px fs-9 pulse-badge';
                badge.innerText = '1';
                document.getElementById('notificationToggle').appendChild(badge);
                setTimeout(() => badge.classList.remove('pulse-badge'), 2000);
            }

            // إضافة الإشعار للقائمة مع data-id
            const notificationsList = document.getElementById('notificationsList');
            const html = `
<div class="d-flex flex-stack py-4 notification-item bg-light-primary p-5 rounded mb-3" data-id="${data.id}">
    <div class="d-flex align-items-center">
        <div class="symbol symbol-35px me-4">
            <span class="symbol-label bg-light-primary">
                <i class="ki-outline ki-notification-on fs-2 text-primary"></i>
            </span>
        </div>
        <div class="mb-0 me-2">
            <a href="${data.url ? data.url : `/admin/notifications/read/${data.id}`}" class="fs-6 text-gray-800 text-hover-primary fw-bold">
                ${data.title || 'عنوان غير محدد'}
            </a>
            <div class="text-gray-500 fs-7">${data.message || 'رسالة غير محددة'}</div>
        </div>
    </div>
    <span class="badge badge-light fs-8">الآن</span>
</div>`;
            notificationsList?.insertAdjacentHTML('afterbegin', html);

            // إشعار المتصفح
            if (document.hidden && 'Notification' in window && Notification.permission === 'granted') {
                new Notification(data.title || 'إشعار جديد', {
                    body: data.message || 'لديك إشعار جديد',
                    icon: '/path/to/notification-icon.png',
                });
            }
        });

    // التعامل مع الضغط على رابط الإشعار لقراءة الإشعار ثم التوجيه
    document.getElementById('notificationsList').addEventListener('click', function (e) {
        const link = e.target.closest('.notification-item a');
        if (!link) return;

        e.preventDefault();

        const notificationItem = link.closest('.notification-item');
        if (!notificationItem) return;

        const notificationId = notificationItem.dataset.id;
        const redirectUrl = link.href;

        // حماية من الضغط المتكرر
        if (notificationItem.dataset.processing === 'true') return;
        notificationItem.dataset.processing = 'true';

        fetch(`/admin/notifications/read/${notificationId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
            .then(res => res.json())
            .then(data => {
                // توجيه للرابط سواء نجح أو لا
                window.location.href = redirectUrl;
            })
            .catch(() => {
                window.location.href = redirectUrl;
            })
            .finally(() => {
                notificationItem.dataset.processing = 'false';
            });
    });

    // طلب إذن الإشعارات من المتصفح
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
});
