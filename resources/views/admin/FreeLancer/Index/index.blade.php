@extends('admin.layouts.master', ['title' => 'Freelancers'])


@section('toolbarTitle', 'Freelancer details')
@section('toolbarSubTitle','Freelancers')
@section('toolbarPage', Str::upper($freelancer->user->name))
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
                    $user = $freelancer->user;
                    $country = $user->country;
                    $badges = $freelancer->badges;
                    $socialLinks = $freelancer->socialLinks;
                    $languages = $freelancer->languages;
                    $category = $freelancer->category;
                    $identityVerification = $freelancer->identityVerification;
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

                                <!-- التصنيف -->
                                <div class="mb-9">
                                    <div class="fw-bold">Experience <span class="badge badge-light-info ms-2">
                                      {{ $freelancer->experience ?? 'N/A' }}
                                    </span>
                                    </div>
                                </div>

                                <div
                                    class="badge badge-lg badge-light-primary d-inline mt-1">{{ $category?->name ?? 'none' }}</div>

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
                                    <div class="fw-bold mt-5">Nationality ID</div>
                                    <div class="text-gray-600">{{ $identityVerification?->id_number ?? '-' }}</div>

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

                                    <div class="fw-bold mt-5">Languages</div>
                                    @forelse($languages as $lang)
                                        <div class="text-gray-600">{{ $lang->name }}</div>
                                    @empty
                                        <div class="text-muted">None</div>
                                    @endforelse

                                    <div class="fw-bold mt-5">Joined Date</div>
                                    <div class="text-gray-600">
                                        {{ $freelancer->created_at->format('d M, Y') . ' , ' . $freelancer->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- حسابات التواصل -->
                    <div class="card mb-5 mb-xl-8">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h3 class="fw-bold m-0">Socials Accounts</h3>
                            </div>
                        </div>
                        <div class="card-body pt-2">
                            @forelse($socialLinks as $social)
                                <div class="py-2">
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex">
                                            @if($social?->social?->icon)
                                                {!! $social->social->icon !!}
                                            @else
                                                {{-- Default Icon --}}
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.99935 18.3334C14.6017 18.3334 18.3327 14.6025 18.3327 10.0001C18.3327 5.39771 14.6017 1.66675 9.99935 1.66675C5.39698 1.66675 1.66602 5.39771 1.66602 10.0001C1.66602 14.6025 5.39698 18.3334 9.99935 18.3334Z"
                                                        stroke="#696A70" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path
                                                        d="M6.66667 2.5H7.5C5.875 7.36667 5.875 12.6333 7.5 17.5H6.66667"
                                                        stroke="#696A70" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path d="M12.5 2.5C14.125 7.36667 14.125 12.6333 12.5 17.5"
                                                          stroke="#696A70" stroke-width="1.5" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                    <path
                                                        d="M2.5 13.3333V12.5C7.36667 14.125 12.6333 14.125 17.5 12.5V13.3333"
                                                        stroke="#696A70" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path d="M2.5 7.5C7.36667 5.875 12.6333 5.875 17.5 7.5"
                                                          stroke="#696A70" stroke-width="1.5" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            @endif
                                            <div class="d-flex flex-column mx-2">
                                                <a href="#" class="fs-5 text-gray-900 text-hover-primary fw-bold">
                                                    {{ $social?->social->name ?? $social->title }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a target="_blank" title="view" href="{{ $social->link }}">
                                                <i class="ki-outline ki-eye 2 fs-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                </div>
                            @empty
                                <div class="fw-bold mb-3 mx-10">None</div>
                            @endforelse
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
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_summary_tab" aria-selected="true" role="tab">Summary</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_educations_tab" aria-selected="true" role="tab">Educations</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_work_tab" aria-selected="true" role="tab">Work Experience</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_id_tab" aria-selected="true" role="tab">Identity</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_badges_tab" aria-selected="true" role="tab">Badges</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                               href="#kt_user_view_services_tab" aria-selected="true" role="tab">Services</a>
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
                                @if($freelancer->review=='0')

                                    <div class="menu-item px-5">

                                        <a class="menu-link px-5 btn btn-active-light-success "
                                           onclick="ActionReview({{ $freelancer->id }},'1')">Approve Profile
                                        </a>

                                        <a class="menu-link px-5 btn btn-active-light-warning "
                                           onclick="ActionReview({{ $freelancer->id }},'2')">Reject Profile
                                        </a>

                                    </div>

                                @elseif($freelancer->review=='1')
                                    <div class="menu-item px-5">
                                    <a class="menu-link px-5 btn btn-active-light-warning "
                                       onclick="ActionReview({{ $freelancer->id }},'2')">Reject Profile
                                    </a>
                                    </div>
                                @else

                                    <div class="menu-item px-5">
                                    <a class="menu-link px-5 btn btn-active-light-success "
                                       onclick="ActionReview({{ $freelancer->id }},'1')">Approve Profile
                                    </a>
                                    </div>

                                @endif


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
                                       onclick="deleteFreelancer({{ $freelancer->id }})">Delete
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

                        @include('admin.FreeLancer.Index.Index-tabs.over-view')
                        @include('admin.FreeLancer.Index.Index-tabs.educations')
                        @include('admin.FreeLancer.Index.Index-tabs.work')
                        @include('admin.FreeLancer.Index.Index-tabs.summary')
                        @include('admin.FreeLancer.Index.Index-tabs.id')
                        @include('admin.FreeLancer.Index.Index-tabs.badges')


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

    @include('admin.FreeLancer.Index.js')
@stop
