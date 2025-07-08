<div class="tab-pane fade " id="kt_user_view_work_tab" role="tabpanel">


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
