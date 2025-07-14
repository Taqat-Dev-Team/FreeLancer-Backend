@push('js')

    {{--    delet badge--}}
    <script>
        function deleteBadge(badgeId) {
            const freelancerId = {{ $freelancer->id }};

            Swal.fire({
                title: 'Are you sure?',
                text: "This badge will be permanently removed.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/freelancer/badges/delete/${freelancerId}/${badgeId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector(`#badge-row-${badgeId}`)?.remove();
                                toastr.success(data.message);
                            } else {
                                toastr.error(data.message || 'Failed to delete badge.');
                            }
                        })
                        .catch(() => {
                            toastr.error('Something went wrong. Please try again.');
                        });
                }
            });
        }

    </script>

    {{--assignBadgeForm--}}
    <script>
        document.getElementById('assignBadgeForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch("{{ route('admin.freelancers.badges.assign') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || 'Badge assigned successfully.');

                        // إغلاق المودال
                        const modal = bootstrap.Modal.getInstance(document.getElementById('assignBadgeModal'));
                        modal.hide();

                        // إعادة تحميل الصفحة بعد ثانية
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(data.message || 'Failed to assign badge.');
                    }
                })
                .catch(error => {
                    toastr.error('Something went wrong. Please try again.');
                    console.error(error);
                });
        });

    </script>


    {{--    delet freelancer--}}
    <script>
        function deleteFreelancer(Id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This freelancer will be permanently removed.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/freelancer/${Id}`, {
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
                            toastr.success(data.message || 'Freelancer deleted successfully.');
                            // توجيه للصفحة بعد نجاح الحذف
                            setTimeout(() => {
                                window.location.href = "{{ route('admin.freelancers.verified.index') }}";
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

    {{--    Review freelancer--}}
    <script>
        function ActionReview(Id, action) {
            if (action === '2') {
                // Reject - requires reason
                Swal.fire({
                    title: 'Reject Freelancer',
                    input: 'textarea',
                    inputLabel: 'Reason for rejection',
                    inputPlaceholder: 'Type the reason here...',
                    inputAttributes: {
                        'aria-label': 'Reason'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    cancelButtonText: 'Cancel',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Please provide a reason for rejection.';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitReview(Id, action, result.value);
                    }
                });
            } else {
                // Approve
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This freelancer will be approved.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, approve',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitReview(Id, action, null);
                    }
                });
            }
        }

        function submitReview(Id, action, reason) {
            // Show "Processing..." dialog
            Swal.fire({
                icon: 'info',
                title: 'Processing...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            fetch(`/admin/freelancer/review/${Id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: action,
                    reason: reason
                })
            })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        let message = data.message || 'An error occurred while processing the request.';
                        Swal.close();
                        toastr.error(message);
                        throw new Error(message);
                    }

                    Swal.close();
                    toastr.success(data.message || 'Action completed successfully.');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                })
                .catch(error => {
                    Swal.close();
                    console.error(error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Unexpected error occurred. Please try again later.'
                    });
                });
        }
    </script>


    {{--        sendmassage--}}
    <script>
        $(document).on('click', '.message-freelancer', function (e) {
            e.preventDefault();

            const freelancerId = {{$freelancer->id}};

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


    {{--status--}}
    <script>
        $(document).on('click', '.status-freelancer', function (e) {

            e.preventDefault();
            const id = {{ $freelancer->id }};
            const currentStatus = {{$freelancer->user->status}}; // current status: 1 = active, 0 = inactive

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
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
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
    </script>
@endpush
