<div class="tab-pane fade" id="kt_user_view_id_tab" role="tabpanel">

    @php
        $idVerified = $idHistory->where('status', '1')->first();
    @endphp


    @if($idVerified)
        <div class="card card-flush py-4 flex-row-fluid position-relative">
            <div class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                <i class="ki-solid ki-two-credit-cart" style="font-size: 14em"></i>
            </div>
            <div class="card-header">
                <div class="card-title">
                    <h2>Identity Details</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <strong>Name:</strong> {{ $idVerified->full_name }} <br>
                <strong>ID Number:</strong> {{ $idVerified->id_number }} <br>
                <strong>Address:</strong> {{ $idVerified->full_address }} <br>
                <strong>Verification Date:</strong> {{ $idVerified->verification_date }} <br>
                <a class="btn btn-sm btn-primary me-3 m-3" href="{{ $idVerified->getImageUrl() }}" target="_blank">
                    <i class="ki-outline ki-devices"></i> View ID Photo
                </a>
            </div>
        </div>
    @endif

    <div class="card card-flush h-xl-100 mt-5">
        <div class="card-header pt-7">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Verification Request History</span>
            </h3>
        </div>
        <div class="card-body">
            <div class="hover-scroll-overlay-y pe-6 me-n6">
                @forelse($idHistory as $id)
                    @php
                        $status = match($id->status) {
                            '1' => ['✔️ Verified', 'badge-light-success'],
                            '2' => ['❌ Rejected', 'badge-light-danger'],
                            default => ['⏳ Pending', 'badge-light-warning'],
                        };
                        $formattedDate = $id->verification_date
                            ? \Carbon\Carbon::parse($id->verification_date)->format('Y-m-d')
                            : '---';
                    @endphp

                    <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                        <div class="d-flex flex-stack mb-3">
                            <div class="me-3">
                                <a href="{{ $id->getImageUrl() }}" target="_blank"
                                   class="text-gray-800 text-hover-primary fw-bold">
                                    {{ $id->full_name }}
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-4 align-items-center">
                            <span class="badge {{ $status[1] }}">{{ $status[0] }}</span>

                            <div><strong>ID Number:</strong> {{ $id->id_number ?? '---' }}</div>
                            <div><strong>Location:</strong> {{ $id->full_address ?? '---' }}</div>
                            <div><strong>Verified Date:</strong> {{ $formattedDate }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">No identity verification history found.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
