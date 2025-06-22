<div class="modal fade" id="addSocialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">

        <form id="addSocialForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Social Medial</h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_ar" class="form-label">Arabic Name</label>
                        <input type="text" id="name_ar" name="name_ar" class="form-control"
                               placeholder="Enter Arabic Name">
                    </div>
                    <div class="mb-3">
                        <label for="name_en" class="form-label">English Name</label>
                        <input type="text" id="name_en" name="name_en" class="form-control"
                               placeholder="Enter English Name">
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Social Media Icon</label>
                        <input type="hidden" name="icon" id="icon">
                        <div id="iconPreview" class="fs-1 mb-2 text-primary"></div>

                        <div class="icon-picker border rounded p-3 bg-light" style="max-height: 500px; overflow-y: auto;">
                            @php
                                $icons = [
          'fa-brands fa-facebook', 'fa-brands fa-twitter', 'fa-brands fa-instagram', 'fa-brands fa-linkedin', 'fa-brands fa-tiktok', 'fa-brands fa-youtube', 'fa-brands fa-telegram', 'fa-brands fa-whatsapp',
          'fa-brands fa-snapchat','fa fa-link',  'fa-brands fa-pinterest', 'fa-brands fa-reddit', 'fa-brands fa-discord', 'fa-brands fa-twitch',

          'fa-brands fa-github', 'fa-brands fa-dribbble', 'fa-brands fa-behance', 'fa-brands fa-vimeo', 'fa-brands fa-slack', 'fa-brands fa-stack-overflow', 'fa-brands fa-medium', 'fa-brands fa-codepen',

          'fa-brands fa-google', 'fa-brands fa-facebook-f', 'fa-brands fa-twitter-square', 'fa-brands fa-linkedin-in', 'fa-brands fa-youtube-square', 'fa-brands fa-spotify',
          'fa-brands fa-stack-exchange', 'fa-brands fa-wordpress', 'fa-brands fa-shopify', 'fa-brands fa-etsy', 'fa-brands fa-fiverr', 'fa-brands fa-upwork'
      ];

                            @endphp
                            @foreach ($icons as $icon)
                                <i class=" {{ $icon }} m-2 p-2  rounded text-center"
                                  title="{{ str_replace(['fa-brands ', 'fa-'], '', $icon) }}" style="font-size: 24px; cursor: pointer;"
                                   data-icon="{{ $icon }}"></i>
                            @endforeach
                        </div>
                    </div>

                    <div class=" modal-footer">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <span class="indicator-label">Save changes</span>
                            <span class="indicator-progress">Please wait...
                                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    </div>


                </div>

            </div>
        </form>
    </div>
</div>



<script>

        $(document).ready(function () {
            const icons = document.querySelectorAll('.icon-picker i');
            const preview = document.getElementById('iconPreview');
            const input = document.getElementById('icon');

            icons.forEach(icon => {
                icon.addEventListener('click', function () {
                    // إزالة التحديد السابق
                    icons.forEach(i => i.classList.remove('border-primary', 'bg-primary-subtle'));

                    // تحديد العنصر الحالي
                    this.classList.add('border-primary', 'bg-primary-subtle');

                    // تعيين القيمة في hidden input
                    const selected = this.dataset.icon;
                    input.value = selected;

                    // عرض الأيقونة
                    preview.innerHTML = `<i class=" ${selected}"></i>`;
                });
            });

            // Reset on modal close
            $('#addSocialModal').on('hidden.bs.modal', function () {
                $('#iconPreview').html('');
                $('.icon-picker i').removeClass('border-primary bg-primary-subtle');
            });
        });
        // Handle form submission
        $('#addSocialForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);
            const submitButton = $(this).find('button[type="submit"]');

            // Disable the button and show the spinner
            submitButton.attr('disabled', true);
            submitButton.find('.indicator-label').hide();
            submitButton.find('.indicator-progress').show();

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.ajax({
                url: "{{ route('admin.management.socials.store') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#addSocialModal').modal('hide');
                    toastr.success(response.message || 'Social Media added successfully!');
                    $('#socials_table').DataTable().ajax.reload();
                    $('#addSocialForm')[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            let inputField = $('#addSocialForm').find(`[name="${key}"]`);
                            inputField.addClass('is-invalid');
                            let errorMessage = `<div class="invalid-feedback d-block">${value[0]}</div>`;
                            inputField.after(errorMessage);
                        });
                        toastr.error('Please correct the errors in the form.');
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                },
                complete: function () {
                    // Re-enable the button and hide the spinner
                    submitButton.attr('disabled', false);
                    submitButton.find('.indicator-label').show();
                    submitButton.find('.indicator-progress').hide();
                }
            });
        });
</script>
