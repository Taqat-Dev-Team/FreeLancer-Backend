{{--@props(['label', 'name', 'image' => null])--}}

{{--@php--}}
{{--    $imageUrl = is_object($image) && method_exists($image, 'getFullUrl') ? $image->getFullUrl() : $image;--}}
{{--@endphp--}}

{{--<div class="row mb-7 fv-row fv-plugins-icon-container">--}}
{{--    <div class="col-md-3 text-md-end">--}}
{{--        <label class="fs-6 fw-semibold form-label mt-3">--}}
{{--            <span class="required">{{ $label }}</span>--}}
{{--        </label>--}}
{{--    </div>--}}
{{--    <div class="col-md-9 mb-2">--}}
{{--        <div class="image-input image-input-outline" data-kt-image-input="true"--}}
{{--             style="background-image: url('{{ $imageUrl }}');">--}}
{{--            <div class="image-input-wrapper w-850px"--}}
{{--                 style="background-image: url('{{ $imageUrl }}'); height: 170px !important;"></div>--}}

{{--            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                   data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change {{ $name }}">--}}
{{--                <i class="ki-outline ki-pencil fs-6"></i>--}}
{{--                <input type="file" name="{{ $name }}" accept=".png, .jpg, .jpeg" />--}}
{{--                <input type="hidden" name="{{ $name }}_remove" />--}}
{{--            </label>--}}

{{--            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                  data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove {{ $name }}">--}}
{{--                <i class="ki-outline ki-cross fs-3"></i>--}}
{{--            </span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
