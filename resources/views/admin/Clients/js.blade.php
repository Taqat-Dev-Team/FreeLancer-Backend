@push('js')

    {{--    deleteClient--}}
    <script>
        function deleteClient(Id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This Client will be permanently removed.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/clients/${Id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            toastr.success(data.message || 'CLinet deleted successfully.');
                            // توجيه للصفحة بعد نجاح الحذف
                            setTimeout(() => {
                                window.location.href = "{{ route('admin.clients.index') }}";
                            }, 1000);
                        })
                        .catch((error) => {
                            toastr.error('Something went wrong. Please try again.');
                            console.error(error);
                        });
                }
            });
        }
    </script>


    {{--                sendmassage--}}
    <script>
        $(document).on('click', '.message-freelancer', function (e) {
            e.preventDefault();

            const freelancerId = {{$client->id}};

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
                        url: '/admin/clients/send-message',
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


    {{--        status--}}
    <script>
        $(document).on('click', '.status-freelancer', function (e) {

            e.preventDefault();
            const id = {{ $client->id }};
            const currentStatus = {{$client->user->status}}; // current status: 1 = active, 0 = inactive

            const isCurrentlyActive = currentStatus === 1 || currentStatus === '1';

            if (isCurrentlyActive) {
                // Show reason input when deactivating
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This client's account will be deactivated. Please provide a reason.",
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
                            url: '/admin/clients/status/' + id,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                reason: reason
                            },
                            success: function (response) {
                                Swal.close();
                                toastr.success('Status changed successfully');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
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
                    text: "This will activate the client's account.",
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
                            url: '/admin/clients/status/' + id,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                reason: ''
                            },
                            success: function (response) {
                                Swal.close();
                                toastr.success('Client activated successfully');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            },
                            error: function (xhr) {
                                Swal.close();
                                toastr.error('Error activating Client', xhr.responseJSON.message || 'Unknown error');
                            }
                        });
                    }
                });
            }


        });
    </script>

@endpush
