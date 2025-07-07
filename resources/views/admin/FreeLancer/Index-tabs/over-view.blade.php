@php
    $profileCompletion = $freelancer->getProfileCompletionStatusAttribute();
@endphp

<div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">

    <!-- Availability Card -->
    <div class="card card-flush mb-6 mb-xl-9">
        <div class="card-header pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Availability </span>
                <span class="text-gray-500 mt-1 fw-semibold fs-6">Availability To Hire</span>
            </h3>
            <div class="card-toolbar">
                @if($freelancer->admin_available_hire)
                    <a href="#" class="btn btn-light-warning w-100 toggle-admin-availability-deactivate" data-id="5">
                        <i class="ki-solid ki-cross fs-1 me-2"></i> Deactivate Availability
                    </a>
                @else
                    <a href="#" class="btn btn-light-primary w-100 toggle-admin-availability-active" data-id="5">
                        <i class="ki-solid ki-check fs-1 me-2"></i> Activate Availability
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body d-flex align-items-end pt-6">
            <div class="row align-items-center mx-0 w-100">
                <div class="col-7 px-0">
                    <div class="d-flex flex-column content-justify-center">
                        <div class="d-flex fs-6 fw-semibold align-items-center">
                            <div class="bullet {{ $freelancer->availability() == 1 ? 'bg-success' : 'bg-warning' }} me-3"
                                 style="border-radius: 3px;width: 12px;height: 12px"></div>
                            <div class="fs-5 fw-bold text-gray-600 me-5">
                                {{ $freelancer->availability() == 1 ? 'Available' : 'Not Available' }}
                            </div>
                        </div>
                        <div class="fw-bolder text-gray-700 text-start">
                            Available to Hire: {{ $freelancer->available_hire ? 'Yes' : 'No' }}<br>
                            Available from Admin: {{ $freelancer->admin_available_hire ? 'Yes' : 'No' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Status Card -->
    <div class="card card-flush mb-6 mb-xl-9">
        <div class="card-header border-0">
            <div class="card-title">
                <h2>Profile Status</h2>
            </div>
        </div>

        <div class="card-body py-0">
            <div class="fs-5 fw-semibold text-gray-500 mb-4">Profile complete status progress</div>

            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between w-100 fs-4 fw-bold mb-3">
                    <span>Percentage</span>
                    <span>{{ $profileCompletion['percentage'] }}%</span>
                </div>

                <div class="h-8px bg-light rounded mb-3">
                    <div class="bg-success rounded h-8px"
                         style="width: {{ $profileCompletion['percentage'] }}%;"
                         role="progressbar"
                         aria-valuenow="{{ $profileCompletion['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                <div class="fw-semibold text-gray-600">
                    {{ $profileCompletion['total_items'] - $profileCompletion['completed_items'] }} Items are remaining
                </div>
            </div>

            <div class="d-flex flex-wrap flex-stack mb-5">
                <div class="d-flex flex-wrap">
                    @foreach($profileCompletion['status'] as $item)
                        <div class="border border-dashed border-gray-300 w-250px rounded my-3 p-4 me-6">
                            <span class="fs-1 fw-bold text-gray-800 lh-1">
                                <span class="counted fs-4">{{ $item['name'] }}</span>
                                @if($item['is_completed'])
                                    <i class="ki-outline ki-check fs-1 text-success"></i>
                                @else
                                    <i class="ki-outline ki-cross fs-1 text-danger"></i>
                                @endif
                            </span>
                            <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">{{ $item['description'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
