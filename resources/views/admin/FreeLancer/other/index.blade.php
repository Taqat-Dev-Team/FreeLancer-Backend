@extends('admin.layouts.master', ['title' => 'Not Verified Freelancers '])


@section('toolbarTitle', 'Not Verified Freelancers')
@section('toolbarSubTitle', 'Freelancers ')
@section('toolbarPage', 'Not verified Freelancers')

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid mt-5">

        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text"
                               id="FreelancerSearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search Freelancer">
                    </div>
                    <!--end::Search-->
                </div>

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div id="" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div id="freelancers" class="table-responsive">

                        <table id="freelancers_table" class="table table-row-bordered gy-5">
                            <thead>
                            <tr class="fw-semibold fs-6 text-muted">

                                <th class="">#</th>
                                <th class="min-w-125px">photo</th>
                                <th class="min-w-125px">name</th>
                                <th class="min-w-125px">email</th>
                                <th class="min-w-125px">mobile</th>
                                <th class="">Joined Date</th>
                                <th class="">status</th>
                                <th class="min-w-125px">Options</th>
                            </tr>
                            </thead>

                        </table>


                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>

        </div>
    </div>

    @push('js')

        <link href="{{url('admin/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
              type="text/css"/>
        <script src="{{url('admin/plugins/custom/datatables/datatables.bundle.js')}}"></script>


        @include('admin.FreeLancer.other.js')

    @endpush

@stop


