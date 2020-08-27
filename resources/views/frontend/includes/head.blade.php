<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<base href="{{ asset('') }}">
<title> {{ $data['title'] ?? "Vinachali" }}</title>

@php
$favicon_img = asset('assets/client/dist/img/favicon.ico');
if( !empty( $favicon ) && !empty( $favicon->images ) ) {
  $favicon_img = $favicon->images;
}
@endphp

<link rel="shortcut icon" href="{{ $favicon_img }}" type="image/x-icon">
<link rel="icon" href="{{ $favicon_img }}" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="{{ $seo_description ?? '' }}">
<meta name="keywords" content="{{ $seo_keywords ?? '' }}">
<meta property="og:type" content="{{ $data['page_type'] ?? 'article'}}">
<meta property="og:description" content="{{ $seo_description ?? '' }}">
<meta property="og:url" content="@if(!empty($og_url)){{ asset($og_url) }}@else{{ asset('/') }}@endif">
<meta property="og:site_name" content="@if(!empty($seo_title)){{ $seo_title }}@else{{ $title ?? '' }}@endif">
<meta property="og:title" content="@if(!empty($seo_title)){{ $seo_title }}@else{{ $title ?? '' }}@endif" />
<meta property="og:image" content="{{ $og_image ?? '' }}" />
<meta property="fb:app_id" content="">

<link href="{{ asset('assets/client/dist/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/font-awesome.css ') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/flaticon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/slick-slider.css')}}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/fancybox.css') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/owl.theme.default.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/color.css') }}" rel="stylesheet">
<link href="{{ asset('assets/client/dist/css/responsive.css') }}" rel="stylesheet">

@if( !empty( $data['seo_google'] ) )
    {!! $data['seo_google'] !!}
@endif

@if( !empty( $data['seo_facebook'] ) )
    {!! $data['seo_facebook'] !!}
@endif

@if( !empty( $scripts->script_head ) )
    {!! $scripts->script_head !!}
@endif

{{--    schema sản phẩm--}}
@if( !empty( $data['schema_product'] ) )
    <script type="application/ld+json">
        {!! $data['schema_product'] !!}
    </script>
@endif

{{--    schema bài viết--}}
@if( !empty( $data['schema_post'] ) )
    <script type="application/ld+json">
        {!! $data['schema_post'] !!}
    </script>
@endif

{{--    schema doanh nghiệp--}}
@if( !empty( $data['schema_business'] ) )
    <script type="application/ld+json">
        {!! $data['schema_business'] !!}
    </script>
@endif

{{--    schema logo--}}
@if( !empty( $data['schema_logo'] ) )
    <script type="application/ld+json">
        {!! $data['schema_logo'] !!}
    </script>
@endif

{{--    schema ô tìm kiếm--}}
@if( !empty( $data['schema_search'] ) )
    <script type="application/ld+json">
        {!! $data['schema_search'] !!}
    </script>
@endif

{{--    schema breadcrumb--}}
@if( !empty( $data['schema_breadcrumb'] ) )
    <script type="application/ld+json">
        {!! $data['schema_breadcrumb'] !!}
    </script>
@endif

</head>
