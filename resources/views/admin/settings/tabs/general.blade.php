<div class="tab-pane fade active show" id="kt_ecommerce_settings_general" role="tabpanel">
    <!--begin::Form-->
    <form id="settings_general_form" class="form" enctype="multipart/form-data">
        @csrf

        <!--begin::Heading-->
        <div class="row mb-7">
            <div class="col-md-9 offset-md-3">
                <h2>General Settings</h2>
            </div>
        </div>

        <!-- Site Name (EN) -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">English Site Name</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="name_en" value="{{ setting('name_en') }}">
            </div>
        </div>

        <!-- Site Name (AR) -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">Arabic Site Name</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="name_ar" value="{{ setting('name_ar') }}">
            </div>
        </div>

        <!-- Slogan (EN) -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">English Slogan</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="slogan_en" value="{{ setting('slogan_en') }}">
            </div>
        </div>

        <!-- Slogan (AR) -->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">Arabic Slogan</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-solid" name="slogan_ar" value="{{ setting('slogan_ar') }}">
            </div>
        </div>

        <!-- Buttons -->
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

