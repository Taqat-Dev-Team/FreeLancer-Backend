@php

    $user = auth('admin')->user();
    $notifications = auth('admin')->user()->notifications()->latest()->limit(10)->get()->map(function($notif){
    $notif->data = is_string($notif->data) ? json_decode($notif->data, true) : $notif->data;
    return $notif;
});
     $unreadCount = $user->unreadNotifications()->count();
@endphp


<audio id="notifSound" src="{{ url('notification.mp3') }}" preload="auto"></audio>


<div id="kt_app_header" class="app-header" data-kt-sticky="true"
     data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
     data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '0px', lg: '0px'}">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch flex-stack mt-lg-8"
         id="kt_app_header_container">
        <!--begin::Sidebar toggle-->
        <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-1"
                 id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
            <!--begin::Logo image-->
            <a href="{{route('home')}}">
                <img alt="Logo" src="{{$dark}}" class="h-65px theme-light-show"/>
                <img alt="Logo" src="{{$white}}" class="h-25px theme-dark-show"/>
            </a>
            <!--end::Logo image-->
        </div>
        <!--end::Sidebar toggle-->
        <!--begin::Navbar-->
        <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0"></div>

            <div class="app-navbar-item ms-3 ms-md-6">
                <!-- زر الإشعارات -->
                <div
                    class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-35px h-md-35px position-relative"
                    data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                    data-kt-menu-attach="parent"
                    data-kt-menu-placement="bottom-end"
                    id="notificationToggle">
                    <i class="ki-outline ki-notification-on fs-1"></i>
                    @if($unreadCount > 0)
                        <div
                            class="badge badge-circle badge-danger position-absolute translate-middle bottom-0 ms-10 mt-10 h-15px w-15px fs-9"
                            id="notificationCount">
                            {{ $unreadCount }}
                        </div>
                    @endif
                </div>

                <!-- قائمة الإشعارات -->
                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true"
                     id="kt_menu_notifications" style="display:none;">
                    <div class="d-flex flex-column bgi-no-repeat rounded-top"
                         style="background-image:url({{url('admin/assets/media/misc/menu-header-bg.jpg')}})">
                        <h3 class=" fw-semibold px-9 mt-10 mb-6">Notifications</h3>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                            <div class="scroll-y mh-325px my-5 px-8" id="notificationsList">
                                @forelse($notifications as $notification)
                                    <div
                                        class="d-flex flex-stack py-4 notification-item {{ $notification->read_at ? '' : 'bg-light-primary' }} p-5 rounded mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-4">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="ki-outline ki-notification-on fs-2 text-primary"></i>
                                        </span>
                                            </div>
                                            <div class="mb-0 me-2">
                                                <a href="{{ $notification->data['url'] ?? '#' }}"
                                                   class="fs-6 text-gray-800 text-hover-primary fw-bold">
                                                    {{ $notification->data['title'] ?? 'Not title' }}
                                                </a>
                                                <div
                                                    class="text-gray-500 fs-7">{{ $notification->data['message'] }}</div>
                                            </div>
                                        </div>
                                        <span class="badge badge-light fs-8">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">There are no new notifications.</p>
                                @endforelse
                            </div>
                            <div class="py-3 text-center border-top">
                                <a href="#"
                                   class="btn btn-color-gray-600 btn-active-color-primary">See All Notifications
                                    <i class="ki-outline ki-arrow-right fs-5"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end::Navbar-->
    </div>
    <!--end::Header container-->
</div>
