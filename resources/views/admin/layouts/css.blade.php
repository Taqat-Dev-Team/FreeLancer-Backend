<meta charset="utf-8"/>
<!-- Charset & Viewport -->
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>

@php

$keywords_en_raw = $settings['meta_keywords_en'] ?? '[]';
$keywords_en_array = is_string($keywords_en_raw) ? json_decode($keywords_en_raw, true) : [];
$keywords_en = collect($keywords_en_array)->pluck('value')->implode(', ');
@endphp


    <!-- SEO Meta -->
<meta name="description" content="{{ $settings['meta_description_en'] ?? 'Default site description here' }}"/>
<meta name="keywords" content="{{ $keywords_en }}">
<meta name="csrf-token" content="{{ csrf_token() }}"/>

<!-- Open Graph -->
<meta property="og:locale" content="en_US"/>
<meta property="og:type" content="website"/>
<meta property="og:title"
      content="{{ $settings['social_title_en'] ?? ($settings['meta_title_en'] ?? 'Default Site Title') }}"/>
<meta property="og:description"
      content="{{ $settings['social_description_en'] ?? $settings['meta_description_en'] ?? 'Default social description' }}"/>
<meta property="og:url" content="{{ url()->current() }}"/>
<meta property="og:site_name"
      content="{{ $settings['social_title_en'] ?? ($settings['meta_title_en'] ?? config('app.name')) }}"/>

<!-- Canonical -->
<link rel="canonical" href="{{ url()->current() }}"/>

<!-- Favicon -->
<link rel="shortcut icon" href="{{ $favicon }}"/>
<link rel="icon" type="image/png" href="{{ $favicon }}"/>

<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
<!--end::Fonts-->

<!--end::Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{url('admin/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('admin/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>


<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Cairo', sans-serif;
    }
</style>

@stack('css')
