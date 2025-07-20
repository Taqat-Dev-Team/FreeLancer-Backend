@extends('admin.layouts.master', ['title' => 'Clients'])


@section('toolbarTitle', 'Client details')
@section('toolbarSubTitle','Clients')
@section('toolbarPage', Str::upper($client->user->name))
{{--    @section('toolbarActions')--}}
{{--        <div class="d-flex align-items-center gap-2 gap-lg-3">--}}
{{--            <a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal"--}}
{{--               data-bs-target="#addBadgeModal"><i class="ki-outline ki-plus"></i> Add Badge</a>--}}

{{--        </div>--}}
{{--    @stop--}}

@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Sidebar-->
                @php
                    $user = $client->user;
                    $country = $user->country;
                @endphp

                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-5 mb-xl-8">
                        <div class="card-body">
                            <div class="d-flex flex-center flex-column py-5">
                                <!-- صورة المستخدم -->
                                <div class="symbol symbol-80px symbol-lg-150px mb-4">
                                    <img src="{{ $user->getImageUrl() }}" alt="image">
                                </div>

                                <!-- الاسم -->
                                <a href="#"
                                   class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ Str::upper($user->name) }}</a>
                            </div>
                            <!-- التفاصيل -->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                     href="#kt_user_view_details" role="button" aria-expanded="false"
                                     aria-controls="kt_user_view_details">
                                    Details
                                    <span class="ms-2 rotate-180"><i class="ki-outline ki-down fs-3"></i></span>
                                </div>
                            </div>
                            <div class="separator"></div>

                            <div id="kt_user_view_details" class="collapse show">
                                <div class="pb-5 fs-6">


                                    <div class="fw-bold mt-5">Email</div>
                                    <div class="text-gray-600">
                                        <a href="#" class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                                    </div>

                                    <div class="fw-bold mt-5">Address</div>
                                    <div class="text-gray-600 mb-2">
                                        {{ $country?->name }}<br>
                                        <img src="{{ $country?->flag }}" class="w-20px h-20px rounded-circle">
                                        {{ $user->mobile }}
                                    </div>


                                    <div class="fw-bold mt-5">Joined Date</div>
                                    <div class="text-gray-600">
                                        {{ $client->created_at->format('d M, Y') . ' , ' . $client->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!--end::Sidebar-->


                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                        role="tablist">
                        <!--begin:::Tab item-->
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                               href="#kt_user_view_overview_tab" aria-selected="true" role="tab">Overview</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4  " data-bs-toggle="tab"
                               href="#kt_user_view_summary_tab" aria-selected="true" role="tab">Summary</a>
                        </li>


                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_projects_tab" aria-selected="true" role="tab">Projects</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_tickets_tab" aria-selected="true" role="tab">Tickets</a>
                        </li>

                        <li class="nav-item ms-auto">
                            <!--begin::Action menu-->
                            <a href="#" class="btn btn-light-primary ps-7" data-kt-menu-trigger="click"
                               data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions
                                <i class="ki-outline ki-down fs-2 me-0"></i></a>
                            <!--begin::Menu-->
                            <div
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                                data-kt-menu="true">
                                <!--begin::Menu item-->

                                <!--end::Menu item-->
                                <!--begin::Menu item-->


                                <div class="menu-item px-5">

                                    <a class="menu-link px-5 btn btn-active-light-info message-freelancer">Send
                                        Massage</a>

                                </div>

                                <div class="menu-item px-5">
                                    <a class="menu-link px-5 btn btn-active-light-warning status-freelancer">Change
                                        Status</a>
                                </div>


                                <!--end::Menu item-->
                                <!--begin::Menu item-->

                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator my-3"></div>

                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a class="menu-link px-5 btn btn-active-light-danger text-danger "
                                       onclick="deleteClient({{ $client->id }})">Delete
                                    </a>

                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                            <!--end::Menu-->
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->

                        @include('admin.Clients.tabs.over-view')
                        @include('admin.Clients.tabs.summary')



                        <!--end::Tasks-->

                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
    </div>
    <!--end::Content container-->

    @include('admin.Clients.js')
@stop
