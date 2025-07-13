@extends('admin.layouts.master', ['title' => 'Settings'])
@section('toolbarTitle', 'Website Settings')
@section('toolbarSubTitle', 'Settings ')
@section('toolbarPage', 'Website Settings')
@section('content')
    @php
        $settings=setting();
    @endphp

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15"
                        role="tablist">
                        <!--begin:::Tab item-->
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary d-flex align-items-center pb-5 active"
                               data-bs-toggle="tab" href="#kt_ecommerce_settings_general" aria-selected="true"
                               role="tab">
                                <i class="ki-outline ki-home fs-2 me-2"></i>General</a>
                        </li>


                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                               href="#kt_ecommerce_settings_contact" aria-selected="false" role="tab" tabindex="-1">
                                <i class="ki-outline ki-address-book fs-2 me-2"></i>Contact</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                               href="#kt_ecommerce_settings_social" aria-selected="false" role="tab"
                               tabindex="-1">
                                <i class="ki-outline ki-fasten fs-2 me-2"></i>Socials</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                               href="#kt_ecommerce_settings_seo" aria-selected="false" role="tab" tabindex="-1">
                                <i class="ki-outline ki-text-circle fs-2 me-2"></i>Seo</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                               href="#kt_ecommerce_settings_logos" aria-selected="false" role="tab" tabindex="-1">
                                <i class="ki-outline ki-picture fs-2 me-2"></i>Logos</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab"
                               href="#kt_ecommerce_settings_freelancers" aria-selected="false" role="tab" tabindex="-1">
                                <i class="ki-outline ki-people fs-2 me-2"></i>FreeLancers</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->

                        @include('admin.settings.tabs.general')

                        <!--end:::Tab pane-->
                        <!--begin:::Tab pane-->
                        @include('admin.settings.tabs.contact')
                        @include('admin.settings.tabs.seo')
                        @include('admin.settings.tabs.socials')
                        @include('admin.settings.tabs.logos')
                        @include('admin.settings.tabs.freelancers')
                        <!--end:::Tab pane-->

                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>


    @push('js')

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('form[id$="_form"]').forEach(function (form) {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const submitButton = $(this).find('button[type="submit"]');

                        // Disable the button and show the spinner
                        submitButton.attr('disabled', true);
                        submitButton.find('.indicator-label').hide();
                        submitButton.find('.indicator-progress').show();


                        let formData = new FormData(form);

                        fetch("/admin/settings", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: formData
                        })
                            .then(res => res.json())
                            .then(data => {
                                toastr[data.success ? 'success' : 'error'](data.message);
                            })
                            .catch(err => {
                                toastr.error('حدث خطأ أثناء حفظ الإعدادات');
                            })
                            .finally(() => {
                                submitButton.attr('disabled', false);
                                submitButton.find('.indicator-label').show();
                                submitButton.find('.indicator-progress').hide();

                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            });
                    });
                });
            });
        </script>
    @endpush

@stop
