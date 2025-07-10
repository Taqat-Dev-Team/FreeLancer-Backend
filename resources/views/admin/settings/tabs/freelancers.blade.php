<div class="tab-pane fade" id="kt_ecommerce_settings_freelancers" role="tabpanel">
    <!--begin::Form-->
    <form id="settings_freelancers_form" class="form" enctype="multipart/form-data">
        @csrf

        <!--begin::Heading-->
        <div class="row mb-7">
            <div class="col-md-9 offset-md-3">
                <h2>Freelancers Settings</h2>
            </div>
        </div>

        <!--begin::Profile Availability %-->
        <div class="row mb-7">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3 required">
                    Profile Status Availability Percentage (%)
                </label>
            </div>
            <div class="col-md-9">
                <input type="number" class="form-control form-control-solid"
                       name="freelancers_availability_percentage"
                       value="{{ setting('freelancers_availability_percentage') }}">
            </div>
        </div>

        <!--begin::Buttons-->
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
