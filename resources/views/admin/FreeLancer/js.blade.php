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

                    url: '/admin/freelancer/admin-active/' + id,
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
                    url: '/admin/freelancer/admin-deactivate/' + id,
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
                    url: '/admin/freelancer/send-message',
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
