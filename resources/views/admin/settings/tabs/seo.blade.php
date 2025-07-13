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
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">English Meta Tag Description</label>
            <div class="col-md-9">
                <textarea name="meta_description_en" class="form-control form-control-solid"
                          rows="3">{{ $settings['meta_description_en'] ??'' }}</textarea>
            </div>
        </div>

        <!-- Meta Description AR -->
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">Arabic Meta Tag Description</label>
            <div class="col-md-9">
                <textarea name="meta_description_ar" class="form-control form-control-solid"
                          rows="3">{{  $settings['meta_description_ar'] ?? '' }}</textarea>
            </div>
        </div>

        <!-- Meta Keywords EN -->
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">English Meta Keywords</label>
            <div class="col-md-9">
                <input name="meta_keywords_en" value="{{ $settings['meta_keywords_en'] ??'' }}" type="text"
                       class="form-control form-control-solid"
                       data-kt-ecommerce-settings-type="tagify"/>
            </div>
        </div>

        <!-- Meta Keywords AR -->
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">Arabic Meta Keywords</label>
            <div class="col-md-9">
                <input name="meta_keywords_ar" value="{{  $settings['meta_keywords_ar'] ??'' }}" type="text"
                       class="form-control form-control-solid"
                       data-kt-ecommerce-settings-type="tagify"/>
            </div>
        </div>

        <!-- Social Title EN -->
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">English Social Title</label>
            <div class="col-md-9">
                <input name="social_title_en" value="{{  $settings['social_title_en'] ??''  }}" type="text" class="form-control form-control-solid"/>
            </div>
        </div>

        <!-- Social Title AR -->
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">Arabic Social Title</label>
            <div class="col-md-9">
                <input name="social_title_ar" value="{{  $settings['social_title_ar'] ??''  }}" type="text"
                       class="form-control form-control-solid"/>
            </div>
        </div>

        <!-- Social Description EN -->
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">English Social Description</label>
            <div class="col-md-9">
                <textarea name="social_description_en" class="form-control form-control-solid"
                          rows="3">{{  $settings['social_description_en'] ??''  }}</textarea>
            </div>
        </div>

        <!-- Social Description AR -->
        <div class="row mb-7">
            <label class="col-md-3 col-form-label text-md-end required">Arabic Social Description</label>
            <div class="col-md-9">
                <textarea name="social_description_ar" class="form-control form-control-solid"
                          rows="3">{{  $settings['social_description_ar'] ??''  }}</textarea>
            </div>
        </div>

        <!-- Submit -->
        <div class="row py-5">
            <div class="col-md-9 offset-md-3">
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Save changes</span>
                        <span class="indicator-progress">Please wait...
                                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
