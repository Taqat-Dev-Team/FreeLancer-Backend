<div class="tab-pane fade" id="kt_ecommerce_settings_contact" role="tabpanel">
    <!--begin::Form-->
    <form id="settings_contact_form" class="form">
        @csrf

        <!--begin::Heading-->
        <div class="row mb-7">
            <div class="col-md-9 offset-md-3">
                <h2>Contacts Settings</h2>
            </div>
        </div>

        <!--begin::Phone-->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">
                    <span class="required">Phone Number</span>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="phone_number"
                       value="{{  $settings['phone_number'] ??''  }}">
            </div>
        </div>

        <!--begin::Email-->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">
                    <span class="required">Email</span>
                </label>
            </div>
            <div class="col-md-9">
                <input type="email" class="form-control form-control-solid" name="email"
                       value="{{  $settings['email'] ??''  }}">
            </div>
        </div>

        <!--begin::English Address-->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">
                    <span class="required">English Address</span>
                </label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control form-control-solid"
                          name="address_en"> {{  $settings['address_en'] ??''  }}</textarea>
            </div>
        </div>

        <!--begin::Arabic Address-->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">
                    <span class="required">Arabic Address</span>
                </label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control form-control-solid"
                          name="address_ar">{{  $settings['address_ar'] ??''  }}</textarea>
            </div>
        </div>

        <!--begin::Buttons-->
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
