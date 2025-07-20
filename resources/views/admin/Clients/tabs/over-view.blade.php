<div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">

    <div class="row">

        <div class="card card-flush mb-6 mb-xl-9 mx-3 col-12">
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Status </span>
                    <span class="text-gray-500 mt-2 fw-semibold fs-6">Client Status</span>
                </h3>
            </div>

            <div class="card-body d-flex align-items-end pt-6">
                <div class="row align-items-center mx-0 w-100">
                    <div class="col-7 px-0">
                        <div class="d-flex flex-column content-justify-center">
                            <div class="d-flex fs-6 fw-semibold align-items-center">
                                <div
                                    class="bullet {{ $client->user->status == '1' ? 'bg-success' : 'bg-warning' }} me-3"
                                    style="border-radius: 3px;width: 12px;height: 12px"></div>
                                <div class="fs-5 fw-bold text-gray-600 me-5">
                                    {{ $client->user->status == '1' ? 'Active' : 'Not Active' }}
                                </div>

                            </div>


                            @if ($client->user->status_reason && $client->user=='0')

                                <div class=" d-flex fs-5 fw-bold text-gray-600 me-5 mt-5">
                                    Reason:
                                    {{$client->status_reason}}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
