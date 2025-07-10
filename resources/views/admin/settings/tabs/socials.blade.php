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
        <x-admin.text-input label="Facebook" name="facebook" :value="setting('facebook')" />

        <!-- Twitter -->
        <x-admin.text-input label="Twitter" name="twitter" :value="setting('twitter')" />

        <!-- Instagram -->
        <x-admin.text-input label="Instagram" name="instagram" :value="setting('instagram')" />

        <!-- LinkedIn -->
        <x-admin.text-input label="LinkedIn" name="linkedin" :value="setting('linkedin')" />

        <!-- TikTok -->
        <x-admin.text-input label="TikTok" name="tiktok" :value="setting('tiktok')" />

        <!-- YouTube -->
        <x-admin.text-input label="YouTube" name="youtube" :value="setting('youtube')" />

        <!-- WhatsApp -->
        <x-admin.text-input label="WhatsApp" name="whatsapp" :value="setting('whatsapp')" />

        <!-- Telegram -->
        <x-admin.text-input label="Telegram" name="telegram" :value="setting('telegram')" />

        <!-- Submit Button -->
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
