<div class="tab-pane fade" id="kt_ecommerce_settings_logos" role="tabpanel">
    {{--    <!--begin::Form-->--}}

    <form id="settings_logos_form" class="form" enctype="multipart/form-data">
        @csrf

        <div class="row mb-7">
            <div class="col-md-9 offset-md-3">
                <h2>Logos & Icons</h2>
            </div>
        </div>

        {{-- Favicon --}}
        @php $favicon = setting_media('favicon')?? asset('logos/favicon.png'); @endphp
        <div class="row mb-7 fv-row fv-plugins-icon-container">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">
                    <span class="required">Favicon</span>
                </label>
            </div>
            <div class="col-md-9 mb-2">
                <div class="image-input image-input-outline" data-kt-image-input="true"
                     style="background-image: url('{{ $favicon }}');">
                    <div class="image-input-wrapper"
                         style="background-image: url('{{ $favicon }}');"></div>

                    <label
                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change" title="Change favicon">
                        <i class="ki-outline ki-pencil fs-6"></i>
                        <input type="file" name="favicon" accept=".png, .jpg, .jpeg"/>
                        <input type="hidden" name="favicon_remove"/>
                    </label>

                    <span
                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove" title="Remove favicon">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </span>
                </div>
            </div>
        </div>

        {{-- White Logo --}}
        @php $white = setting_media('white_logo')?? asset('logos/white.png'); @endphp
        <div class="row mb-7 fv-row fv-plugins-icon-container">
            <div class="col-md-3 text-md-end">
                <label class="fs-6 fw-semibold form-label mt-3">
                    <span class="required">White Logo</span>
                </label>
            </div>
            <div class="col-md-9 mb-2">
                <div class="image-input image-input-outline" data-kt-image-input="true"
                     style="background-image: url('{{ $white }}');">
                    <div class="image-input-wrapper w-850px"
                         style="background-image: url('{{ $white }}'); height: 170px !important;  background-color: #cac1c10d">
                </div>

                <label
                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" title="Change white logo">
                    <i class="ki-outline ki-pencil fs-6"></i>
                    <input type="file" name="white_logo" accept=".png, .jpg, .jpeg"/>
                    <input type="hidden" name="white_logo_remove"/>
                </label>

                <span
                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" title="Remove white logo">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </span>
            </div>
        </div>
</div>

{{-- Dark Logo --}}
@php $dark = setting_media('logo')?? asset('logos/logo.png'); @endphp
<div class="row mb-7 fv-row fv-plugins-icon-container">
    <div class="col-md-3 text-md-end">
        <label class="fs-6 fw-semibold form-label mt-3">
            <span class="required">Dark Logo</span>
        </label>
    </div>
    <div class="col-md-9 mb-2">
        <div class="image-input image-input-outline" data-kt-image-input="true"
             style="background-image: url('{{ $dark }}');">
            <div class="image-input-wrapper w-850px"
                 style="background-image: url('{{ $dark }}'); height: 170px !important; background-color: #cac1c10d"></div>

            <label
                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="change" title="Change logo">
                <i class="ki-outline ki-pencil fs-6"></i>
                <input type="file" name="logo" accept=".png, .jpg, .jpeg"/>
                <input type="hidden" name="logo_remove"/>
            </label>

            <span
                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="remove" title="Remove logo">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </span>
        </div>
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


</div>
