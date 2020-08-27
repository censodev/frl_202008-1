<?php
use App\Models\backend\ProductItem;
?>
@extends($data->layout, [
    'title'             => $data['title'],
    "seo_title"         => $data['seo_title'],
    'og_image'          => $data['og_image'],
    'og_url'            => $data['og_url'],
    'seo_description'   => $data['seo_description'],
    'seo_keywords'      => $data['seo_keywords'],
    'category'          => $data['category']
])

@section('title')
    {{ $data->title }}
@endsection

@php
    $category           = $data['category'];
    $list_posts         = $data['category']->posts;
    $viewed_post        = $data['viewed_post'];

@endphp

@section($data->content)
    @include('frontend.includes.breadcrumb')

    <div class="ereaders-main-content">
        <div class="ereaders-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ereaders-blog ereaders-blog-grid">
                            <ul class="row">

                                @if(!empty($list_posts) && count($list_posts) > 0)
                                    {!! render_posts($list_posts) !!}
                                @endif

                            </ul>
                        </div>

                        {{ $data['pagiante']->links('frontend.includes.pagination',['alias' => $data['category']['alias'], 'paginator' => $data['category']['pagiante']]) }}

                        @if(!empty($viewed_post) && count($viewed_post) > 0)
                            <h3 class="ereaders-section-heading">Bài Viết Đã Xem</h3>
                            <div class="ereaders-blog ereaders-blog-grid">
                                <ul class="row">
                                    {!! render_posts($viewed_post) !!}
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
