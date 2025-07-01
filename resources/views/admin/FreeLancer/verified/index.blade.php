@extends('admin.layouts.master', ['title' => 'Freelancer Verified'])


@section('toolbarTitle', 'Freelancer Verified ')
@section('toolbarSubTitle', 'Freelancers ')
@section('toolbarPage', 'Freelancer Verified ')

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid mt-5">

        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text"
                               id="FreelancerSearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Freelancer">
                    </div>
                    <!--end::Search-->
                </div>

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div id="" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div id="freelancers" class="table-responsive">

                        <table id="freelancers_table" class="table table-row-bordered gy-5">
                            <thead>
                            <tr class="fw-semibold fs-6 text-muted">

                                <th class="">#</th>
                                <th class="min-w-125px">photo</th>
                                <th class="min-w-125px">name</th>
                                <th class="min-w-125px">email</th>
                                <th class="min-w-125px">mobile</th>
                                <th class="">Joined Date</th>
                                <th class="">status</th>
                                <th class="min-w-125px">Options</th>
                            </tr>
                            </thead>

                        </table>


                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>

        </div>
    </div>

    @push('js')

        <link href="{{url('admin/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
              type="text/css"/>
        <script src="{{url('admin/plugins/custom/datatables/datatables.bundle.js')}}"></script>



        {{--            datatable--}}
        <script>
            $(document).ready(function () {
                const table = $('#freelancers_table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],

                    ajax: {
                        url: '{{ route('admin.freelancers.verified.data') }}',
                        data: function (d) {
                            d.search = $('#FreelancerSearchInput').val();
                        }
                    },

                    columns: [

                        {data: 'DT_RowIndex', name: 'id'},
                        {data: 'photo', name: 'photo', orderable: false, searchable: false},

                        {data: 'name', name: 'user.name', orderable: true, searchable: true},
                        {data: 'email', name: 'user.email', orderable: true, searchable: true},
                        {data: 'mobile', name: 'user.mobile', orderable: true, searchable: true},
                        {data: 'date', name: 'user.created_at', orderable: true, searchable: false},
                        {data: 'status', name: 'user.status', orderable: true, searchable: false},
                        {data: 'actions', name: 'user.actions', orderable: false, searchable: false},
                    ],
                    drawCallback: function () {
                        // Re-init dropdowns after DataTable redraw
                        KTMenu.createInstances();
                        bindActionButtons();
                    }

                });


                // Search input event
                $('#FreelancerSearchInput').on('keyup', function () {
                    table.search(this.value).draw();
                });


                function bindActionButtons() {
                    $('.delete-freelancer').off('click').on('click', function (e) {
                        e.preventDefault();
                        const id = $(this).data('id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/admin/freelancer/verified/' + id,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        toastr.success('Freelancer deleted successfully');
                                        $('#freelancers_table').DataTable().ajax.reload();
                                    },
                                    error: function (xhr) {
                                        toastr.error('Error deleting Freelancer', xhr.responseJSON.message || 'An error occurred');
                                    }
                                });
                            }
                        });
                    });

                    $('.status-freelancer').off('click').on('click', function (e) {
                        e.preventDefault();
                        const id = $(this).data('id');
                        const currentStatus = $(this).data('status'); // current status: 1 = active, 0 = inactive

                        const isCurrentlyActive = currentStatus === 1 || currentStatus === '1';

                        if (isCurrentlyActive) {
                            // Show reason input when deactivating
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This freelancer's account will be deactivated. Please provide a reason.",
                                input: 'textarea',
                                inputLabel: 'Reason for deactivation',
                                inputPlaceholder: 'Enter reason here...',
                                inputAttributes: {
                                    'aria-label': 'Reason for deactivation'
                                },
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, deactivate'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const reason = result.value;

                                    // ⏳ Show loading
                                    Swal.fire({
                                        title: 'Processing...',
                                        text: 'Please wait while we process your request.',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    $.ajax({
                                        url: '/admin/freelancer/verified/status/' + id,
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            reason: reason
                                        },
                                        success: function (response) {
                                            Swal.close();
                                            toastr.success('Status changed successfully');
                                            $('#freelancers_table').DataTable().ajax.reload();
                                        },
                                        error: function (xhr) {
                                            Swal.close();
                                            toastr.error('Error changing status', xhr.responseJSON.message || 'Unknown error');
                                        }
                                    });
                                }
                            });

                        } else {
                            // Just confirm activation
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This will activate the freelancer's account.",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, activate'
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    // ⏳ Show loading
                                    Swal.fire({
                                        title: 'Processing...',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    $.ajax({
                                        url: '/admin/freelancer/verified/status/' + id,
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            reason: ''
                                        },
                                        success: function (response) {
                                            Swal.close();
                                            toastr.success('Freelancer activated successfully');
                                            $('#freelancers_table').DataTable().ajax.reload();
                                        },
                                        error: function (xhr) {
                                            Swal.close();
                                            toastr.error('Error activating freelancer', xhr.responseJSON.message || 'Unknown error');
                                        }
                                    });
                                }
                            });
                        }
                    });

                }
            });


        </script>


    @endpush

@stop


