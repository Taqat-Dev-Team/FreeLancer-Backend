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
