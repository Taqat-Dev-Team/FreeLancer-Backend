@extends('admin.layouts.master', ['title' => 'Contacts'])


@section('toolbarTitle', 'Contacts  Management')
@section('toolbarSubTitle', 'Show')
@section('toolbarPage',$contact->title)

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid mt-5">
        <!--begin::Card-->
        <div class="card">

            <div class="card-body">
                <!--begin::Title-->
                <div class="d-flex flex-wrap gap-2 justify-content-between mb-8">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <!--begin::Heading-->
                        <h2 class="fw-semibold me-3 my-1">{{$contact->title}}</h2>
                        <!--begin::Heading-->
                        <!--begin::Badges-->
                        @if($contact->status==1)
                            <span class="badge badge-light-primary my-1 me-2">Read</span>
                        @elseif($contact->status==0)
                            <span class="badge badge-light-danger my-1 me-2">New</span>
                        @else
                            <span class="badge badge-light-info my-1">Replied</span>
                        @endif

                        <!--end::Badges-->
                    </div>

                </div>
                <!--end::Title-->
                <!--begin::Message accordion-->
                <div data-kt-inbox-message="message_wrapper">
                    <!--begin::Message header-->
                    <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                        <!--begin::Author-->
                        <div class="d-flex align-items-center">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50 me-4">
                                <span class="symbol-label"
                                      style="background-image:url({{url('logos/favicon.png')}});"></span>
                            </div>
                            <!--end::Avatar-->
                            <div class="pe-5">
                                <!--begin::Author details-->
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    <a href="#" class="fw-bold text-gray-900 text-hover-primary">{{$contact->name}}</a>
{{--                                    <i class="ki-outline ki-abstract-8 fs-7 text-success mx-3"></i>--}}
                                    <span class="text-muted fw-bold  mx-3">{{$contact->email}}</span>
                                    <span class="text-muted fw-bold">{{$contact->created_at->diffForHumans()}}</span>
                                </div>
                                <!--end::Author details-->
                                <!--begin::Message details-->
                                <div data-kt-inbox-message="details">
                                    <span class="text-muted fw-semibold">to me</span>
                                    <!--begin::Menu toggle-->
                                    <a href="#" class="me-1" data-kt-menu-trigger="click"
                                       data-kt-menu-placement="bottom-start">
                                        <i class="ki-outline ki-down fs-5 m-0"></i>
                                    </a>
                                    <!--end::Menu toggle-->
                                    <!--begin::Menu-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                        data-kt-menu="true">
                                        <!--begin::Table-->
                                        <table class="table mb-0">
                                            <tbody>
                                            <tr>
                                                <td class="w-75px text-muted">From</td>
                                                <td>{{$contact->name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Date</td>
                                                <td>{{$contact->created_at->format('d M Y , h:i a')}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Subject</td>
                                                <td>{{$contact->title}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Reply-to</td>
                                                <td>{{$contact->email}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Message details-->
                                <!--begin::Preview message-->
                                <div class="text-muted fw-semibold mw-450px d-none" data-kt-inbox-message="preview">
                                  {{\Illuminate\Support\Str::limit($contact->message,80)}}
                                </div>
                                <!--end::Preview message-->
                            </div>
                        </div>
                        <!--end::Author-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <!--begin::Date-->
                            <span class="fw-semibold text-muted text-end me-3">{{$contact->created_at->format('d M Y , h:i a')}}</span>

                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Message header-->
                    <!--begin::Message content-->
                    <div class="collapse fade show" data-kt-inbox-message="message">
                        <div class="py-5">

                           <p>
                               {!! $contact->message !!}
                           </p>
                        </div>
                    </div>
                    <!--end::Message content-->
                </div>
                <!--end::Message accordion-->
                <div class="separator my-6"></div>

            </div>

        </div>
    </div>
    @push('js')



    @endpush

@stop


