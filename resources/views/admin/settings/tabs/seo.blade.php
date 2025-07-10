<div class="tab-pane fade" id="kt_ecommerce_settings_seo" role="tabpanel">
    <!--begin::Form-->
    <form id="settings_seo_form" class="form" enctype="multipart/form-data">
        @csrf

        <div class="row mb-7">
            <div class="col-md-9 offset-md-3">
                <h2>SEO Settings</h2>
            </div>
        </div>

        <!-- Meta Description EN -->
        <x-admin.textarea-input
            label="English Meta Tag Description"
            name="meta_description_en"
            :value="setting('meta_description_en')" />

        <!-- Meta Description AR -->
        <x-admin.textarea-input
            label="Arabic Meta Tag Description"
            name="meta_description_ar"
            :value="setting('meta_description_ar')" />

        <!-- Meta Keywords EN -->
        <x-admin.text-input
            label="English Meta Keywords"
            name="meta_keywords_en"
            :value="setting('meta_keywords_en')"
            data-attr='data-kt-ecommerce-settings-type="tagify"' />

        <!-- Meta Keywords AR -->
        <x-admin.text-input
            label="Arabic Meta Keywords"
            name="meta_keywords_ar"
            :value="setting('meta_keywords_ar')"
            data-attr='data-kt-ecommerce-settings-type="tagify"' />

        <!-- Social Title EN -->
        <x-admin.text-input
            label="English Social Title"
            name="social_title_en"
            :value="setting('social_title_en')" />

        <!-- Social Title AR -->
        <x-admin.text-input
            label="Arabic Social Title"
            name="social_title_ar"
            :value="setting('social_title_ar')" />

        <!-- Social Description EN -->
        <x-admin.textarea-input
            label="English Social Description"
            name="social_description_en"
            :value="setting('social_description_en')" />

        <!-- Social Description AR -->
        <x-admin.textarea-input
            label="Arabic Social Description"
            name="social_description_ar"
            :value="setting('social_description_ar')" />

        <div class="row py-5">
            <div class="col-md-9 offset-md-3">
                <div class="d-flex">
                    <button type="reset" class="btn btn-light me-3">Cancel</button>
                    <button type="submit" class="btn btn-primary submit-button">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress d-none">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>


@push('js')
    <script>
        "use strict";
        var KTAppEcommerceSettings = {
            init: function () {
                document.querySelectorAll('[data-kt-ecommerce-settings-type="tagify"]').forEach((e) => {
                    new Tagify(e);
                });
            }
        };
        KTUtil.onDOMContentLoaded(function () {
            KTAppEcommerceSettings.init();
        });
    </script>

@endpush
