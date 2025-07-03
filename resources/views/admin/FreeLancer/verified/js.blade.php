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
                {data: 'availability', name: 'availability', orderable: false, searchable: false},
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
                        $('#freelancers_table').DataTable().ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message, 'error');
                    },
                    complete: function () {
                        Swal.close();
                        let modal = bootstrap.Modal.getInstance(document.getElementById('availabilityModal_' + id));
                        modal.hide();
                        btn.prop('disabled', false);
                        btn.html('<i class="ki-solid ki-check fs-1 me-2"></i> Admin Activate Availability');
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
                        $('#freelancers_table').DataTable().ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message, 'error');
                    },
                    complete: function () {
                        Swal.close();
                        let modal = bootstrap.Modal.getInstance(document.getElementById('availabilityModal_' + id));
                        modal.hide();
                        btn.prop('disabled', false);
                        btn.html('<i class="ki-solid ki-check fs-1 me-2"></i> Admin Activate Availability');
                    }
                });
            }
        });
    });
</script>

{{--        sendmassage--}}
<script>
    $(document).on('click', '.message-freelancer', function (e) {
        e.preventDefault();

        const freelancerId = $(this).data('id');

        Swal.fire({
            title: 'Send Message to Freelancer',
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
                    url: '/admin/freelancer/verified/send-message',
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
