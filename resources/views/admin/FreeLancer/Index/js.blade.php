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

@endpush
