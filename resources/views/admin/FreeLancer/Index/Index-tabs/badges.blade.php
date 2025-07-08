<div class="tab-pane fade" id="kt_user_view_badges_tab" role="tabpanel">


    <div class="card card-flush h-xl-100 mt-5">
        <div class="card-header pt-7 d-flex justify-content-between align-items-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Assigned Badges</span>
            </h3>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#assignBadgeModal">
                <i class="ki-outline ki-plus "></i> Assigned New
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if($badges->count())
                    <table class="table align-middle table-row-dashed gy-5">
                        <thead>
                        <tr class="fw-bold text-muted">

                            <th>Icon</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($badges as $badge)
                            <tr id="badge-row-{{ $badge->id }}">

                                <td>
                                    <img src="{{ $badge->getImageUrl() }}"
                                         class="w-40px h-40px rounded-circle" alt="{{ $badge->name }}">
                                </td>
                                <td>{{ $badge->name }}</td>
                                <td>{{ $badge->description }}</td>
                                <td class="text-end">
                                    <button class="btn btn-icon btn-sm btn-light-danger"
                                            onclick="deleteBadge({{ $badge->id }})">
                                        <i class="ki-outline ki-trash fs-5"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <span class="text-muted">None.</span>
                @endif
            </div>
        </div>


    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="assignBadgeModal" tabindex="-1" aria-labelledby="assignBadgeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form id="assignBadgeForm">
            @csrf
            <input type="hidden" name="freelancer_id" value="{{$freelancer->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignBadgeModalLabel">Assigned New Badge</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="badge_id" class="form-label">Select Badge</label>
                        <select class="form-select" id="badge_id" name="badge_id" required>
                            @forelse($anotherBadges as $badge)
                                <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                            @empty
                                <option selected disabled>None</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" @if($anotherBadges->isEmpty()) disabled @endif>
                        Assign
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

