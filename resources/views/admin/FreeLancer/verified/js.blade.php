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
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/freelancer/' + id,
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
                                url: '/admin/freelancer/status/' + id,
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
                                url: '/admin/freelancer/status/' + id,
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

@include('admin.FreeLancer.js')
