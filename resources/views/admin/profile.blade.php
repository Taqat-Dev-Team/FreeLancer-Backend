@extends('admin.layouts.master', ['title' => 'Profile'])


@section('toolbarTitle', 'Admin Profile ')
@section('toolbarSubTitle', 'Users ')
@section('toolbarPage', auth('admin')->user()?->name )

@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Navbar-->
            <!--end::Navbar-->
            <!--begin::Basic info-->
            <div class="row">


                <div class="card mb-5 mb-xl-10 col-6 mx-3 ">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Profile Details</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="profile" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                              novalidate="novalidate">
                            @csrf
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline" data-kt-image-input="true"
                                             style="background-image: url({{auth('admin')->user()->getImageUrl()}}">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                 style="background-image: url({{auth('admin')->user()->getImageUrl()}}"></div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                aria-label="Change avatar" data-bs-original-title="Change avatar"
                                                data-kt-initialized="1">
                                                <i class="ki-outline ki-pencil fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" name="avatar_remove">
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Cancel-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                                data-kt-initialized="1">
																	<i class="ki-outline ki-cross fs-2"></i>
																</span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                                data-kt-initialized="1">
																	<i class="ki-outline ki-cross fs-2"></i>
																</span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                        <!--begin::Hint-->
                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input type="text" name="name"
                                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                       placeholder="name" value="{{auth('admin')->user()->name}}">
                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                            </div>

                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                                <input type="text" name="email"
                                                       class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                       placeholder="email" value="{{auth('admin')->user()->email}}">
                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                            </div>

                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->


                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">

                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Save changes</span>
                                        <span class="indicator-progress">Please wait...
                                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>

                            </div>
                            <!--end::Actions-->

                        </form>

                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <div class="card mb-5 mb-xl-10  mx-3 col-5">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Password</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="password" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                              novalidate="novalidate">
                            @csrf
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Old
                                        Password</label>
                                    <div class="col-lg-8">
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-lg form-control-solid"
                                                   type="password" name="old_password"
                                                   autocomplete="off" placeholder="Old Password">

                                     

                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">New
                                        Password</label>
                                    <div class="col-lg-8">
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-lg form-control-solid"
                                                   type="password" name="password"
                                                   autocomplete="off" placeholder="New Password">


                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm
                                        Password</label>
                                    <div class="col-lg-8">
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-lg form-control-solid"
                                                   type="password" name="password_confirmation"
                                                   autocomplete="off" placeholder="Confirm Password">



                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Input group-->


                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">

                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Save changes</span>
                                        <span class="indicator-progress">Please wait...
                                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>

                            </div>
                            <!--end::Actions-->

                        </form>

                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>


            </div>
            <!--end::Basic info-->


            <!--begin::Basic info-->
            <!--end::Basic info-->


        </div>
        <!--end::Content container-->
    </div>

    @push('js')

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.toggle-password').forEach(button => {
                    button.addEventListener('click', function () {
                        const input = this.parentElement.querySelector('input');
                        const eyeSlash = this.querySelector('.ki-eye-slash');
                        const eye = this.querySelector('.ki-eye');

                        if (input.type === 'password') {
                            input.type = 'text';
                            eyeSlash.classList.add('d-none');
                            eye.classList.remove('d-none');
                        } else {
                            input.type = 'password';
                            eye.classList.add('d-none');
                            eyeSlash.classList.remove('d-none');
                        }
                    });
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const forms = [
                    {id: 'profile', url: '/admin/profile'},
                    {id: 'password', url: '/admin/update-password'}
                ];

                forms.forEach(({id, url}) => {
                    const form = document.getElementById(id);
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const submitButton = $(form).find('button[type="submit"]');
                        submitButton.attr('disabled', true);
                        submitButton.find('.indicator-label').hide();
                        submitButton.find('.indicator-progress').show();

                        let formData = new FormData(form);

                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: formData
                        })
                            .then(res => res.json())
                            .then(data => {
                                // 1. Clear previous errors
                                form.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');
                                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                                // 2. Success or show errors
                                if (data.success) {
                                    toastr.success(data.message);

                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);

                                } else {
                                    if (data.errors) {
                                        Object.keys(data.errors).forEach(key => {
                                            const input = form.querySelector(`[name="${key}"]`);
                                            if (input) {
                                                input.classList.add('is-invalid');
                                                const errorContainer = input.parentElement.querySelector('.invalid-feedback');
                                                if (errorContainer) {
                                                    errorContainer.innerText = data.errors[key][0];
                                                }
                                            }
                                        });
                                    } else if (data.message) {
                                        toastr.error(data.message);
                                    }
                                }
                            })
                            .catch(() => {
                                toastr.error('Server Error');
                            })
                            .finally(() => {

                                submitButton.attr('disabled', false);
                                submitButton.find('.indicator-label').show();
                                submitButton.find('.indicator-progress').hide();


                            });
                    });
                });
            });
        </script>
    @endpush

@stop




