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
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Summary-->
                            <!--begin::User Info-->
                            <div class="d-flex flex-center flex-column py-5">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    <img src="{{$freelancer->user->getImageUrl()}}" alt="image">
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Name-->
                                <a href="#"
                                   class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{Str::upper($freelancer->user->name)}}</a></a>
                                <!--end::Name-->
                                <!--begin::Position-->
                                <div class="mb-9">
                                    <!--begin::Badge-->
                                    <div
                                        class="badge badge-lg badge-light-primary d-inline mt-1">{{$freelancer->category->name}}</div>
                                    <!--begin::Badge-->
                                </div>
                                <!--end::Position-->
                                <!--begin::Info-->
                                <!--begin::Info heading-->
                                <div class="fw-bold mb-3">Assigned Badges
                                    <span class="ms-2">
                                    </span></div>
                                <!--end::Info heading-->
                                <div class="d-flex flex-wrap flex-center">
                                    @forelse($freelancer->badges as $badge)

                                        <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3 m-2 ">
                                            <div class="fs-4 fw-bold text-gray-700 justify-content-center text-center">
                                                <span class="w-75px">{{$badge->title}}</span>
                                                {{--                                                    <i class="ki-outline ki-arrow-up fs-3 text-success"></i>--}}
                                                <img src="{{$badge->getImageUrl() }}"
                                                     class="w-20px h-20px rounded-circle ">
                                            </div>
                                            <div class="fw-semibold text-muted">{{$badge->name}}</div>
                                        </div>

                                    @empty
                                        None
                                    @endforelse


                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User Info-->
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                     href="#kt_user_view_details" role="button" aria-expanded="false"
                                     aria-controls="kt_user_view_details">Details
                                    <span class="ms-2 rotate-180">
															<i class="ki-outline ki-down fs-3"></i>
                                    </span></div>

                            </div>
                            <!--end::Details toggle-->
                            <div class="separator"></div>
                            <!--begin::Details content-->
                            <div id="kt_user_view_details" class="collapse show">
                                <div class="pb-5 fs-6">
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Nationality ID</div>
                                    <div
                                        class="text-gray-600">{{$freelancer->identityVerification?->id_number??'-'}}</div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Email</div>
                                    <div class="text-gray-600">
                                        <a href="#"
                                           class="text-gray-600 text-hover-primary">{{$freelancer->user->email}}</a>
                                    </div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Address</div>
                                    <div class="text-gray-600 mb-2">
                                        {{$freelancer->user->country->name}}<br>
                                        <img src="{{$freelancer->user->country->flag}}"
                                             class="w-20px h-20px rounded-circle"
                                             alt="Flag"> {{$freelancer->user->country->number_code . $freelancer->user->mobile}}

                                    </div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Languages</div>
                                    @foreach($freelancer->languages as $lang)
                                        <div class="text-gray-600">{{$lang->name}}</div>
                                    @endforeach
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Joined Date</div>
                                    <div
                                        class="text-gray-600">{{$freelancer->created_at->format('d M, Y') . ' , ' . $freelancer->created_at->diffForHumans()}}</div>
                                    <!--begin::Details item-->
                                </div>
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Connected Accounts-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h3 class="fw-bold m-0">Socials Accounts</h3>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-2">

                            @forelse($freelancer->socialLinks as $social)
                                <!--begin::Items-->
                                <div class="py-2">

                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack">
                                        <div class="d-flex">
                                            @if($social?->social?->icon)
                                                {!! $social->social->icon !!}
                                            @else

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
                                                <a href="#"
                                                   class="fs-5 text-gray-900 text-hover-primary fw-bold">{{$social?->social->name??$social->title}}</a>

                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <!--begin::Switch-->
                                            <a target="_blank" title="view" href="{{$social->link}}"><i
                                                    class="ki-outline ki-eye 2 fs-2 "></i></a>
                                            <!--end::Switch-->
                                        </div>
                                    </div>
                                    <!--end::Item-->
                                    <div class="separator separator-dashed my-5"></div>

                                </div>
                            @empty
                                <div class="fw-bold mb-3 mx-10"> None</div>
                            @endforelse


                            <!--end::Items-->
                        </div>
                        <!--end::Card body-->

                    </div>
                    <!--end::Connected Accounts-->
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

                        <li class="nav-item ms-auto">
                            <!--begin::Action menu-->
                            <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click"
                               data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions
                                <i class="ki-outline ki-down fs-2 me-0"></i></a>
                            <!--begin::Menu-->
                            <div
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Payments
                                    </div>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="#" class="menu-link px-5">Create invoice</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="#" class="menu-link flex-stack px-5">Create payments
                                        <span class="ms-2" data-bs-toggle="tooltip"
                                              aria-label="Specify a target name for future usage and reference"
                                              data-bs-original-title="Specify a target name for future usage and reference"
                                              data-kt-initialized="1">
																<i class="ki-outline ki-information fs-7"></i>
															</span></a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="hover"
                                     data-kt-menu-placement="left-start">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title">Subscription</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-5">Apps</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-5">Billing</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-5">Statements</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3">
                                                <label
                                                    class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input w-30px h-20px" type="checkbox"
                                                           value="" name="notifications" checked="checked"
                                                           id="kt_user_menu_notifications">
                                                    <span class="form-check-label text-muted fs-6"
                                                          for="kt_user_menu_notifications">Notifications</span>
                                                </label>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator my-3"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Account</div>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="#" class="menu-link px-5">Reports</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5 my-1">
                                    <a href="#" class="menu-link px-5">Account Settings</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="#" class="menu-link text-danger px-5">Delete customer</a>
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
                        <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">

                            <div class="card card-flush mb-6 mb-xl-9">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <h3 class="card-title align-items-start flex-column">
                                        <span
                                            class="card-label fw-bold text-gray-900">Availability </span>
                                        <span
                                            class="text-gray-500 mt-1 fw-semibold fs-6">Availability To Hire</span>
                                    </h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        @if($freelancer->admin_available_hire)
                                            <a href="#"
                                               class="btn btn-light-warning w-100 toggle-admin-availability-deactivate"
                                               data-id="5">
                                                <i class="ki-solid ki-cross fs-1 me-2"></i>
                                                Deactivate Availability
                                            </a>
                                        @else
                                            <a href="#"
                                               class="btn btn-light-primary w-100 toggle-admin-availability-active"
                                               data-id="5">
                                                <i class="ki-solid ki-check fs-1 me-2"></i>
                                                Activate Availability
                                            </a>
                                        @endif
                                        <!--begin::Label-->

                                        <!--end::Label-->
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-6">
                                    <!--begin::Row-->
                                    <div class="row align-items-center mx-0 w-100">
                                        <!--begin::Col-->

                                        <div class="col-7 px-0">
                                            <!--begin::Labels-->
                                            <div class="d-flex flex-column content-justify-center">
                                                <!--begin::Label-->
                                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                                    <!--begin::Bullet-->
                                                    <div
                                                        class="bullet {{ $freelancer->availability()==1 ? 'bg-success' : 'bg-warning' }} me-3"
                                                        style="border-radius: 3px;width: 12px;height: 12px"></div>
                                                    <div
                                                        class="fs-5 fw-bold text-gray-600 me-5">{{$freelancer->availability()==1 ? 'Available': 'Not Available'}}</div>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Stats-->
                                                <div class=" fw-bolder text-gray-700 text-start">
                                                    Available to
                                                    Hire: {{$freelancer->available_hire ? 'Yes' : 'No'}} <br>
                                                    Available form
                                                    Admin: {{$freelancer->admin_available_hire ? 'Yes' : 'No'}}
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Labels-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->

                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <div class="card card-flush mb-6 mb-xl-9">
                                <!--begin::Header-->
                                <div class="card-header border-0">
                                    <div class="card-title">
                                        <h2>Profile Status</h2>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-0">
                                    <div class="fs-5 fw-semibold text-gray-500 mb-4">Profile complete status progress
                                    </div>
                                    <!--begin::Left Section-->
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-between w-100 fs-4 fw-bold mb-3">
                                            <span>Percentage</span>
                                            <span>{{$freelancer->getProfileCompletionStatusAttribute()['percentage']}}%</span>
                                        </div>
                                        <div class="h-8px bg-light rounded mb-3">
                                            <div class="bg-success rounded h-8px" role="progressbar"
                                                 style="width: {{$freelancer->getProfileCompletionStatusAttribute()['percentage']}}%;"
                                                 aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div
                                            class="fw-semibold text-gray-600">{{$freelancer->getProfileCompletionStatusAttribute()['total_items'] - $freelancer->getProfileCompletionStatusAttribute()['completed_items'] }}
                                            Items are remaining
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap flex-stack mb-5">

                                        <!--begin::Row-->
                                        <div class="d-flex flex-wrap">
                                            <!--begin::Col-->

                                            @foreach($freelancer->getProfileCompletionStatusAttribute()['status'] as $item)
                                                <div
                                                    class="border border-dashed border-gray-300 w-250px rounded my-3 p-4 me-6">
                                                <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                    <span class="counted fs-4"
                                                          data-kt-initialized="1">{{$item['name']}}</span>
                                                  @if($item['is_completed'])
                                                        <i class="ki-outline ki-check fs-1 text-success"></i>
                                                    @else
                                                        <i class="ki-outline ki-cross fs-1 text-danger"></i>
                                                    @endif

                                                </span>
                                                    <span
                                                        class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">{{$item['description']}}</span>
                                                </div>
                                            @endforeach

                                            <!--end::Col-->

                                        </div>
                                        <!--end::Row-->

                                    </div>
                                    <!--end::Card body-->
                                </div>


                                <!--end::Left Section-->
                            </div>
                            <!--begin::Tasks-->
                            <div class="card card-flush mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header mt-6">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h2 class="mb-1">Educations</h2>
                                        <div class="fs-6 fw-semibold text-muted">
                                            Total {{$freelancer->educations->count()}}</div>
                                    </div>
                                    <!--end::Card title-->

                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex flex-column">
                                    @forelse($freelancer->educations as $edu)
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center position-relative mb-7">
                                            <!--begin::Label-->
                                            <div
                                                class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                            <!--end::Label-->
                                            <!--begin::Details-->
                                            <div class="fw-semibold ms-5">
                                                <a href="#"
                                                   class="fs-5 fw-bold text-gray-900 text-hover-primary">{{$edu->field_of_study}}</a>
                                                <!--begin::Info-->
                                                <div class="fs-7 text-muted">
                                                    {{$edu->start_date ? $edu->start_date->format('m-Y') : null}}
                                                    - {{$edu->end_date ? $edu->end_date->format('m-Y') : 'Present'}}
                                                </div>

                                                <div class="fs-7 text-muted">
                                                    {{ AcademicGrade()->firstWhere('id', (int)$edu->grade)['label'] }}
                                                </div>
                                                <a href="#">{{$edu->university}}</a></div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Menu-->


                                        <!--end::Menu-->

                                    @empty
                                        <div class="fw-bold mb-3 "> None</div>

                                    @endforelse
                                </div>
                                <!--end::Card body-->
                            </div>

                            <div class="card card-flush mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header mt-6">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h2 class="mb-1">Work Experience</h2>
                                        <div class="fs-6 fw-semibold text-muted">
                                            Total {{$freelancer->workExperiences->count()}}</div>
                                    </div>
                                    <!--end::Card title-->

                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex flex-column">
                                    @forelse($freelancer->workExperiences as $work)
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center position-relative mb-7">
                                            <!--begin::Label-->
                                            <div
                                                class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                            <!--end::Label-->
                                            <!--begin::Details-->
                                            <div class="fw-semibold ms-5">
                                                <a href="#"
                                                   class="fs-5 fw-bold text-gray-900 text-hover-primary">{{$work->title}}</a>
                                                <!--begin::Info-->
                                                <div class="fs-7 text-muted">
                                                    {{$work->start_date ? $work->start_date->format('m-Y') : null}}
                                                    - {{$work->end_date ? $work->end_date->format('m-Y') : 'Present'}}
                                                </div>

                                                <div class="fs-7 text-muted">
                                                    {{ $work->type }}
                                                </div>

                                                <a href="#">{{$work->company_name}} - {{$work->location}}</a></div>


                                            <!--end::Info-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Menu-->
                                        <div class="fs-7 text-muted">
                                            {{$work->description}}
                                        </div>

                                        <!--end::Menu-->

                                    @empty
                                        <div class="fw-bold mb-3 "> None</div>

                                    @endforelse
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Body-->
                        </div>

                        <div class="tab-pane fade " id="kt_user_view_summary_tab" role="tabpanel">

                            <div class="card card-flush mb-10">
                                <!--begin::Card header-->

                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Post content-->
                                    <div class="fs-6 fw-normal text-gray-700 mb-5">
                                     {{$freelancer->user->bio}}
                                    </div>
                                    <!--end::Post content-->
                                    <!--begin::Post media-->
                                    <!-- عنوان الصور -->
                                    <h3 class="mb-5">{{ $freelancer->images_title }}</h3>

                                    <div class="row g-7 h-250px h-md-375px">
                                        @foreach($freelancer->getImagesUrls() as $key => $image)
                                            @php
                                                $url = $image['url'];
                                            @endphp

                                            @if($key == 0)
                                                <!-- الصورة الأولى - تأخذ نصف العرض -->
                                                <div class="col-6">
                                                    <a class="d-block card-rounded overlay h-100"
                                                       data-fslightbox="lightbox-projects"
                                                       href="{{ $url }}">
                                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-100"
                                                             style="background-image:url('{{ $url }}')"></div>
                                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                            <i class="ki-outline ki-eye fs-3x text-white"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            @elseif($key == 1 || $key == 2)
                                                @if($key == 1)
                                                    <div class="col-6">
                                                        <div class="row g-7 h-250px h-md-375px">
                                                            @endif

                                                            <div class="col-lg-12">
                                                                <a class="d-block card-rounded overlay h-100"
                                                                   data-fslightbox="lightbox-projects"
                                                                   href="{{ $url }}">
                                                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-100"
                                                                         style="background-image:url('{{ $url }}')"></div>
                                                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                                        <i class="ki-outline ki-eye fs-3x text-white"></i>
                                                                    </div>
                                                                </a>
                                                            </div>

                                                            @if($key == 2)
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>




                                    <!--end::Post media-->
                                </div>


                                <!--end::Card body-->

                            </div>
                            <!--end::Body-->
                        </div>

                        <div class="card card-flush mb-10">
                            <!--begin::Card header-->
                            <div class="card-header pt-9">
                                <!--begin::Author-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                                        <div class="symbol-label fs-2 fw-semibold bg-light text-inverse-success">
                                            <i class="ki-outline ki-file-added fs-2x text-primary"></i>
                                        </div>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="flex-grow-1">
                                        <!--begin::Name-->
                                        <a href="#" class="text-gray-800 text-hover-primary fs-4 fw-bold">Finance Deprt - Annual Report</a>
                                        <!--end::Name-->
                                        <!--begin::Date-->
                                        <span class="text-gray-500 fw-semibold d-block">Yestarday at 5:06 PM</span>
                                        <!--end::Date-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Author-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Menu wrapper-->
                                    <div class="m-0">
                                        <!--begin::Menu toggle-->
                                        <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary me-n4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                            <i class="ki-outline ki-dots-square fs-1"></i>
                                        </button>
                                        <!--end::Menu toggle-->
                                        <!--begin::Menu 2-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mb-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Ticket</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Customer</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                                <!--begin::Menu item-->
                                                <a href="#" class="menu-link px-3">
                                                    <span class="menu-title">New Group</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--end::Menu item-->
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Admin Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Staff Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Member Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Contact</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mt-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content px-3 py-3">
                                                    <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 2-->
                                    </div>
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body">
                                <!--begin::Post content-->
                                <div class="fs-6 fw-normal text-gray-700 mb-5">You can either decide on your final headline before outstanding you write the most of the rest of your creative post</div>
                                <!--end::Post content-->
                                <!--begin::Video-->
                                <div class="m-0">
                                    <iframe class="embed-responsive-item rounded h-300px w-100" src="https://www.youtube.com/embed/TWdDZYNqlg4" allowfullscreen="allowfullscreen"></iframe>
                                </div>
                                <!--end::Video-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer pt-0">
                                <!--begin::Info-->
                                <div class="mb-6">
                                    <!--begin::Separator-->
                                    <div class="separator separator-solid"></div>
                                    <!--end::Separator-->
                                    <!--begin::Nav-->
                                    <ul class="nav py-3">
                                        <!--begin::Item-->
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-sm btn-color-gray-600 btn-active-color-primary btn-active-light-primary fw-bold px-4 me-1 collapsible" data-bs-toggle="collapse" href="#kt_social_feeds_comments_3">
                                                <i class="ki-outline ki-message-text-2 fs-2 me-1"></i>4 Comments</a>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="nav-item">
                                            <a href="#" class="nav-link btn btn-sm btn-color-gray-600 btn-active-color-primary fw-bold px-4 me-1">
                                                <i class="ki-outline ki-heart fs-2 me-1"></i>10k Likes</a>
                                        </li>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <li class="nav-item">
                                            <a href="#" class="nav-link btn btn-sm btn-color-gray-600 btn-active-color-primary fw-bold px-4">
                                                <i class="ki-outline ki-bookmark fs-2 me-1"></i>2 Saves</a>
                                        </li>
                                        <!--end::Item-->
                                    </ul>
                                    <!--end::Nav-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-solid mb-1"></div>
                                    <!--end::Separator-->
                                    <!--begin::Comments-->
                                    <div class="collapse" id="kt_social_feeds_comments_3">
                                        <!--begin::Comment-->
                                        <div class="d-flex pt-6">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-45px me-5">
                                                <img src="assets/media/avatars/300-13.jpg" alt="">
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column flex-row-fluid">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center flex-wrap mb-0">
                                                    <!--begin::Name-->
                                                    <a href="#" class="text-gray-800 text-hover-primary fw-bold me-6">Mr. Anderson</a>
                                                    <!--end::Name-->
                                                    <!--begin::Date-->
                                                    <span class="text-gray-500 fw-semibold fs-7 me-5">1 Day ago</span>
                                                    <!--end::Date-->
                                                    <!--begin::Reply-->
                                                    <a href="#" class="ms-auto text-gray-500 text-hover-primary fw-semibold fs-7">Reply</a>
                                                    <!--end::Reply-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Text-->
                                                <span class="text-gray-800 fs-7 fw-normal pt-1">Long before you sit dow to put digital pen to paper you need to make sure you have to sit down and write.</span>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Comment-->
                                        <!--begin::Comment-->
                                        <div class="d-flex pt-6">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-45px me-5">
                                                <img src="assets/media/avatars/300-2.jpg" alt="">
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column flex-row-fluid">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center flex-wrap mb-0">
                                                    <!--begin::Name-->
                                                    <a href="#" class="text-gray-800 text-hover-primary fw-bold me-6">Mrs. Anderson</a>
                                                    <!--end::Name-->
                                                    <!--begin::Date-->
                                                    <span class="text-gray-500 fw-semibold fs-7 me-5">2 Days ago</span>
                                                    <!--end::Date-->
                                                    <!--begin::Reply-->
                                                    <a href="#" class="ms-auto text-gray-500 text-hover-primary fw-semibold fs-7">Reply</a>
                                                    <!--end::Reply-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Text-->
                                                <span class="text-gray-800 fs-7 fw-normal pt-1">Long before you sit dow to put digital pen to paper</span>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Comment-->
                                        <!--begin::Comment-->
                                        <div class="d-flex pt-6">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-45px me-5">
                                                <img src="assets/media/avatars/300-20.jpg" alt="">
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column flex-row-fluid">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center flex-wrap mb-0">
                                                    <!--begin::Name-->
                                                    <a href="#" class="text-gray-800 text-hover-primary fw-bold me-6">Alice Danchik</a>
                                                    <!--end::Name-->
                                                    <!--begin::Date-->
                                                    <span class="text-gray-500 fw-semibold fs-7 me-5">3 Days ago</span>
                                                    <!--end::Date-->
                                                    <!--begin::Reply-->
                                                    <a href="#" class="ms-auto text-gray-500 text-hover-primary fw-semibold fs-7">Reply</a>
                                                    <!--end::Reply-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Text-->
                                                <span class="text-gray-800 fs-7 fw-normal pt-1">Long before you sit dow to put digital pen to paper you need to make sure you have to sit down and write.</span>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Comment-->
                                        <!--begin::Comment-->
                                        <div class="d-flex pt-6">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-45px me-5">
                                                <img src="assets/media/avatars/300-6.jpg" alt="">
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column flex-row-fluid">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center flex-wrap mb-0">
                                                    <!--begin::Name-->
                                                    <a href="#" class="text-gray-800 text-hover-primary fw-bold me-6">Grace Green</a>
                                                    <!--end::Name-->
                                                    <!--begin::Date-->
                                                    <span class="text-gray-500 fw-semibold fs-7 me-5">4 Days ago</span>
                                                    <!--end::Date-->
                                                    <!--begin::Reply-->
                                                    <a href="#" class="ms-auto text-gray-500 text-hover-primary fw-semibold fs-7">Reply</a>
                                                    <!--end::Reply-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Text-->
                                                <span class="text-gray-800 fs-7 fw-normal pt-1">Long before you sit dow to put digital pen to paper</span>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Comment-->
                                    </div>
                                    <!--end::Collapse-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Comment form-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Author-->
                                    <div class="symbol symbol-35px me-3">
                                        <img src="assets/media/avatars/300-3.jpg" alt="">
                                    </div>
                                    <!--end::Author-->
                                    <!--begin::Input group-->
                                    <div class="position-relative w-100">
                                        <!--begin::Input-->
                                        <textarea type="text" class="form-control form-control-solid border ps-5" rows="1" name="search" value="" data-kt-autosize="true" placeholder="Write your comment.." style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 44px;" data-kt-initialized="1"></textarea>
                                        <!--end::Input-->
                                        <!--begin::Actions-->
                                        <div class="position-absolute top-0 end-0 translate-middle-x mt-1 me-n14">
                                            <!--begin::Btn-->
                                            <button class="btn btn-icon btn-sm btn-color-gray-500 btn-active-color-primary w-25px p-0">
                                                <i class="ki-outline ki-paper-clip fs-2"></i>
                                            </button>
                                            <!--end::Btn-->
                                            <!--begin::Btn-->
                                            <button class="btn btn-icon btn-sm btn-color-gray-500 btn-active-color-primary w-25px p-0">
                                                <i class="ki-outline ki-like fs-2"></i>
                                            </button>
                                            <!--end::Btn-->
                                            <!--begin::Btn-->
                                            <button class="btn btn-icon btn-sm btn-color-gray-500 btn-active-color-primary w-25px p-0">
                                                <i class="ki-outline ki-badge fs-2"></i>
                                            </button>
                                            <!--end::Btn-->
                                            <!--begin::Btn-->
                                            <button class="btn btn-icon btn-sm btn-color-gray-500 btn-active-color-primary w-25px p-0">
                                                <i class="ki-outline ki-geolocation fs-2"></i>
                                            </button>
                                            <!--end::Btn-->
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Comment form-->
                            </div>
                            <!--end::Card footer-->
                        </div>

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

    @push('js')

        {{--     active   admin availability akax--}}
        <script>
            $(document).on('click', '.toggle-admin-availability-active', function (e) {
                e.preventDefault();

                let btn = $(this);
                let id = btn.data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to activate freelancer availability!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, activate!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'progressing...',
                            text: 'Please wait while we process your request.',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({

                            url: '/admin/freelancer/verified/admin-active/' + id,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function () {
                                btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                                btn.prop('disabled', true);
                            },
                            success: function (response) {
                                toastr.success(response.message);
                                // Refresh the DataTable row or whole table
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', xhr.responseJSON.message, 'error');
                            },

                            complete: function () {
                                Swal.close();
                                btn.prop('disabled', true);
                            }

                        });
                    }
                });
            });
        </script>

        {{--        deactivate admin availability ajax--}}
        <script>
            $(document).on('click', '.toggle-admin-availability-deactivate', function (e) {
                e.preventDefault();

                let btn = $(this);
                let id = btn.data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to activate freelancer availability!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, activate!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'progressing...',
                            text: 'Please wait while we process your request.',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/admin/freelancer/verified/admin-deactivate/' + id,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function () {
                                btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                                btn.prop('disabled', true);
                            },
                            success: function (response) {
                                toastr.success(response.message);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', xhr.responseJSON.message, 'error');
                            },
                            complete: function () {
                                Swal.close();
                                btn.prop('disabled', true);
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@stop
