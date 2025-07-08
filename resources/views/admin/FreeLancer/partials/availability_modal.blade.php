<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">Availability Details</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>


            <div class="modal-body">
                <ul class="l alert alert-warning">
                    @foreach ($row->availabilityDetails() as $reason)
                        <li class="list-group-item text-danger d-flex align-items-center text-center m-2 "
                            style="font-size: 1.1rem;">
                            <i class="ki-solid ki-shield-cross fs-1  me-2 text-warning"></i>
                            {{ $reason }}
                        </li>
                        {{--                    admin active--}}
                    @endforeach
                </ul>


                @if(!$row->admin_available_hire)
                    <a href="#"
                       class="btn btn-primary w-100 toggle-admin-availability-active"
                       data-id="{{ $row->id }}">
                        <i class="ki-solid ki-check fs-1 me-2"></i>
                        Admin Activate Availability
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>

