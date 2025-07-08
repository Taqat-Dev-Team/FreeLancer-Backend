@push('js')

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
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message, 'error');
                        },

                        complete: function () {
                            Swal.close();
                            btn.prop('disabled', true);
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
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message, 'error');
                        },
                        complete: function () {
                            Swal.close();
                            btn.prop('disabled', true);
                        }
                    });
                }
            });
        });
    </script>


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
        document.getElementById('assignBadgeForm').addEventListener('submit', function(e) {
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

@endpush
