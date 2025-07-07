<div class="tab-pane fade " id="kt_user_view_summary_tab" role="tabpanel">

    <div class="card card-flush mb-10">
        <!--begin::Card header-->

        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Post content-->
            <div class="fs-6 fw-normal text-gray-700 mb-5">
                {{$freelancer->user->bio}}
            </div>
            <!--end::Post content-->
            <!--begin::Post media-->
            <!-- عنوان الصور -->
            <h3 class="mb-5">{{ $freelancer->images_title }}</h3>

            <div class="row g-7">
                @foreach($freelancer->getImagesUrls() as $key => $image)
                    @php $url = $image['url']; @endphp

                    @if($key == 0)
                        <!-- الصورة الأولى كبيرة -->
                        <div class="col-6 mb-5">
                            <a class="d-block card-rounded overlay h-100"
                               data-fslightbox="lightbox-projects"
                               href="{{ $url }}">
                                <div
                                    class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded"
                                    style="background-image:url('{{ $url }}'); height: 100px; object-fit: cover"></div>
                                <div
                                    class="overlay-layer card-rounded bg-dark bg-opacity-25 d-flex justify-content-center align-items-center">
                                    <i class="ki-outline ki-eye fs-3x text-white"></i>
                                </div>
                            </a>
                        </div>
                    @else
                        <!-- باقي الصور صغيرة -->
                        <div class="col-4 col-md-4">
                            <a class="d-block card-rounded overlay"
                               data-fslightbox="lightbox-projects"
                               href="{{ $url }}">
                                <div
                                    class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded"
                                    style="background-image:url('{{ $url }}'); height: 100px;object-fit: cover"></div>
                                <div
                                    class="overlay-layer card-rounded bg-dark bg-opacity-25 d-flex justify-content-center align-items-center">
                                    <i class="ki-outline ki-eye fs-3x text-white"></i>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>


            <!--end::Post media-->
        </div>


        <!--end::Card body-->

    </div>
    <div class="card card-flush mb-10">

        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Post content-->
            <div
                class="fs-6 fw-normal text-gray-700 mb-5">{{$freelancer->user->video_title}} </div>
            <!--end::Post content-->
            <!--begin::Video-->
            @php
                function getYoutubeEmbedUrl($url) {
                    // إذا الرابط يحتوي على watch?v=
                    if (preg_match('/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
                        $videoId = $matches[1];
                    }
                    // إذا الرابط قصير مثل youtu.be
                    elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
                        $videoId = $matches[1];
                    }
                    // إذا الرابط يحتوي على embed مباشرة
                    elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
                        $videoId = $matches[1];
                    }
                    else {
                        $videoId = null;
                    }

                    return $videoId ? 'https://www.youtube.com/embed/' . $videoId : null;
                }

                $embedUrl = getYoutubeEmbedUrl($freelancer->user->video);
            @endphp

            @if ($embedUrl)
                <div class="m-0">
                    <iframe class="embed-responsive-item rounded h-300px w-100"
                            src="{{ $embedUrl }}"
                            allowfullscreen></iframe>
                </div>
            @else
                <p class="text-danger">فيديو غير صالح أو الرابط غير مدعوم.</p>
            @endif

            <!--end::Video-->
        </div>
        <!--end::Card body-->

    </div>
    <!--end::Body-->
</div>
