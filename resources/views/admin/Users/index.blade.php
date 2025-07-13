@extends('admin.layouts.master', ['title' => 'Users'])


@section('toolbarTitle', 'Users not select type ')
@section('toolbarSubTitle', 'Users ')
@section('toolbarPage', 'Users not select type')

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
                                <th class="min-w-125px">email</th>
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
                        url: '{{ route('admin.users.data') }}',
                        data: function (d) {
                            d.search = $('#FreelancerSearchInput').val();
                        }
                    },


                    columns: [

                        {data: 'DT_RowIndex', name: 'id'},
                        {data: 'photo', name: 'photo', orderable: false, searchable: false},
                        {data: 'email', name: 'email', orderable: true, searchable: true},
                        {data: 'date', name: 'created_at', orderable: true, searchable: false},
                        {data: 'status', name: 'status', orderable: true, searchable: false},
                        {data: 'actions', name: 'actions', orderable: false, searchable: false},
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
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/admin/users/' + id,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        toastr.success('User deleted successfully');
                                        $('#freelancers_table').DataTable().ajax.reload();
                                    },
                                    error: function (xhr) {
                                        toastr.error('Error deleting User', xhr.responseJSON.message || 'An error occurred');
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
                                text: "This User's account will be deactivated. Please provide a reason.",
                                input: 'textarea',
                                inputLabel: 'Reason for deactivation',
                                inputPlaceholder: 'Enter reason here...',
                                inputAttributes: {
                                    'aria-label': 'Reason for deactivation'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Yes, deactivate'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const reason = result.value;

                                    // ⏳ Show loading
                                    Swal.fire({
                                        title: 'Processing...',
                                        text: 'Please wait while we process your request.',
                                        icon: 'info',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    $.ajax({
                                        url: '/admin/users/status/' + id,
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
                                text: "This will activate the User's account.",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, activate'
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    // ⏳ Show loading
                                    Swal.fire({
                                        title: 'Processing...',
                                        text: 'Please wait while we process your request.',
                                        icon: 'info',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    $.ajax({
                                        url: '/admin/users/status/' + id,
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            reason: ''
                                        },
                                        success: function (response) {
                                            Swal.close();
                                            toastr.success('User activated successfully');
                                            $('#freelancers_table').DataTable().ajax.reload();
                                        },
                                        error: function (xhr) {
                                            Swal.close();
                                            toastr.error('Error activating User', xhr.responseJSON.message || 'Unknown error');
                                        }
                                    });
                                }
                            });
                        }
                    });

                }
            });


        </script>


        {{--        sendmassage--}}
        <script>
            $(document).on('click', '.message-freelancer', function (e) {
                e.preventDefault();

                const freelancerId = $(this).data('id');

                Swal.fire({
                    title: 'Send Message to User',
                    input: 'textarea',
                    inputLabel: 'Your Message',
                    inputPlaceholder: 'Type your message here...',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Send',
                    cancelButtonText: 'Cancel',
                    preConfirm: (message) => {
                        if (!message) {
                            Swal.showValidationMessage('Message cannot be empty!');
                        }
                        return message;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const message = result.value;

                        Swal.fire({
                            title: 'Sending...',
                            text: 'Please wait while we send your message.',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/admin/users/send-message',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: freelancerId,
                                message: message
                            },
                            success: function (res) {
                                Swal.close();
                                toastr.success(res.message);
                            },
                            error: function (xhr) {
                                Swal.close();
                                toastr.error(xhr.responseJSON?.message || 'An error occurred');
                            }
                        });
                    }
                });
            });
        </script>

    @endpush

@stop


