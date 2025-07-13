<div class="tab-pane fade" id="kt_ecommerce_settings_social" role="tabpanel">
    <!--begin::Form-->
    <form id="settings_social_form" class="form" enctype="multipart/form-data">
        @csrf

        <div class="row mb-7">
            <div class="col-md-9 offset-md-3">
                <h2>Social Links</h2>
            </div>
        </div>


        <!-- Facebook -->

        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">Facebook</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="facebook"
                       value="{{  $settings['facebook'] ??''  }}">
            </div>
        </div>


        <!-- Twitter -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">Twitter</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="twitter"
                       value="{{  $settings['twitter'] ??''  }}">
            </div>
        </div>


        <!-- Instagram -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">Instagram</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="instagram"
                       value="{{  $settings['instagram'] ??''  }}">
            </div>
        </div>


        <!-- LinkedIn -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">LinkedIn</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="linkedin"
                       value="{{  $settings['linkedin'] ??''  }}">
            </div>
        </div>

        <!-- TikTok -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">TikTok</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="tiktok"
                       value="{{  $settings['tiktok'] ??''  }}">
            </div>
        </div>

        <!-- YouTube -->
        {{--        <div class="row mb-7">--}}
        {{--            <div class="col-md-3 text-md-end">--}}
        {{--                <label class="fs-6 fw-semibold form-label mt-3">YouTube</label>--}}
        {{--            </div>--}}
        {{--            <div class="col-md-9">--}}
        {{--                <input type="text" class="form-control form-control-solid" name="youtube"--}}
        {{--                       value="{{  $settings['youtube'] ??''  }}">--}}
        {{--            </div>--}}
        {{--        </div>--}}


        <!-- WhatsApp -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">WhatsApp</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="whatsapp"
                       value="{{  $settings['whatsapp'] ??''  }}">
            </div>
        </div>


        <!-- Submit Button -->
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
